<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Manejar creación de categorías
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$name]);
    }
    header('Location: category.php');
    exit;
}

// Manejar eliminación de categorías
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: category.php');
    exit;
}

// Obtener categorías
$stmt = $pdo->query('SELECT * FROM categories ORDER BY created_at DESC');
$categories = $stmt->fetchAll();
// Incluir el encabezado común
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Categorías</h1>
        <form method="post" action="" class="form-inline mb-4">
            <div class="form-group mr-2">
                <input type="text" name="name" class="form-control" placeholder="Nueva categoría" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
        <ul class="list-group">
            <?php foreach ($categories as $category): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($category['name']); ?>
                    <a href="?delete=<?php echo $category['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="home.php" class="btn btn-secondary mt-4">Volver a Inicio</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
// Incluir el pie de página
include 'includes/footer.php'; 
?>