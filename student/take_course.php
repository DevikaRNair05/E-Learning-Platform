<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
if (!$course_id) {
    echo '<div class="container mt-5"><div class="alert alert-danger">Invalid course.</div></div>';
    require_once '../includes/footer.php';
    exit();
}

$course = $conn->query("SELECT * FROM courses WHERE id = $course_id")->fetch_assoc();
if (!$course) {
    echo '<div class="container mt-5"><div class="alert alert-danger">Course not found.</div></div>';
    require_once '../includes/footer.php';
    exit();
}

// Fetch chapters
$chapters = $conn->query("SELECT * FROM chapters WHERE course_id = $course_id ORDER BY `order`");
$chapter_list = [];
while ($row = $chapters->fetch_assoc()) {
    $chapter_list[] = $row;
}
// Fetch completed chapters for this user
$user_id = $_SESSION['user_id'];
$completed_chapters = [];
$result = $conn->query("SELECT chapter_id FROM feedback WHERE user_id = $user_id AND completed = 1");
while ($row = $result->fetch_assoc()) {
    $completed_chapters[] = $row['chapter_id'];
}
$chapter_id = isset($_GET['chapter_id']) ? intval($_GET['chapter_id']) : (count($chapter_list) ? $chapter_list[0]['id'] : 0);
$current_chapter = null;
foreach ($chapter_list as $ch) {
    if ($ch['id'] == $chapter_id) {
        $current_chapter = $ch;
        break;
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center mb-4"><?php echo htmlspecialchars($course['title']); ?></h2>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="list-group">
                <?php foreach ($chapter_list as $ch): ?>
                    <a href="take_course.php?course_id=<?php echo $course_id; ?>&chapter_id=<?php echo $ch['id']; ?>" class="list-group-item list-group-item-action<?php if ($ch['id'] == $chapter_id) echo ' active'; ?>">
                        <?php echo htmlspecialchars($ch['title']); ?>
                        <?php if (in_array($ch['id'], $completed_chapters)): ?>
                            <span style="color:green; font-size:1.2em; margin-left:8px;" title="Completed">&#10003;</span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-9">
            <?php if ($current_chapter): ?>
                <div class="card p-4 mb-4">
                    <h3 class="chapter-title text-center text-dark"><?php echo htmlspecialchars($current_chapter['title']); ?></h3>
                    <div class="chapter-content mb-3"><?php echo $current_chapter['content']; ?></div>
                    <?php if (!empty($current_chapter['video_url'])): ?>
                        <div class="mb-3"><a href="<?php echo htmlspecialchars($current_chapter['video_url']); ?>" target="_blank" class="btn btn-outline-primary">Watch Video</a></div>
                    <?php endif; ?>
                    <form method="post" action="feedback.php" class="mb-3">
                        <input type="hidden" name="chapter_id" value="<?php echo $current_chapter['id']; ?>">
                        <label>Rate this chapter:</label>
                        <select name="rating" required class="form-select mb-2">
                            <option value="5">⭐⭐⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="1">⭐</option>
                        </select>
                        <textarea name="comment" class="form-control mb-2" placeholder="Your feedback..." required></textarea>
                        <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
                    </form>
                    <form method="post" action="mark_complete.php">
                        <input type="hidden" name="chapter_id" value="<?php echo $current_chapter['id']; ?>">
                        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                        <button type="submit" class="btn btn-success w-100">Mark as Complete</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No chapters available for this course.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
