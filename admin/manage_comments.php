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
// Incluir el encabezado común
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Comentarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Administrar Comentarios</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
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
                            <a href="?delete=<?php echo $comment['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este comentario?')">Eliminar</a>
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