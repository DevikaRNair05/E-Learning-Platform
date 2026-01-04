


<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
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
<?php require_once '../includes/footer.php'; ?>
