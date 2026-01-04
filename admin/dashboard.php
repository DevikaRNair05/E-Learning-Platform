


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
</style>
<div class="admin-dashboard-bg py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold" style="color:#222;">Admin Dashboard</h2>
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
<?php require_once '../includes/footer.php'; ?>
