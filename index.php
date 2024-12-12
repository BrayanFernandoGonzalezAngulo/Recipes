<?php
session_start();
// Incluir el encabezado común
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Recetas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="bg-primary text-white text-center py-3">
        <h1>Bienvenido al Gestor de Recetas</h1>
    </header>
    <main class="container mt-4">
        <div class="text-center">
            <p>Descubre, comparte y gestiona recetas increíbles.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                <a href="register.php" class="btn btn-secondary">Registrarse</a>
            <?php else: ?>
                <a href="home.php" class="btn btn-primary">Ir a Inicio</a>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <?php endif; ?>
        </div>
    </main>
    <footer class="bg-light text-center py-3 mt-4">
        <p>&copy; 2024 Gestor de Recetas. Todos los derechos reservados.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
// Incluir el pie de página
include 'includes/footer.php'; 
?>