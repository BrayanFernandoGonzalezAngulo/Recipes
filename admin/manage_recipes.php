<?php
session_start();
include '../includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Manejar eliminación de recetas
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: manage_recipes.php');
    exit;
}

// Obtener recetas
$stmt = $pdo->query('
    SELECT r.id, r.title, r.description, r.created_at, c.name AS category
    FROM recipes r
    JOIN categories c ON r.category_id = c.id
    ORDER BY r.created_at DESC
');
$recipes = $stmt->fetchAll();
// Incluir el encabezado común
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Recetas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Administrar Recetas</h1>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recipes as $recipe): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($recipe['title']); ?></td>
                        <td><?php echo htmlspecialchars($recipe['category']); ?></td>
                        <td><?php echo htmlspecialchars($recipe['description']); ?></td>
                        <td><?php echo $recipe['created_at']; ?></td>
                        <td>
                            <a href="?delete=<?php echo $recipe['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta receta?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-primary">Volver al Panel</a>
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