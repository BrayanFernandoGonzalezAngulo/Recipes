<?php
session_start();
include 'includes/db.php';

// Obtener recetas destacadas
$stmt = $pdo->query('
    SELECT r.id, r.title, r.description, r.image, c.name AS category
    FROM recipes r
    JOIN categories c ON r.category_id = c.id
    ORDER BY r.created_at DESC LIMIT 10
');
$recipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gestor de Recetas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Recetas Destacadas</h1>
    <div class="recipes">
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe">
                <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
                <p><strong>Categoría:</strong> <?php echo htmlspecialchars($recipe['category']); ?></p>
                <p><?php echo htmlspecialchars($recipe['description']); ?></p>
                <?php if ($recipe['image']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($recipe['image']); ?>" alt="Imagen de la receta">
                <?php endif; ?>
                <a href="recipe.php?id=<?php echo $recipe['id']; ?>">Ver Detalles</a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <a href="login.php">Iniciar Sesión</a>
    <?php endif; ?>
</body>
</html>
