<?php
require_once 'config.php';

function fetch_latest_release() {
    $url = 'https://api.github.com/repos/wavlo/sherrylock/releases/latest';
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => [
                'User-Agent: PHP',
                'Content-Type: application/json'
            ]
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    return json_decode($response, true);
}

function fetch_public_servers() {
    $url = 'https://raw.githubusercontent.com/wavlo/sherrytxt/main/list.txt';
    return file($url, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function create_user($username, $password, $server) {
    global $mysqli;
    $full_username = "$server>$username";
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("INSERT INTO users (username, server, full_username, password_hash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $username, $server, $full_username, $password_hash);
    return $stmt->execute();
}

function authenticate_user($full_username, $password) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, password_hash, server FROM users WHERE full_username = ?");
    $stmt->bind_param('s', $full_username);
    $stmt->execute();
    $stmt->bind_result($user_id, $password_hash, $server);
    $stmt->fetch();

    if ($server !== $_SERVER['SERVER_NAME']) {
        return false; 
    }

    if (password_verify($password, $password_hash)) {
        return $user_id;
    } else {
        return false;
    }
}

function create_post($user_id, $content) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->bind_param('is', $user_id, $content);
    return $stmt->execute();
}

function get_posts() {
    global $mysqli;
    $result = $mysqli->query("SELECT u.full_username, p.content, p.created_at FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function sync_posts_from_server($server_url) {
    $url = $server_url . '/api/posts';
    $posts = json_decode(file_get_contents($url), true);
    foreach ($posts as $post) {
        create_post($post['user_id'], $post['content']);
    }
}
?>
