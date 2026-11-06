<?php
require __DIR__ . '/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Enter your name, a valid email and a password of at least 8 characters.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash) VALUES (?,?,?)");
            $stmt->execute([$name,$email,password_hash($password, PASSWORD_DEFAULT)]);
            header('Location: login.php?registered=1'); exit;
        } catch (PDOException $e) { $error = 'That email may already be registered.'; }
    }
}
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register | LearnHub</title><link rel="stylesheet" href="style.css"></head><body><header class="topbar"><a class="brand" href="index.php">LearnHub</a><nav><a href="index.php">Home</a><a href="login.php">Login</a></nav></header><main class="auth-wrap"><form class="auth-card" method="post"><span class="eyebrow">CREATE YOUR ACCOUNT</span><h1>Join LearnHub</h1><?php if($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?><label>Full name<input name="name" required maxlength="100" value="<?= h($_POST['name'] ?? '') ?>"></label><label>Email address<input type="email" name="email" required value="<?= h($_POST['email'] ?? '') ?>"></label><label>Password<input type="password" name="password" required minlength="8"></label><button class="btn" type="submit">Create account</button><p class="muted">Already registered? <a href="login.php">Log in</a></p></form></main></body></html>
