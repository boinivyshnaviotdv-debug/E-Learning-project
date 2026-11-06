CREATE DATABASE IF NOT EXISTS elearning_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE elearning_db;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('student','admin') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  description TEXT NOT NULL,
  instructor VARCHAR(120) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS enrollments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  course_id INT NOT NULL,
  enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_enrollment (user_id, course_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

INSERT INTO courses (title, description, instructor) VALUES
('Introduction to HTML & CSS', 'Learn the foundations of web page structure and styling.', 'Course Team'),
('PHP and MySQL Fundamentals', 'Build dynamic websites and connect them to a relational database.', 'Course Team'),
('JavaScript Essentials', 'Understand variables, functions, events and DOM manipulation.', 'Course Team');
