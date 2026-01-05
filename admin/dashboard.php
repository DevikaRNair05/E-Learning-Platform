


<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';
?>
<style>
.admin-dashboard-bg {
    background: linear-gradient(135deg, #f3e7fe 0%, #e3f0ff 100%);
    min-height: 100vh;
}
.admin-card {
    border-radius: 24px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    background: #fff;
    border: none;
}
.admin-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 16px 40px 0 rgba(31, 38, 135, 0.15);
}
.admin-icon {
    font-size: 2.5rem;
    color: #7c3aed;
    margin-bottom: 12px;
}
.stat-card {
    min-width: 200px;
    border-radius: 16px;
    box-shadow: 0 4px 16px 0 rgba(31, 38, 135, 0.08);
    background: #fff;
    padding: 24px 16px;
    text-align: center;
    margin-bottom: 20px;
}
.stat-icon {
    font-size: 2.2rem;
    color: #2563eb;
    margin-bottom: 8px;
}
.stat-label {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 4px;
}
.stat-value {
    font-size: 2rem;
    font-weight: bold;
    color: #222;
}
</style>
<div class="admin-dashboard-bg py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold" style="color:#222;">Admin Dashboard</h2>
        <div class="row justify-content-center mb-4 g-4">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="bi bi-people"></span>
                    </div>
                    <div class="stat-label">Total Students</div>
                    <div class="stat-value" id="stat-students">-</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="bi bi-person-badge"></span>
                    </div>
                    <div class="stat-label">Total Instructors</div>
                    <div class="stat-value" id="stat-instructors">-</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <span class="bi bi-book"></span>
                    </div>
                    <div class="stat-label">Courses Available</div>
                    <div class="stat-value" id="stat-courses">-</div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <a href="invite_creator.php" class="text-decoration-none">
                    <div class="card admin-card text-center p-5 mb-3">
                        <div class="admin-icon mb-2">
                            <span class="bi bi-person-plus"></span>
                        </div>
                        <h4 class="fw-semibold">Invite Creator</h4>
                        <p class="text-muted">Send an invite to a new course creator</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="delete_course.php" class="text-decoration-none">
                    <div class="card admin-card text-center p-5 mb-3">
                        <div class="admin-icon mb-2">
                            <span class="bi bi-collection"></span>
                        </div>
                        <h4 class="fw-semibold">Manage Courses</h4>
                        <p class="text-muted">View and delete courses from the platform</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
// Fetch dashboard stats via AJAX
fetch('dashboard_stats.php')
  .then(res => res.json())
  .then(data => {
    document.getElementById('stat-students').textContent = data.students.toLocaleString();
    document.getElementById('stat-instructors').textContent = data.instructors.toLocaleString();
    document.getElementById('stat-courses').textContent = data.courses.toLocaleString();
  });
</script>


<style>
    .admin-feedback-card {
        border-radius: 24px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        background: #fff;
        border: none;
        padding: 2.5rem 2rem 2rem 2rem;
        margin-top: 2.5rem;
        margin-bottom: 2rem;
    }
    .admin-feedback-table th, .admin-feedback-table td {
        vertical-align: middle;
        text-align: center;
    }
    .admin-feedback-table th {
        background: #f6f7fb;
        color: #2d2350;
        font-weight: 700;
        font-size: 1.08rem;
    }
    .admin-feedback-table td {
        font-size: 1.01rem;
        color: #333;
    }
    .admin-feedback-table tr:nth-child(even) {
        background: #f9f9fc;
    }
    .admin-feedback-stars {
        color: #f7b731;
        font-size: 1.2em;
        letter-spacing: 1px;
    }
    .admin-feedback-card h3 {
        font-weight: 700;
        color: #222;
        margin-bottom: 1.7rem;
    }
</style>
<div class="container">
    <div class="admin-feedback-card">
        <h3 class="text-center mb-4">All Course Feedback & Ratings</h3>
        <div class="table-responsive">
            <?php
            // Fetch all course-level feedback (chapter_id IS NULL)
            $sql = "SELECT f.*, c.title AS course_title, u.name AS student_name FROM feedback f
                    JOIN courses c ON f.course_id = c.id
                    JOIN users u ON f.user_id = u.id
                    WHERE f.chapter_id IS NULL
                    ORDER BY f.id DESC";
            $result = $conn->query($sql);
            ?>
            <table class="table admin-feedback-table align-middle mb-0">
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
                                <td class="admin-feedback-stars"><?php echo str_repeat('★', (int)$row['rating']); ?></td>
                                <td style="text-align:left;"><?php echo nl2br(htmlspecialchars($row['comment'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No feedback found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
