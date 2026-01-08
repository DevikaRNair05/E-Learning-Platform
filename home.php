
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELearning Home</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
            padding: 60px 0 40px 0;
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d2f31;
        }
        .hero-desc {
            font-size: 1.2rem;
            color: #505763;
            margin-bottom: 2rem;
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
            margin-top: -40px;
        }
        .course-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px 0 rgba(31, 38, 135, 0.06);
            transition: box-shadow 0.2s;
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
        <a class="navbar-brand" href="#">ELearning</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="#featured">Featured</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
            </ul>
            <a href="index.php" class="btn btn-login ms-lg-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16"><path d="M11 10a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0 0 14A7 7 0 0 0 8 1z"/></svg>Login</a>
        </div>
    </div>
</nav>
<section class="hero text-center">
    <div class="container">
        <div class="hero-title mb-3">Learn from the best, anytime, anywhere</div>
        <div class="hero-desc mb-4">Thousands of courses. Expert instructors. Join our learning community today!</div>
        <form class="search-bar mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="What do you want to learn?">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <img src="assets/img/online_school.jpg" alt="Learning" style="max-width:340px; border-radius:18px; box-shadow:0 4px 24px 0 rgba(31,38,135,0.10);">
    </div>
</section>
<section id="featured" class="featured-section container mt-5">
    <h3 class="mb-4">Featured Courses</h3>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card course-card p-3">
                <img src="assets/img/online_school.jpg" class="card-img-top" alt="Course 1">
                <div class="card-body">
                    <div class="course-title">Web Development Bootcamp</div>
                    <div class="course-desc">Learn HTML, CSS, JavaScript, and more. Build real-world projects and become a web developer.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card course-card p-3">
                <img src="assets/img/online_school.jpg" class="card-img-top" alt="Course 2">
                <div class="card-body">
                    <div class="course-title">Python for Everybody</div>
                    <div class="course-desc">Start coding with Python. No experience needed. Perfect for beginners and aspiring data scientists.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card course-card p-3">
                <img src="assets/img/online_school.jpg" class="card-img-top" alt="Course 3">
                <div class="card-body">
                    <div class="course-title">Digital Marketing Mastery</div>
                    <div class="course-desc">Master SEO, social media, and online advertising. Grow your business or career online.</div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="about" class="container mt-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="assets/img/online_school.jpg" alt="About" style="max-width:100%; border-radius:18px;">
        </div>
        <div class="col-md-6">
            <h4>About ELearning</h4>
            <p>ELearning is your gateway to knowledge. We offer a wide range of courses taught by industry experts. Whether you want to learn a new skill, advance your career, or explore a hobby, we have something for you. Join our community and start learning today!</p>
        </div>
    </div>
</section>
<footer class="footer mt-5">
    <div class="container">
        &copy; 2026 ELearning. All rights reserved.
    </div>
</footer>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
