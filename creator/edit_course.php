<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

if ($_SESSION['role'] !== 'creator') {
    header('Location: ../dashboard.php');
    exit();
}

// Get course id from query string
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$creator_id = $_SESSION['user_id'];

// Check if course belongs to this creator
$course = null;
if ($course_id) {
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ? AND creator_id = ?");
    $stmt->bind_param('ii', $course_id, $creator_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $stmt->close();
}
if (!$course) {
    echo '<div class="container mt-5"><div class="alert alert-danger">Invalid course or permission denied.</div></div>';
    require_once '../includes/footer.php';
    exit();
}

$message = '';
$edit_chapter = null;
// Handle edit request
if (isset($_GET['edit_chapter_id'])) {
    $edit_id = intval($_GET['edit_chapter_id']);
    $stmt = $conn->prepare("SELECT * FROM chapters WHERE id = ? AND course_id = ?");
    $stmt->bind_param('ii', $edit_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_chapter = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['chapter_id']) && $_POST['chapter_id'] !== '') {
        // Update existing chapter
        $chapter_id = intval($_POST['chapter_id']);
        $chapter_title = trim($_POST['chapter_title']);
        $chapter_content = trim($_POST['chapter_content']);
        $video_url = isset($_POST['video_url']) ? trim($_POST['video_url']) : '';
        $stmt = $conn->prepare("UPDATE chapters SET title=?, content=?, video_url=? WHERE id=? AND course_id=?");
        $stmt->bind_param('sssii', $chapter_title, $chapter_content, $video_url, $chapter_id, $course_id);
        $stmt->execute();
        $stmt->close();
        $message = 'Chapter updated successfully!';
    } else {
        // Add new chapter
        $chapter_title = trim($_POST['chapter_title']);
        $chapter_content = trim($_POST['chapter_content']);
        $video_url = isset($_POST['video_url']) ? trim($_POST['video_url']) : '';
        // Get next chapter order
        $result = $conn->query("SELECT MAX(`order`) FROM chapters WHERE course_id = $course_id");
        $row = $result->fetch_row();
        $order = $row[0] ? $row[0] + 1 : 1;
        $stmt = $conn->prepare("INSERT INTO chapters (course_id, title, content, video_url, `order`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('isssi', $course_id, $chapter_title, $chapter_content, $video_url, $order);
        $stmt->execute();
        $stmt->close();
        $message = 'Chapter uploaded successfully!';
    }
    // Refresh edit_chapter after update
    $edit_chapter = null;
}
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Course & Upload Chapters</h2>
    <h4 class="mb-3">Course: <?php echo htmlspecialchars($course['title']); ?></h4>
    <?php if ($message): ?>
        <div class="alert alert-success text-center"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" class="mx-auto" style="max-width:600px;">
        <input type="hidden" name="chapter_id" value="<?php echo $edit_chapter ? htmlspecialchars($edit_chapter['id']) : ''; ?>">
        <div class="mb-3">
            <label for="chapter_title" class="form-label">Chapter Title</label>
            <input type="text" class="form-control" id="chapter_title" name="chapter_title" required value="<?php echo $edit_chapter ? htmlspecialchars($edit_chapter['title']) : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="chapter_content" class="form-label">Chapter Content</label>
            <textarea name="chapter_content" id="editor" class="form-control" rows="8"><?php echo $edit_chapter ? htmlspecialchars($edit_chapter['content']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="video_url" class="form-label">Video Link (YouTube, etc.)</label>
            <input type="url" class="form-control" id="video_url" name="video_url" placeholder="https://..." value="<?php echo $edit_chapter ? htmlspecialchars($edit_chapter['video_url']) : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary w-100"><?php echo $edit_chapter ? 'Update Chapter' : 'Upload Chapter'; ?></button>
    </form>
    <hr>
    <h5>Chapters</h5>
    <ul class="list-group mb-4">
        <?php
        $chapters = $conn->query("SELECT * FROM chapters WHERE course_id = $course_id ORDER BY `order`");
        while ($ch = $chapters->fetch_assoc()): ?>
            <li class="list-group-item">
                <strong><?php echo htmlspecialchars($ch['title']); ?></strong>
                <?php if (!empty($ch['video_url'])): ?>
                    <br><a href="<?php echo htmlspecialchars($ch['video_url']); ?>" target="_blank" class="text-primary">Video Link</a>
                <?php endif; ?>
                <a href="?course_id=<?php echo $course_id; ?>&edit_chapter_id=<?php echo $ch['id']; ?>" class="btn btn-sm btn-secondary float-end ms-2">Edit</a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
<!-- CKEditor 4 CDN -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
<?php require_once '../includes/footer.php'; ?>