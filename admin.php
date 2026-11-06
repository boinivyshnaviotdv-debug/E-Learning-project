<?php
require __DIR__ . '/config.php'; require_login();
if (($_SESSION['role'] ?? '') !== 'admin') { http_response_code(403); exit('Access denied.'); }
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_course'])) {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $instructor = trim($_POST['instructor'] ?? '');
        if ($title !== '' && $description !== '' && $instructor !== '') {
            $stmt = $pdo->prepare("INSERT INTO courses (title,description,instructor) VALUES (?,?,?)");
            $stmt->execute([$title,$description,$instructor]);
            $message = 'Course added successfully.';
        } else { $message = 'Please complete all course fields.'; }
    }
    if (isset($_POST['delete_course'])) {
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id=?");
        $stmt->execute([(int)$_POST['delete_course']]);
        $message = 'Course deleted.';
    }
}
$courses = $pdo->query("SELECT id,title,instructor FROM courses ORDER BY created_at DESC")->fetchAll();
?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin | LearnHub</title><link rel="stylesheet" href="style.css"></head><body><header class="topbar"><a class="brand" href="index.php">LearnHub</a><nav><a href="dashboard.php">Dashboard</a><a href="logout.php">Logout</a></nav></header><main class="section"><span class="eyebrow">ADMIN AREA</span><h1>Manage courses</h1><?php if($message): ?><p class="success"><?= h($message) ?></p><?php endif; ?><form class="auth-card" method="post"><h2>Add a course</h2><label>Course title<input name="title" required maxlength="180"></label><label>Description<input name="description" required></label><label>Instructor<input name="instructor" required maxlength="120"></label><button class="btn" name="add_course" value="1">Add course</button></form><h2 style="margin-top:40px">Existing courses</h2><div class="course-grid"><?php foreach($courses as $c): ?><article class="course course-body"><h3><?= h($c['title']) ?></h3><small>Instructor: <?= h($c['instructor']) ?></small><form method="post" onsubmit="return confirm('Delete this course?')"><button class="btn" style="background:#9b332d" name="delete_course" value="<?= (int)$c['id'] ?>">Delete course</button></form></article><?php endforeach; ?></div></main></body></html>
