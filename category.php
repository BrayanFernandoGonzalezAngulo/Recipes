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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Gestión de Categorías</h1>
    <form method="post" action="">
        <input type="text" name="name" placeholder="Nueva categoría" required>
        <button type="submit">Agregar</button>
    </form>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <?php echo htmlspecialchars($category['name']); ?>
                <a href="?delete=<?php echo $category['id']; ?>" onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="home.php">Volver a Inicio</a>
</body>
</html>
