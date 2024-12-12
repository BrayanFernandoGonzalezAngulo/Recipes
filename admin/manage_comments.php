<?php
session_start();
include '../includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Manejar eliminación de comentarios
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM comments WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: manage_comments.php');
    exit;
}

// Obtener comentarios
$stmt = $pdo->query('
    SELECT c.id, c.content, c.created_at, u.username, r.title
    FROM comments c
    JOIN users u ON c.user_id = u.id
    JOIN recipes r ON c.recipe_id = r.id
    ORDER BY c.created_at DESC
');
$comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Comentarios</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Administrar Comentarios</h1>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Receta</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($comment['username']); ?></td>
                    <td><?php echo htmlspecialchars($comment['title']); ?></td>
                    <td><?php echo htmlspecialchars($comment['content']); ?></td>
                    <td><?php echo $comment['created_at']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $comment['id']; ?>" onclick="return confirm('¿Eliminar este comentario?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Volver al Panel</a>
</body>
</html>
