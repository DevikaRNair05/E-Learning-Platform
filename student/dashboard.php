<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';
$student_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Student';
$courses = $conn->query("SELECT * FROM courses");
?>
<style>
    body {
        background: linear-gradient(135deg, #f3e7fe 0%, #e3f0ff 100%);
        min-height: 100vh;
    }
    .student-dashboard {
        max-width: 430px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 32px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        padding: 2.2rem 1.5rem 1.5rem 1.5rem;
    }
        .student-dashboard {
            max-width: 1100px;
            margin: 2.5rem auto;
            background: #fff;
            border-radius: 32px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
            padding: 3.5rem 3rem 2.5rem 3rem;
        }
    .dashboard-greeting {
        font-size: 1.35rem;
        font-weight: 700;
        color: #2d2350;
        margin-bottom: 0.2rem;
    }
    .dashboard-sub {
        color: #666;
        font-size: 1.05rem;
        margin-bottom: 1.2rem;
    }
    .dashboard-search {
        background: #f6f7fb;
        border-radius: 16px;
        padding: 0.7rem 1rem;
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px 0 rgba(127, 83, 172, 0.04);
    }
    .dashboard-search input {
        border: none;
        background: transparent;
        outline: none;
        flex: 1;
        font-size: 1rem;
    }
    .dashboard-search-btn {
        background: #7f53ac;
        border: none;
        color: #fff;
        border-radius: 12px;
        padding: 0.5rem 0.9rem;
        font-size: 1.2rem;
        margin-left: 0.5rem;
        transition: background 0.2s;
    }
    .dashboard-search-btn:hover {
        background: #5f2eea;
    }
    .dashboard-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2d2350;
        margin-bottom: 0.7rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dashboard-seeall {
        color: #7f53ac;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
    }
    .dashboard-categories {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.1rem;
        margin-bottom: 1.5rem;
    }
        .dashboard-courses {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
    .category-card {
        border-radius: 20px;
        padding: 1.2rem 1rem 1rem 1rem;
        color: #fff;
        font-weight: 600;
        min-height: 120px;
        box-shadow: 0 4px 16px 0 rgba(127, 83, 172, 0.08);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        position: relative;
        overflow: hidden;
        transition: transform 0.15s;
    }
    .category-card:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 8px 32px 0 rgba(127, 83, 172, 0.13);
    }
    .cat-purple { background: linear-gradient(135deg, #7f53ac 0%, #647dee 100%); }
    .cat-green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .cat-blue { background: linear-gradient(135deg, #56ccf2 0%, #2f80ed 100%); }
    .cat-pink { background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%); }
    .category-title { font-size: 1.1rem; font-weight: 700; }
    .category-count { font-size: 0.95rem; font-weight: 400; opacity: 0.9; }
    @media (max-width: 600px) {
        .student-dashboard { padding: 1.2rem 0.5rem; }
        .dashboard-categories { gap: 0.7rem; }
    }
        @media (max-width: 900px) {
            .student-dashboard { padding: 1.2rem 0.5rem; max-width: 98vw; }
            .dashboard-courses { grid-template-columns: 1fr 1fr; gap: 1rem; }
        }
        @media (max-width: 600px) {
            .student-dashboard { padding: 0.5rem 0.2rem; max-width: 100vw; }
            .dashboard-courses { grid-template-columns: 1fr; gap: 0.7rem; }
        }
</style>
<div class="student-dashboard">
    <div class="dashboard-greeting">Hey <?php echo htmlspecialchars($student_name); ?>,</div>
    <div class="dashboard-sub">Find a course you want to learn</div>
    <form class="dashboard-search" method="get" action="course_list.php">
        <input type="text" name="search" placeholder="Search for anything">
        <button class="dashboard-search-btn" type="submit">&#128269;</button>
    </form>
    <!-- Course grid -->
    <div class="dashboard-section-title" style="margin-top:1.5rem;">
        <span>Courses</span>
    </div>
    <div class="dashboard-courses" style="display:grid;grid-template-columns:1fr 1fr;gap:1.1rem;">
        <?php if ($courses && $courses->num_rows > 0): ?>
            <?php while ($course = $courses->fetch_assoc()): ?>
                <?php if ($course['is_free']): ?>
                    <a href="take_course.php?course_id=<?php echo $course['id']; ?>" class="course-card" style="display:block;text-decoration:none;color:#222;background:#f6f7fb;border-radius:18px;padding:1.1rem 0.8rem;box-shadow:0 2px 8px 0 rgba(127,83,172,0.04);transition:transform 0.13s;min-height:110px;">
                        <div style="font-size:1.08rem;font-weight:700;margin-bottom:0.3rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            <?php echo htmlspecialchars($course['title']); ?>
                        </div>
                        <div style="font-size:0.97rem;color:#666;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="course-card" style="display:block;text-decoration:none;color:#bbb;background:#f0f0f0;border-radius:18px;padding:1.1rem 0.8rem;box-shadow:0 2px 8px 0 rgba(127,83,172,0.04);transition:transform 0.13s;min-height:110px;position:relative;opacity:0.7;cursor:not-allowed;">
                        <div style="font-size:1.08rem;font-weight:700;margin-bottom:0.3rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            <?php echo htmlspecialchars($course['title']); ?>
                        </div>
                        <div style="font-size:0.97rem;color:#aaa;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </div>
                        <span style="position:absolute;top:10px;right:14px;background:#e74c3c;color:#fff;font-size:0.95rem;padding:2px 10px;border-radius:12px;">Locked</span>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column:1/-1;text-align:center;color:#888;">No courses available.</div>
        <?php endif; ?>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
