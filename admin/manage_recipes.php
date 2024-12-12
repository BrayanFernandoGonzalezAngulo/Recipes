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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Recetas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Administrar Recetas</h1>
    <table>
        <thead>
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
                        <a href="?delete=<?php echo $recipe['id']; ?>" onclick="return confirm('¿Eliminar esta receta?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Volver al Panel</a>
</body>
</html>
