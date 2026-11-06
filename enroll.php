<?php
require __DIR__ . '/config.php'; require_login();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { header('Location: index.php'); exit; }
$check = $pdo->prepare("SELECT id FROM courses WHERE id=?"); $check->execute([$id]);
if (!$check->fetch()) { http_response_code(404); exit('Course not found.'); }
$stmt = $pdo->prepare("INSERT IGNORE INTO enrollments (user_id,course_id) VALUES (?,?)");
$stmt->execute([$_SESSION['user_id'],$id]);
header('Location: dashboard.php'); exit;
