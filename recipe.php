<?php
session_start();
include 'includes/db.php';

// Obtener receta
$recipe_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $pdo->prepare('
    SELECT r.title, r.description, r.ingredients, r.instructions, r.image, c.name AS category
    FROM recipes r
    JOIN categories c ON r.category_id = c.id
    WHERE r.id = ?
');
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    header('Location: home.php');
    exit;
}

// Manejar comentarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content']) && isset($_SESSION['user_id'])) {
    $content = trim($_POST['content']);
    if (!empty($content)) {
        $stmt = $pdo->prepare('INSERT INTO comments (recipe_id, user_id, content) VALUES (?, ?, ?)');
        $stmt->execute([$recipe_id, $_SESSION['user_id'], $content]);
    }
    header("Location: recipe.php?id=$recipe_id");
    exit;
}

// Obtener comentarios
$stmt = $pdo->prepare('
    SELECT c.content, u.username, c.created_at
    FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.recipe_id = ?
    ORDER BY c.created_at DESC
');
$stmt->execute([$recipe_id]);
$comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - Detalles</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($recipe['category']); ?></p>
    <p><?php echo htmlspecialchars($recipe['description']); ?></p>
    <p><strong>Ingredientes:</strong></p>
    <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
    <p><strong>Instrucciones:</strong></p>
    <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
    <?php if ($recipe['image']): ?>
        <img src="uploads/<?php echo htmlspecialchars($recipe['image']); ?>" alt="Imagen de la receta">
    <?php endif; ?>

    <h2>Comentarios</h2>
    <div class="comments">
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <?php echo htmlspecialchars($comment['content']); ?></p>
                <small>Publicado el <?php echo $comment['created_at']; ?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="post" action="">
            <textarea name="content" placeholder="Escribe un comentario..." required></textarea>
            <button type="submit">Comentar</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Inicia sesión</a> para comentar.</p>
    <?php endif; ?>

    <a href="home.php">Volver a Inicio</a>
</body>
</html>
