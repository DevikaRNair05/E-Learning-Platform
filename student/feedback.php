<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chapter_id = intval($_POST['chapter_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);
    // Insert or update feedback
    $stmt = $conn->prepare("SELECT id FROM feedback WHERE user_id = ? AND chapter_id = ?");
    $stmt->bind_param('ii', $user_id, $chapter_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        $stmt2 = $conn->prepare("UPDATE feedback SET rating=?, comment=? WHERE user_id=? AND chapter_id=?");
        $stmt2->bind_param('isii', $rating, $comment, $user_id, $chapter_id);
        $stmt2->execute();
        $stmt2->close();
    } else {
        $stmt->close();
        $stmt2 = $conn->prepare("INSERT INTO feedback (user_id, chapter_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param('iiis', $user_id, $chapter_id, $rating, $comment);
        $stmt2->execute();
        $stmt2->close();
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Thank you for your feedback!</h2>
    <div class="text-center">
        <a href="course_list.php" class="btn btn-primary">Back to Courses</a>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
