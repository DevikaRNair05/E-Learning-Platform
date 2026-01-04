<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chapter_id = intval($_POST['chapter_id']);
    // Get course_id for redirect
    $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
    $stmt_ch = $conn->prepare("SELECT course_id FROM chapters WHERE id = ?");
    $stmt_ch->bind_param('i', $chapter_id);
    $stmt_ch->execute();
    $stmt_ch->bind_result($db_course_id);
    $stmt_ch->fetch();
    $stmt_ch->close();
    if (!empty($db_course_id)) {
        $course_id = $db_course_id;
    }
    // Mark as complete in feedback table (only update/insert 'completed' field)
    $stmt = $conn->prepare("SELECT id FROM feedback WHERE user_id = ? AND chapter_id = ?");
    $stmt->bind_param('ii', $user_id, $chapter_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $stmt2 = $conn->prepare("UPDATE feedback SET completed = 1 WHERE user_id = ? AND chapter_id = ?");
        $stmt2->bind_param('ii', $user_id, $chapter_id);
        $stmt2->execute();
        $stmt2->close();
    } else {
        $stmt->close();
        $stmt2 = $conn->prepare("INSERT INTO feedback (user_id, chapter_id, completed) VALUES (?, ?, 1)");
        $stmt2->bind_param('ii', $user_id, $chapter_id);
        $stmt2->execute();
        $stmt2->close();
    }
    if (!empty($course_id)) {
        header('Location: take_course.php?course_id=' . $course_id . '&chapter_id=' . $chapter_id);
    } else {
        header('Location: take_course.php');
    }
    exit();
}
