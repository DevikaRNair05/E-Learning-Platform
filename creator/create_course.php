<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

if ($_SESSION['role'] !== 'creator') {
    header('Location: ../dashboard.php');
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $is_free = intval($_POST['is_free']);
    $creator_id = $_SESSION['user_id'];

    // Enforce only one free course
    if ($is_free) {
        $result = $conn->query("SELECT COUNT(*) FROM courses WHERE is_free = 1");
        $row = $result->fetch_row();
        if ($row[0] > 0) {
            $is_free = 0;
            $message = "Only one course can be free. This course will be locked.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO courses (title, description, creator_id, is_free, locked) VALUES (?, ?, ?, ?, ?)");
    $locked = $is_free ? 0 : 1;
    $stmt->bind_param('ssiii', $title, $description, $creator_id, $is_free, $locked);
    $stmt->execute();
    $stmt->close();
    $message = $message ?: "Course created successfully!";
}
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Create Course</h2>
    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" class="mx-auto" style="max-width:500px;">
        <div class="mb-3">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="is_free" class="form-label">Is this course free?</label>
            <select class="form-control" id="is_free" name="is_free">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Create Course</button>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>