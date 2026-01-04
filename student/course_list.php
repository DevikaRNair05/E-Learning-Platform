<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

$courses = $conn->query("SELECT * FROM courses");
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Courses</h2>
    <div class="row">
        <?php if ($courses && $courses->num_rows > 0): ?>
            <?php while ($course = $courses->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card p-3 shadow position-relative">
                        <h4><?php echo htmlspecialchars($course['title']); ?></h4>
                        <p><?php echo htmlspecialchars($course['description']); ?></p>
                        <?php if ($course['is_free']): ?>
                            <a href="take_course.php?course_id=<?php echo $course['id']; ?>" class="btn btn-success w-100 mt-2">Start Learning</a>
                        <?php else: ?>
                            <button class="btn btn-secondary w-100 mt-2" disabled>Locked</button>
                            <span class="position-absolute top-0 end-0 badge bg-danger">Locked</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12"><p>No courses available.</p></div>
        <?php endif; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
