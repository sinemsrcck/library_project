-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3307
-- Üretim Zamanı: 19 Ara 2025, 11:59:38
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `library_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `cover_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `year`, `isbn`, `is_available`, `cover_url`) VALUES
(2, 'Clean Code', 'Robert C. Martin', 'general', 2008, '9780132350884', 1, 'https://covers.openlibrary.org/b/isbn/9780132350884-M.jpg'),
(3, 'Effective Java', 'Joshua Bloch', 'science', 2017, '9780134685991', 1, 'https://covers.openlibrary.org/b/isbn/9780134685991-M.jpg'),
(4, 'The Pragmatic Programmer', 'Andy Hunt', 'science', 2000, '9780201616224', 1, 'https://covers.openlibrary.org/b/isbn/9780201616224-M.jpg'),
(5, 'The C Programming Language', 'Brian W. Kernighan', 'science', 1988, '9780131103627', 1, 'https://covers.openlibrary.org/b/isbn/9780131103627-M.jpg'),
(6, 'Clean Architecture', 'Robert C. Martin', 'general', 2017, '9780134494166', 1, 'https://covers.openlibrary.org/b/isbn/9780134494166-M.jpg'),
(7, 'Refactoring', 'Martin Fowler', 'general', 2018, '9780134757599', 1, 'https://covers.openlibrary.org/b/isbn/9780134757599-M.jpg'),
(8, 'Head First design patterns', 'Eric Freeman', 'general', 2004, '9780596007126', 1, 'https://covers.openlibrary.org/b/isbn/9780596007126-M.jpg'),
(9, 'JavaScript: The Good Parts', 'Douglas Crockford', 'science', 2008, '9780596517748', 1, 'https://covers.openlibrary.org/b/isbn/9780596517748-M.jpg'),
(10, 'Agile Software Development, Principles, Patterns, and Practices', 'Robert C. Martin', 'general', 2002, '9780135974445', 1, 'https://covers.openlibrary.org/b/isbn/9780135974445-M.jpg'),
(11, 'Clean Code', 'Robert C. Martin', 'general', 2008, '9780136083252', 1, 'https://covers.openlibrary.org/b/isbn/9780136083252-M.jpg'),
(12, 'Campbell Biology', 'Lisa A. Urry', 'general', 2017, '9780134093413', 1, 'https://covers.openlibrary.org/b/isbn/9780134093413-M.jpg'),
(13, 'Programming JavaScript Applications: Robust Web Architecture with Node, HTML5, and Modern JS Libraries', 'Eric Elliott', 'science', 2014, '9781491950296', 1, 'https://covers.openlibrary.org/b/isbn/9781491950296-M.jpg'),
(14, 'Head First Design Patterns', 'Eric Freeman', 'general', 2021, '9781492078005', 1, 'https://covers.openlibrary.org/b/isbn/9781492078005-M.jpg'),
(15, 'The Clean Coder', 'Robert C. Martin', 'science', 2011, '9780137081073', 1, 'https://covers.openlibrary.org/b/isbn/9780137081073-M.jpg'),
(16, 'Computer Networking', 'James F. Kurose', 'general', 2016, '9780133594140', 1, 'https://covers.openlibrary.org/b/isbn/9780133594140-M.jpg'),
(17, 'Working Effectively with Legacy Code', 'Michael C. Feathers', 'general', 2004, '9780131177055', 1, 'https://covers.openlibrary.org/b/isbn/9780131177055-M.jpg'),
(18, 'Artificial intelligence', 'Stuart J. Russell', 'general', 2003, '9780137903955', 1, 'https://covers.openlibrary.org/b/isbn/9780137903955-M.jpg'),
(19, 'The art of UNIX programming', 'Eric S. Raymond', 'science', 2004, '9780131429017', 1, 'https://covers.openlibrary.org/b/isbn/9780131429017-M.jpg'),
(20, 'Thinking in Java', 'Bruce Eckel', 'science', 2006, '9780131872486', 1, 'https://covers.openlibrary.org/b/isbn/9780131872486-M.jpg'),
(21, 'Introduction to Algorithms', 'Thomas H. Cormen', 'general', 2009, '9780262033848', 1, 'https://covers.openlibrary.org/b/isbn/9780262033848-M.jpg'),
(22, 'Deep Learning', 'Ian Goodfellow', 'general', 2017, '9780262035613', 1, 'https://covers.openlibrary.org/b/isbn/9780262035613-M.jpg'),
(23, 'Introduction to Algorithms, Fourth Edition', 'Thomas H. Cormen', 'general', 2022, '9780262046305', 1, 'https://covers.openlibrary.org/b/isbn/9780262046305-M.jpg'),
(24, 'Fundamentals of Database Systems', 'Ramez Elmasri', 'business', 2015, '9780133970777', 1, 'https://covers.openlibrary.org/b/isbn/9780133970777-M.jpg'),
(25, 'Starting Out with Programming Logic and Design', 'Tony Gaddis', 'science', 2015, '9780133985078', 1, 'https://covers.openlibrary.org/b/isbn/9780133985078-M.jpg'),
(26, 'Computer networks', 'Andrew S. Tanenbaum', 'science', 2011, '9780132126953', 1, 'https://covers.openlibrary.org/b/isbn/9780132126953-M.jpg'),
(27, 'The C Programming Language', 'Brian W. Kernighan', 'science', 1978, '9780131101630', 1, 'https://covers.openlibrary.org/b/isbn/9780131101630-M.jpg'),
(28, 'Modern Operating Systems', 'Andrew S. Tanenbaum', 'general', 2015, '9780133591620', 1, 'https://covers.openlibrary.org/b/isbn/9780133591620-M.jpg'),
(29, 'Artificial Intelligence', 'Stuart J. Russell', 'general', 2020, '9780134610993', 1, 'https://covers.openlibrary.org/b/isbn/9780134610993-M.jpg'),
(30, 'The Hobbit', 'J.R.R. Tolkien', 'general', 2009, '9780261102217', 1, 'https://covers.openlibrary.org/b/isbn/9780261102217-M.jpg'),
(31, 'The Fellowship of the Ring', 'J.R.R. Tolkien', 'general', 2011, '9780261103573', 1, 'https://covers.openlibrary.org/b/isbn/9780261103573-M.jpg'),
(32, 'The Two Towers', 'J.R.R. Tolkien', 'general', 1991, '9780261102361', 1, 'https://covers.openlibrary.org/b/isbn/9780261102361-M.jpg'),
(33, 'Harry Potter and the sorcerer\'s stone', 'J.K. Rowling', 'general', 1999, '9780439708180', 1, 'https://covers.openlibrary.org/b/isbn/9780439708180-M.jpg'),
(34, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'general', 2000, '9780439064873', 1, 'https://covers.openlibrary.org/b/isbn/9780439064873-M.jpg'),
(35, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'general', 1997, '9780747532699', 1, 'https://covers.openlibrary.org/b/isbn/9780747532699-M.jpg'),
(36, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'general', 1998, '9780747538493', 1, 'https://covers.openlibrary.org/b/isbn/9780747538493-M.jpg'),
(37, 'The Da Vinci Code', 'Dan Brown', 'general', 2006, '9780307277671', 1, 'https://covers.openlibrary.org/b/isbn/9780307277671-M.jpg'),
(38, 'Nineteen Eighty-Four', 'George Orwell', 'general', 1993, '9780451524935', 1, 'https://covers.openlibrary.org/b/isbn/9780451524935-M.jpg'),
(39, 'Pride and Prejudice', 'Jane Austen', 'novel', 2003, '9780141439518', 1, 'https://covers.openlibrary.org/b/isbn/9780141439518-M.jpg'),
(40, 'Crime and punishment', 'Фёдор Михайлович Достоевский', 'general', 2003, '9780140449136', 1, 'https://covers.openlibrary.org/b/isbn/9780140449136-M.jpg'),
(41, 'A Tale of Two Cities', 'Charles Dickens', 'general', 2003, '9780141439600', 1, 'https://covers.openlibrary.org/b/isbn/9780141439600-M.jpg'),
(42, 'The Count of Monte Cristo', 'Alexandre Dumas', 'novel', 2003, '9780140449266', 1, 'https://covers.openlibrary.org/b/isbn/9780140449266-M.jpg'),
(43, 'A Game of Thrones', 'George R. R. Martin', 'general', 2017, '9780553386790', 1, 'https://covers.openlibrary.org/b/isbn/9780553386790-M.jpg'),
(44, 'Sherlock Holmes: The complete novels and stories', 'Arthur Conan Doyle', 'general', 1986, '9780553212419', 1, 'https://covers.openlibrary.org/b/isbn/9780553212419-M.jpg'),
(45, 'To Kill a Mockingbird', 'Harper Lee', 'novel', 2006, '9780061120084', 1, 'https://covers.openlibrary.org/b/isbn/9780061120084-M.jpg'),
(46, 'Brave New World', 'Aldous Huxley', 'general', 1932, '9780060850524', 1, 'https://covers.openlibrary.org/b/isbn/9780060850524-M.jpg'),
(47, 'Lord of the flies', 'William Golding', 'novel', 1999, '9780140283334', 1, 'https://covers.openlibrary.org/b/isbn/9780140283334-M.jpg'),
(48, 'The Grapes of Wrath', 'John Steinbeck', 'general', 2006, '9780143039433', 1, 'https://covers.openlibrary.org/b/isbn/9780143039433-M.jpg'),
(49, 'The red pony', 'John Steinbeck', 'general', 1994, '9780140187397', 1, 'https://covers.openlibrary.org/b/isbn/9780140187397-M.jpg'),
(50, 'The Body Keeps the Score', 'Bessel van der Kolk', 'general', 2015, '9780143127741', 1, 'https://covers.openlibrary.org/b/isbn/9780143127741-M.jpg'),
(51, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'general', 2011, '9780062316110', 1, 'https://covers.openlibrary.org/b/isbn/9780062316110-M.jpg'),
(52, 'Deep Work', 'Cal Newport', 'general', 2016, '9781455586691', 1, 'https://covers.openlibrary.org/b/isbn/9781455586691-M.jpg'),
(53, 'The Subtle Art of Not Giving a Fuck', 'Mark Manson', 'general', 2018, '9780062457714', 1, 'https://covers.openlibrary.org/b/isbn/9780062457714-M.jpg'),
(54, 'Principles', 'Ray Dalio', 'general', 2017, '9781501124020', 1, 'https://covers.openlibrary.org/b/isbn/9781501124020-M.jpg'),
(55, 'The Lean Startup', 'Eric Ries', 'general', 2011, '9780307887894', 1, 'https://covers.openlibrary.org/b/isbn/9780307887894-M.jpg'),
(56, 'Steve Jobs', 'Walter Isaacson', 'general', 2011, '9781451648539', 1, 'https://covers.openlibrary.org/b/isbn/9781451648539-M.jpg'),
(57, 'Elon Musk', 'Ashlee Vance', 'general', 2015, '9780062301239', 1, 'https://covers.openlibrary.org/b/isbn/9780062301239-M.jpg'),
(58, 'New book', 'Michael Jackson', 'general', 2001, '9780141033570', 1, 'https://covers.openlibrary.org/b/isbn/9780141033570-M.jpg'),
(59, 'The Alchemist', 'Paulo Coelho', 'general', 2014, '9780062315007', 1, 'https://covers.openlibrary.org/b/isbn/9780062315007-M.jpg'),
(60, 'The Bhagavad gita.', 'Juan Mascaró', 'general', 2003, '9780140449181', 1, 'https://covers.openlibrary.org/b/isbn/9780140449181-M.jpg'),
(61, 'The Symposium', 'Πλάτων', 'general', 0, '9780140449273', 1, 'https://covers.openlibrary.org/b/isbn/9780140449273-M.jpg'),
(62, 'Frankenstein', 'Mary Shelley', 'general', 2003, '9780141439471', 1, 'https://covers.openlibrary.org/b/isbn/9780141439471-M.jpg'),
(63, 'A Study in Scarlet', 'Arthur Conan Doyle', 'novel', 2001, '9780140439083', 1, 'https://covers.openlibrary.org/b/isbn/9780140439083-M.jpg'),
(64, 'Great Expectations', 'Charles Dickens', 'general', 1993, '9780141439563', 1, 'https://covers.openlibrary.org/b/isbn/9780141439563-M.jpg'),
(65, 'The Epic of Gilgamesh', 'Anonymous', 'general', 2002, '9780140449198', 1, 'https://covers.openlibrary.org/b/isbn/9780140449198-M.jpg'),
(66, 'THE BROTHERS KARAMAZOV', 'Фёдор Михайлович Достоевский', 'general', 1993, '9780140449242', 1, 'https://covers.openlibrary.org/b/isbn/9780140449242-M.jpg'),
(67, 'The Grapes of Wrath', 'John Steinbeck', 'general', 1992, '9780140186406', 1, 'https://covers.openlibrary.org/b/isbn/9780140186406-M.jpg'),
(68, 'The Republic', 'Πλάτων', 'general', 2003, '9780140449143', 1, 'https://covers.openlibrary.org/b/isbn/9780140449143-M.jpg'),
(69, 'Harry Potter ve Sırlar Odası – 2', 'J.K. Rowling', 'Antiques & Collectibles', 2022, '9789750837593', 1, 'https://covers.openlibrary.org/b/isbn/9789750837593-L.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('pending','approved','rejected','returned') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`) VALUES
(2, 'Sinem', 's@gmail.com', '$2y$10$mbiUpcR23QLJmsdMMAOXne5J5CI4mekZP9zAi.dwdcN80nZT0fhpm', 'user'),
(3, 'Admin', 'admin@gmail.com', '$2y$10$NZPjM.z2SphcrSfARImyWuLszD8vivMuBHGnM2h4BKlwcb767nAH2', 'admin'),
(4, 'Gizem', 'g@gmail.com', '$2y$10$ppSsJYUTUSp9G1C1OE2eY.SMagWmYzFUj2VgdRf0tMSc4DTRo8p9e', 'user'),
(5, 'irem', 'irem@gmail.com', '$2y$10$8ODXdaMy9sfyIbpblnDzZej7I57sPRBFNN0inJm5EKXNkSoudwGLi', 'user');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_borrow_user` (`user_id`),
  ADD KEY `fk_borrow_book` (`book_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Tablo için AUTO_INCREMENT değeri `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `fk_borrow_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_borrow_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
