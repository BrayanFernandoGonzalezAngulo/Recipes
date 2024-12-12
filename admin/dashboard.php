<?php
session_start();
include '../includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
// Incluir el encabezado común
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main class="container mt-5">
        <h1 class="mb-4">Panel de Administración</h1>
        <p class="lead">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>. Aquí puedes gestionar las funciones administrativas.</p>
        
        <section class="admin-links">
            <ul class="list-group">
                <li class="list-group-item"><a href="manage_categories.php">Gestionar Categorías</a></li>
                <li class="list-group-item"><a href="manage_recipes.php">Gestionar Recetas</a></li>
                <li class="list-group-item"><a href="manage_comments.php">Gestionar Comentarios</a></li>
            </ul>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
// Incluir el pie de página
include 'includes/footer.php'; 
?>