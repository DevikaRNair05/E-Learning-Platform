
<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
$feedbacks = $conn->query("SELECT f.*, u.name as student_name, c.title as course_title FROM feedback f JOIN users u ON f.user_id = u.id JOIN courses c ON f.course_id = c.id ORDER BY f.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students' Feedback</title>
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
        .featured-section {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px 0 rgba(31, 38, 135, 0.07);
            padding: 2rem 1.5rem;
            margin-top: 40px;
        }
        .table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px 0 rgba(31, 38, 135, 0.06);
        }
        th {
            background: #f7f9fa;
            color: #5624d0;
            font-weight: 600;
        }
        td {
            vertical-align: middle;
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
                <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
            </ul>
            <a href="../logout.php" class="btn btn-login ms-lg-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 3a1 1 0 0 1 1-1h3.5A1.5 1.5 0 0 1 12 3.5v9A1.5 1.5 0 0 1 10.5 14H7a1 1 0 0 1-1-1v-1h1v1h3.5a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5H7v1H6V3zm.146 4.146a.5.5 0 0 1 .708 0L9 9.293V5.5a.5.5 0 0 1 1 0v3.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"/></svg>Logout</a>
        </div>
    </div>
</nav>
<section class="featured-section container">
    <h2 class="text-center mb-4">All Students' Feedback</h2>
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $feedbacks->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['student_name']) ?></td>
                <td><?= htmlspecialchars($row['course_title']) ?></td>
                <td><?= htmlspecialchars($row['rating']) ?></td>
                <td><?= htmlspecialchars($row['comment']) ?></td>
                <td><?= htmlspecialchars($row['id']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
    <div class="text-center mt-3">
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
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
