<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Creator Dashboard</h2>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <a href="create_course.php" class="card card-link text-decoration-none text-dark p-4 mb-3 shadow">
                <h4 class="text-center">Create Course</h4>
            </a>
        </div>
        <div class="col-md-4">
            <a href="my_courses.php" class="card card-link text-decoration-none text-dark p-4 mb-3 shadow">
                <h4 class="text-center">My Courses</h4>
            </a>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
