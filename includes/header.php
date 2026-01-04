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
        <a class="navbar-brand fw-bold" href="/dashboard.php" style="visibility:hidden;">&nbsp;</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
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
                    <li class="nav-item"><a class="nav-link text-danger" href="/ELearning/logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
