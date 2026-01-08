<?php
// Role-based header include
$session_status = session_status();
if ($session_status === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELearning Platform</title>
    <link rel="stylesheet" href="/ELearning/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold main-title" href="/dashboard.php" style="color:#7f53ac; font-size:2rem; letter-spacing:1px;">
            <i class="bi bi-mortarboard-fill me-2" style="color:#647dee;"></i>ELearning
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <?php if ($role == 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="/ELearning/admin/dashboard.php">Dashboard</a></li> 
                <?php elseif ($role == 'creator'): ?>
                    <li class="nav-item"><a class="nav-link" href="/ELearning/creator/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/ELearning/creator/create_course.php">Create Course</a></li>
                    <li class="nav-item"><a class="nav-link" href="/ELearning/creator/my_courses.php">My Courses</a></li>
                <?php elseif ($role == 'student'): ?>
                    <li class="nav-item"><a class="nav-link" href="/ELearning/student/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/ELearning/student/course_list.php">Courses</a></li>
                <?php endif; ?>
                <?php if ($role): ?>
                    <li class="nav-item ms-lg-3"><a class="btn main-btn" href="/ELearning/logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
