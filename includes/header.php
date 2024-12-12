<?php
session_start();
?>
<header>
    <h1>Gestor de Recetas</h1>
    <nav>
        <ul>
            <li><a href="home.php">Inicio</a></li>
            <li><a href="category.php">Categorías</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="profile.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
                <li><a href="register.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
