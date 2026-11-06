<?php
require __DIR__ . '/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT id,name,email,password_hash,role FROM users WHERE email=?");
    $stmt->execute([$email]); $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id']; $_SESSION['name'] = $user['name']; $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Incorrect email or password.';
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login | LearnHub</title><link rel="stylesheet" href="style.css"></head><body><header class="topbar"><a class="brand" href="index.php">LearnHub</a><nav><a href="index.php">Home</a><a href="register.php">Register</a></nav></header><main class="auth-wrap"><form class="auth-card" method="post"><span class="eyebrow">WELCOME BACK</span><h1>Log in</h1><?php if(isset($_GET['registered'])): ?><p class="success">Account created. You can now log in.</p><?php endif; ?><?php if($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?><label>Email address<input type="email" name="email" required></label><label>Password<input type="password" name="password" required></label><button class="btn" type="submit">Login</button><p class="muted">New here? <a href="register.php">Create an account</a></p></form></main></body></html>
