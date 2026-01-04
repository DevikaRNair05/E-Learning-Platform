# ELearning Platform

A professional e-learning platform for micro-courses with 3 roles: Admin, Creator, and Student.

## Features
- Google OAuth login (one email = one role)
- Admin: View/delete all courses, invite creators
- Creator: Create courses, upload chapters (CKEditor), view own courses
- Student: Learn courses, rate chapters, give feedback, mark chapters complete
- Only one course is free, others are locked
- Modern UI (see design reference)

## Structure
```
ELearning/
├── index.php                  # Login page (Google OAuth)
├── dashboard.php              # Role-based dashboard
├── admin/
│   ├── dashboard.php
│   ├── invite_creator.php
│   └── delete_course.php
├── creator/
│   ├── dashboard.php
│   ├── create_course.php
│   ├── edit_course.php
│   └── my_courses.php
├── student/
│   ├── dashboard.php
│   ├── course_list.php
│   ├── take_course.php
│   └── feedback.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── db.php
│   └── auth.php
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── bootstrap.min.css
│   └── js/
│       ├── script.js
│       ├── bootstrap.min.js
│       └── ckeditor.js
├── config.php                 # Google OAuth config
└── README.md
```

## Setup
1. Import the SQL schema (see below) into your MySQL database.
2. Configure Google OAuth in `config.php`.
3. Place Bootstrap and CKEditor files in `assets/css` and `assets/js`.
4. Update DB credentials in `includes/db.php`.

## Database Schema (MySQL)
```

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  name VARCHAR(255) NOT NULL,
  role ENUM('admin','creator','student') NOT NULL
);

-- Table for storing creator invite links
CREATE TABLE invites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  token VARCHAR(64) NOT NULL,
  created_at DATETIME NOT NULL,
  used TINYINT(1) DEFAULT 0,
  UNIQUE(email),
  UNIQUE(token)
);

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  creator_id INT,
  is_free TINYINT(1) DEFAULT 0,
  locked TINYINT(1) DEFAULT 1,
  FOREIGN KEY (creator_id) REFERENCES users(id)
);

CREATE TABLE chapters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT,
  title VARCHAR(255) NOT NULL,
  content TEXT,
  `order` INT,
  FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE feedback (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  chapter_id INT,
  rating INT,
  comment TEXT,
  completed TINYINT(1) DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (chapter_id) REFERENCES chapters(id)
);
```

---

**UI is based on the attached design.**

---

For any questions or setup help, contact the developer.
