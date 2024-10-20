<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_username = $_POST['full_username'];
    $password = $_POST['password'];
    $server = explode('>', $full_username)[0];

    if ($server !== $_SERVER['SERVER_NAME']) {
        echo 'You can only log in on the server where your account was created.';
    } else if ($user_id = authenticate_user($full_username, $password)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        echo 'Logged in successfully!';
    } else {
        echo 'Invalid credentials.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sherrylock</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <label for="full_username">Full Username (e.g., sherrylock.example.com>username):</label>
            <input type="text" id="full_username" name="full_username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>