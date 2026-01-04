<?php
// Dashboard statistics for admin
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Get total students
$student_sql = "SELECT COUNT(*) FROM users WHERE role = 'student'";
$student_count = $conn->query($student_sql)->fetch_row()[0];

// Get total instructors/creators
$instructor_sql = "SELECT COUNT(*) FROM users WHERE role = 'creator'";
$instructor_count = $conn->query($instructor_sql)->fetch_row()[0];

// Get total courses
$course_sql = "SELECT COUNT(*) FROM courses";
$course_count = $conn->query($course_sql)->fetch_row()[0];

header('Content-Type: application/json');
echo json_encode([
    'students' => $student_count,
    'instructors' => $instructor_count,
    'courses' => $course_count
]);
