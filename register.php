<?php
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || strlen($password) < 6) {
        $error = 'Username is required and password must be at least 6 characters.';
    } else {
        try {
            $statement = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (?, ?)');
            $statement->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
            redirect('login.php');
        } catch (PDOException $exception) {
            $error = 'That username is already in use.';
        }
    }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Create Account</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="auth-page"><div class="login-container"><h2>Create Account</h2><?php if ($error): ?><p class="form-error"><?= e($error) ?></p><?php endif; ?><form method="post"><label for="username">Username</label><input id="username" name="username" required><label for="password">Password</label><input id="password" name="password" type="password" minlength="6" required><button type="submit">Register</button></form><p><a href="login.php">Back to login</a></p></div></body></html>
