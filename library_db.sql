-- =========================
-- DATABASE
-- =========================
CREATE DATABASE IF NOT EXISTS library_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE library_db;

-- =========================
-- USERS
-- =========================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user'
);

-- =========================
-- BOOKS
-- =========================
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    year INT,
    isbn VARCHAR(50),
    is_available TINYINT(1) DEFAULT 1
);

-- =========================
-- BORROWINGS
-- =========================
CREATE TABLE IF NOT EXISTS borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE DEFAULT NULL,
    status ENUM('pending','approved','rejected','returned') DEFAULT 'pending',

    CONSTRAINT fk_borrow_user
      FOREIGN KEY (user_id) REFERENCES users(id)
      ON DELETE CASCADE,

    CONSTRAINT fk_borrow_book
      FOREIGN KEY (book_id) REFERENCES books(id)
      ON DELETE CASCADE
);

-- =========================
-- OPTIONAL: DEFAULT ADMIN
-- =========================
-- Şifre: admin123
INSERT INTO users (fullname, email, password, role)
VALUES (
  'Admin',
  'admin@library.com',
  '$2y$10$1DZkKO35GYEtsb3l4YZ4xueIFmO.ZHwfgBG3PeuUoCkomulKRbJ7m',
  'admin'
);
