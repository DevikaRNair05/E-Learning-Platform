-- SQL schema for ELearning app

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'creator', 'student') NOT NULL
);

CREATE TABLE invites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    used TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    creator_id INT NOT NULL,
    is_free TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (creator_id) REFERENCES users(id)
);

CREATE TABLE chapters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    video_url VARCHAR(255),
    `order` INT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT,
    chapter_id INT,
    rating INT,
    comment TEXT,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (chapter_id) REFERENCES chapters(id)
);
