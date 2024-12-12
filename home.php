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
// Incluir el encabezado común
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gestor de Recetas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Recetas Destacadas</h1>
        <div class="row">
            <?php foreach ($recipes as $recipe): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php if ($recipe['image']): ?>
                            <img src="uploads/<?php echo htmlspecialchars($recipe['image']); ?>" class="card-img-top" alt="Imagen de la receta">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                            <p class="card-text"><strong>Categoría:</strong> <?php echo htmlspecialchars($recipe['category']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($recipe['description']); ?></p>
                            <a href="recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center my-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-success">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
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