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

<style>
    .feedback-section {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px 0 rgba(31, 38, 135, 0.10);
        padding: 2.5rem 2rem 2rem 2rem;
        margin-top: 3rem;
        margin-bottom: 2rem;
    }
    .feedback-table th, .feedback-table td {
        vertical-align: middle;
        text-align: center;
    }
    .feedback-table th {
        background: #f6f7fb;
        color: #2d2350;
        font-weight: 700;
        font-size: 1.08rem;
    }
    .feedback-table td {
        font-size: 1.01rem;
        color: #333;
    }
    .feedback-table tr:nth-child(even) {
        background: #f9f9fc;
    }
    .feedback-stars {
        color: #f7b731;
        font-size: 1.2em;
        letter-spacing: 1px;
    }
    .feedback-section h3 {
        font-weight: 700;
        color: #222;
        margin-bottom: 1.7rem;
    }
</style>
<div class="container feedback-section">
    <h3 class="text-center">Feedback & Ratings for My Courses</h3>
    <div class="table-responsive">
        <?php
        // Fetch all course-level feedback for this creator's courses
        $sql = "SELECT f.*, c.title AS course_title, u.name AS student_name FROM feedback f
                JOIN courses c ON f.course_id = c.id
                JOIN users u ON f.user_id = u.id
                WHERE f.chapter_id IS NULL AND c.creator_id = ?
                ORDER BY f.id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $creator_id);
        $stmt->execute();
        $result = $stmt->get_result();

        ?>
        <table class="table feedback-table align-middle mb-0">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Student</th>
                    <th>Rating</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['course_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td class="feedback-stars"><?php echo str_repeat('★', (int)$row['rating']); ?></td>
                            <td style="text-align:left;"><?php echo nl2br(htmlspecialchars($row['comment'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">No feedback found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php $stmt->close(); ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>