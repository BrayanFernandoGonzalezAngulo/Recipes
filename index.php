<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Recetas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenido al Gestor de Recetas</h1>
    </header>
    <main>
        <p>Descubre, comparte y gestiona recetas increíbles.</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php">Iniciar Sesión</a> | <a href="register.php">Registrarse</a>
        <?php else: ?>
            <a href="home.php">Ir a Inicio</a> | <a href="logout.php">Cerrar Sesión</a>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Gestor de Recetas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
