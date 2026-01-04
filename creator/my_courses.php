<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

if ($_SESSION['role'] !== 'creator') {
    header('Location: ../dashboard.php');
    exit();
}
$creator_id = $_SESSION['user_id'];
$courses = $conn->query("SELECT * FROM courses WHERE creator_id = $creator_id");
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">My Courses</h2>
    <div class="card p-4">
        <?php if ($courses && $courses->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
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
                            <td><?php echo $row['is_free'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $row['locked'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <a href="edit_course.php?course_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Manage Chapters</a>
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