
<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
$student_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Student';
$courses = $conn->query("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: #f7f9fa;
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        }
        .navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .navbar-brand {
            font-weight: 700;
            color: #5624d0 !important;
            font-size: 1.7rem;
        }
        .nav-link {
            color: #333 !important;
            font-weight: 500;
        }
        .btn-login {
            background: #fff;
            color: #5624d0;
            border: 2px solid #5624d0;
            border-radius: 20px;
            font-weight: 600;
            padding: 6px 22px;
            transition: background 0.2s, color 0.2s;
        }
        .btn-login:hover {
            background: #5624d0;
            color: #fff;
        }
        .hero {
            background: linear-gradient(90deg, #f7f9fa 60%, #e7e9fc 100%);
            padding: 40px 0 30px 0;
        }
        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d2f31;
        }
        .hero-desc {
            font-size: 1.1rem;
            color: #505763;
            margin-bottom: 1.5rem;
        }
        .search-bar {
            max-width: 500px;
            margin: 0 auto;
        }
        .featured-section {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px 0 rgba(31, 38, 135, 0.07);
            padding: 2rem 1.5rem;
            margin-top: -30px;
        }
        .course-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px 0 rgba(31, 38, 135, 0.06);
            transition: box-shadow 0.2s;
            margin-bottom: 1.5rem;
        }
        .course-card:hover {
            box-shadow: 0 6px 24px 0 rgba(31, 38, 135, 0.12);
        }
        .course-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d2f31;
        }
        .course-desc {
            color: #505763;
            font-size: 0.97rem;
        }
        .locked {
            opacity: 0.7;
            background: #f0f0f0;
            color: #bbb;
            position: relative;
        }
        .locked .badge {
            position: absolute;
            top: 10px;
            right: 14px;
            background: #e74c3c;
            color: #fff;
            font-size: 0.95rem;
            padding: 2px 10px;
            border-radius: 12px;
        }
        .footer {
            background: #fff;
            color: #888;
            padding: 1.5rem 0 0.5rem 0;
            text-align: center;
            margin-top: 3rem;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="../home.php">ELearning</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#courses">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="view_feedback.php">Feedback</a></li>
            </ul>
            <a href="../logout.php" class="btn btn-login ms-lg-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 3a1 1 0 0 1 1-1h3.5A1.5 1.5 0 0 1 12 3.5v9A1.5 1.5 0 0 1 10.5 14H7a1 1 0 0 1-1-1v-1h1v1h3.5a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5H7v1H6V3zm.146 4.146a.5.5 0 0 1 .708 0L9 9.293V5.5a.5.5 0 0 1 1 0v3.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"/></svg>Logout</a>
        </div>
    </div>
</nav>
<section class="hero text-center">
    <div class="container">
        <div class="hero-title mb-2">Welcome, <?php echo htmlspecialchars($student_name); ?>!</div>
        <div class="hero-desc mb-3">Find a course you want to learn and start your journey.</div>
        <form class="search-bar mb-3" method="get" action="course_list.php">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search for anything">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
</section>
<section id="courses" class="featured-section container mt-4">
    <h3 class="mb-4">Your Courses</h3>
    <div class="row g-4">
        <?php if ($courses && $courses->num_rows > 0): ?>
            <?php while ($course = $courses->fetch_assoc()): ?>
                <?php if ($course['is_free']): ?>
                <div class="col-md-4">
                    <a href="take_course.php?course_id=<?php echo $course['id']; ?>" class="card course-card p-3 text-decoration-none">
                        <div class="course-title mb-1"><?php echo htmlspecialchars($course['title']); ?></div>
                        <div class="course-desc mb-2"><?php echo htmlspecialchars($course['description']); ?></div>
                        <span class="badge bg-success">Free</span>
                    </a>
                </div>
                <?php else: ?>
                <div class="col-md-4">
                    <div class="card course-card locked p-3">
                        <div class="course-title mb-1"><?php echo htmlspecialchars($course['title']); ?></div>
                        <div class="course-desc mb-2"><?php echo htmlspecialchars($course['description']); ?></div>
                        <span class="badge">Locked</span>
                    </div>
                </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted">No courses available.</div>
        <?php endif; ?>
    </div>
</section>
<footer class="footer mt-5">
    <div class="container">
        &copy; 2026 ELearning. All rights reserved.
    </div>
</footer>
<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
