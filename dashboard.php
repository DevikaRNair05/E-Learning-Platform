<?php
// dashboard.php - Role-based dashboard redirect
session_start();
require_once 'includes/auth.php';
$role = $_SESSION['role'] ?? '';
switch ($role) {
    case 'admin':
        header('Location: admin/dashboard.php');
        break;
    case 'creator':
        header('Location: creator/dashboard.php');
        break;
    case 'student':
        header('Location: student/dashboard.php');
        break;
    default:
        header('Location: index.php');
}
exit();
