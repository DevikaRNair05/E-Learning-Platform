<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $search = strtolower($search);
    $stmt = $conn->prepare("SELECT * FROM courses WHERE LOWER(title) LIKE CONCAT('%', ?, '%') OR LOWER(description) LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param('ss', $search, $search);
    $stmt->execute();
    $courses = $stmt->get_result();
} else {
    $courses = $conn->query("SELECT * FROM courses");
}
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Courses</h2>
    <form class="mb-4" method="get" action="">
        <div class="input-group" style="max-width:400px;margin:0 auto;">
            <input type="text" class="form-control" name="search" placeholder="Search for courses..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
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
            <div class="col-12"><p class="text-danger text-center fw-bold">Course not available.</p></div>
        <?php endif; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
