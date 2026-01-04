<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

$message = '';
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    // Delete chapters first (to avoid FK constraint), then course
    $conn->query("DELETE FROM chapters WHERE course_id = $delete_id");
    $conn->query("DELETE FROM courses WHERE id = $delete_id");
    $message = 'Course deleted successfully.';
}
$courses = $conn->query("SELECT c.*, u.name AS creator_name FROM courses c LEFT JOIN users u ON c.creator_id = u.id");
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Delete Course</h2>
    <div class="card p-4">
        <?php if ($message): ?>
            <div class="alert alert-success text-center"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($courses && $courses->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Creator</th>
                        <th>Free</th>
                        <th>Locked</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $courses->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['creator_name']); ?></td>
                            <td><?php echo $row['is_free'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $row['locked'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No courses found.</p>
        <?php endif; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
