<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_username = $_POST['full_username'];
    $password = $_POST['password'];

    if ($user_id = authenticate_user($full_username, $password)) {
        echo '<div class="container"><p>Logged in successfully!</p></div>';
    } else {
        echo '<div class="container"><p class="error">Invalid credentials or wrong server.</p></div>';
    }
}
?>
<div class="container">
    <h2>Login</h2>
    <form method="POST">
        Full Username: <input type="text" name="full_username" required>
        Password: <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</div>
