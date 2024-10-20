<?php
require_once 'functions.php';

session_start();
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];

    if (create_post($user_id, $content)) {
        echo 'Post published successfully!';
    } else {
        echo 'Error publishing post.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post - Sherrylock</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Create a New Post</h1>
        <form method="POST">
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
            <button type="submit">Publish</button>
        </form>
    </div>
</body>
</html>