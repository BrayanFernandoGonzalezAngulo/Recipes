<?php
session_start();
include '../includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <h1>Panel de Administración</h1>
        <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>. Aquí puedes gestionar las funciones administrativas.</p>
        
        <section class="admin-links">
            <ul>
                <li><a href="manage_categories.php">Gestionar Categorías</a></li>
                <li><a href="manage_recipes.php">Gestionar Recetas</a></li>
                <li><a href="manage_comments.php">Gestionar Comentarios</a></li>
            </ul>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
