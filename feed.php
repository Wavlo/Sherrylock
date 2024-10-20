<?php
require_once 'functions.php';

$posts = get_posts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - Sherrylock</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Latest Posts</h1>
        <?php foreach ($posts as $post): ?>
            <p><strong><?= htmlspecialchars($post['full_username']) ?>:</strong> <?= htmlspecialchars($post['content']) ?> <em>(<?= $post['created_at'] ?>)</em></p>
        <?php endforeach; ?>
    </div>
</body>
</html>