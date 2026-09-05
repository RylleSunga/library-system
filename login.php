<?php
session_start();
require __DIR__ . '/includes/db_connect.php';
require __DIR__ . '/includes/functions.php';

$error = '';
$next = $_POST['next'] ?? $_GET['next'] ?? 'dashboard.php';
if (!preg_match('/^[A-Za-z0-9_\/-]+\.php$/', $next)) {
    $next = 'dashboard.php';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $statement = $pdo->prepare('SELECT id, username, password_hash, is_admin FROM users WHERE username = ?');
    $statement->execute([$username]);
    $user = $statement->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = (bool) $user['is_admin'];
        redirect($next);
    }
    $error = 'Invalid username or password.';
}
?>
<!doctype html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="auth-page"><div class="login-container"><h2>Login</h2><?php if ($error): ?><p class="form-error"><?= e($error) ?></p><?php endif; ?><form method="post"><input type="hidden" name="next" value="<?= e($next) ?>"><label for="username">Username</label><input id="username" name="username" required><label for="password">Password</label><input id="password" name="password" type="password" required><button type="submit">Login</button></form><p><a href="register.php">Create an account</a></p></div></body></html>
