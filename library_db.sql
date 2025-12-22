-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3307
-- Üretim Zamanı: 22 Ara 2025, 21:13:34
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
  `cover_url` varchar(500) DEFAULT NULL,
  `total_copies` int(11) NOT NULL DEFAULT 1,
  `available_copies` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `category`, `year`, `isbn`, `is_available`, `cover_url`, `total_copies`, `available_copies`) VALUES
(2, 'Clean Code', 'Robert C. Martin', 'general', 2008, '9780132350884', 1, 'https://covers.openlibrary.org/b/isbn/9780132350884-M.jpg', 3, 3),
(3, 'Effective Java', 'Joshua Bloch', 'science', 2017, '9780134685991', 1, 'https://covers.openlibrary.org/b/isbn/9780134685991-M.jpg', 4, 4),
(4, 'The Pragmatic Programmer', 'Andy Hunt', 'science', 2000, '9780201616224', 1, 'https://covers.openlibrary.org/b/isbn/9780201616224-M.jpg', 4, 4),
(5, 'The C Programming Language', 'Brian W. Kernighan', 'science', 1988, '9780131103627', 1, 'https://covers.openlibrary.org/b/isbn/9780131103627-M.jpg', 4, 4),
(6, 'Clean Architecture', 'Robert C. Martin', 'general', 2017, '9780134494166', 1, 'https://covers.openlibrary.org/b/isbn/9780134494166-M.jpg', 4, 4),
(7, 'Refactoring', 'Martin Fowler', 'general', 2018, '9780134757599', 1, 'https://covers.openlibrary.org/b/isbn/9780134757599-M.jpg', 3, 3),
(8, 'Head First design patterns', 'Eric Freeman', 'general', 2004, '9780596007126', 1, 'https://covers.openlibrary.org/b/isbn/9780596007126-M.jpg', 4, 4),
(9, 'JavaScript: The Good Parts', 'Douglas Crockford', 'science', 2008, '9780596517748', 1, 'https://covers.openlibrary.org/b/isbn/9780596517748-M.jpg', 4, 4),
(10, 'Agile Software Development, Principles, Patterns, and Practices', 'Robert C. Martin', 'general', 2002, '9780135974445', 1, 'https://covers.openlibrary.org/b/isbn/9780135974445-M.jpg', 4, 4),
(11, 'Clean Code', 'Robert C. Martin', 'general', 2008, '9780136083252', 1, 'https://covers.openlibrary.org/b/isbn/9780136083252-M.jpg', 4, 4),
(12, 'Campbell Biology', 'Lisa A. Urry', 'general', 2017, '9780134093413', 1, 'https://covers.openlibrary.org/b/isbn/9780134093413-M.jpg', 3, 3),
(13, 'Programming JavaScript Applications: Robust Web Architecture with Node, HTML5, and Modern JS Libraries', 'Eric Elliott', 'science', 2014, '9781491950296', 1, 'https://covers.openlibrary.org/b/isbn/9781491950296-M.jpg', 4, 4),
(14, 'Head First Design Patterns', 'Eric Freeman', 'general', 2021, '9781492078005', 1, 'https://covers.openlibrary.org/b/isbn/9781492078005-M.jpg', 4, 4),
(15, 'The Clean Coder', 'Robert C. Martin', 'science', 2011, '9780137081073', 1, 'https://covers.openlibrary.org/b/isbn/9780137081073-M.jpg', 4, 4),
(16, 'Computer Networking', 'James F. Kurose', 'general', 2016, '9780133594140', 1, 'https://covers.openlibrary.org/b/isbn/9780133594140-M.jpg', 4, 4),
(17, 'Working Effectively with Legacy Code', 'Michael C. Feathers', 'general', 2004, '9780131177055', 1, 'https://covers.openlibrary.org/b/isbn/9780131177055-M.jpg', 4, 4),
(18, 'Artificial intelligence', 'Stuart J. Russell', 'general', 2003, '9780137903955', 1, 'https://covers.openlibrary.org/b/isbn/9780137903955-M.jpg', 4, 4),
(19, 'The art of UNIX programming', 'Eric S. Raymond', 'science', 2004, '9780131429017', 1, 'https://covers.openlibrary.org/b/isbn/9780131429017-M.jpg', 4, 4),
(20, 'Thinking in Java', 'Bruce Eckel', 'science', 2006, '9780131872486', 1, 'https://covers.openlibrary.org/b/isbn/9780131872486-M.jpg', 4, 4),
(21, 'Introduction to Algorithms', 'Thomas H. Cormen', 'general', 2009, '9780262033848', 1, 'https://covers.openlibrary.org/b/isbn/9780262033848-M.jpg', 4, 4),
(22, 'Deep Learning', 'Ian Goodfellow', 'general', 2017, '9780262035613', 1, 'https://covers.openlibrary.org/b/isbn/9780262035613-M.jpg', 4, 4),
(23, 'Introduction to Algorithms, Fourth Edition', 'Thomas H. Cormen', 'general', 2022, '9780262046305', 1, 'https://covers.openlibrary.org/b/isbn/9780262046305-M.jpg', 3, 3),
(24, 'Fundamentals of Database Systems', 'Ramez Elmasri', 'business', 2015, '9780133970777', 1, 'https://covers.openlibrary.org/b/isbn/9780133970777-M.jpg', 4, 4),
(25, 'Starting Out with Programming Logic and Design', 'Tony Gaddis', 'science', 2015, '9780133985078', 1, 'https://covers.openlibrary.org/b/isbn/9780133985078-M.jpg', 4, 4),
(26, 'Computer networks', 'Andrew S. Tanenbaum', 'science', 2011, '9780132126953', 1, 'https://covers.openlibrary.org/b/isbn/9780132126953-M.jpg', 4, 4),
(27, 'The C Programming Language', 'Brian W. Kernighan', 'science', 1978, '9780131101630', 1, 'https://covers.openlibrary.org/b/isbn/9780131101630-M.jpg', 4, 4),
(28, 'Modern Operating Systems', 'Andrew S. Tanenbaum', 'general', 2015, '9780133591620', 1, 'https://covers.openlibrary.org/b/isbn/9780133591620-M.jpg', 4, 4),
(29, 'Artificial Intelligence', 'Stuart J. Russell', 'general', 2020, '9780134610993', 1, 'https://covers.openlibrary.org/b/isbn/9780134610993-M.jpg', 3, 3),
(30, 'The Hobbit', 'J.R.R. Tolkien', 'general', 2009, '9780261102217', 1, 'https://covers.openlibrary.org/b/isbn/9780261102217-M.jpg', 4, 4),
(31, 'The Fellowship of the Ring', 'J.R.R. Tolkien', 'general', 2011, '9780261103573', 1, 'https://covers.openlibrary.org/b/isbn/9780261103573-M.jpg', 3, 3),
(32, 'The Two Towers', 'J.R.R. Tolkien', 'general', 1991, '9780261102361', 1, 'https://covers.openlibrary.org/b/isbn/9780261102361-M.jpg', 4, 4),
(33, 'Harry Potter and the sorcerer\'s stone', 'J.K. Rowling', 'general', 1999, '9780439708180', 1, 'https://covers.openlibrary.org/b/isbn/9780439708180-M.jpg', 4, 4),
(34, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'general', 2000, '9780439064873', 1, 'https://covers.openlibrary.org/b/isbn/9780439064873-M.jpg', 4, 4),
(35, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'general', 1997, '9780747532699', 1, 'https://covers.openlibrary.org/b/isbn/9780747532699-M.jpg', 4, 4),
(36, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'general', 1998, '9780747538493', 1, 'https://covers.openlibrary.org/b/isbn/9780747538493-M.jpg', 4, 4),
(37, 'The Da Vinci Code', 'Dan Brown', 'general', 2006, '9780307277671', 1, 'https://covers.openlibrary.org/b/isbn/9780307277671-M.jpg', 4, 4),
(38, 'Nineteen Eighty-Four', 'George Orwell', 'general', 1993, '9780451524935', 1, 'https://covers.openlibrary.org/b/isbn/9780451524935-M.jpg', 3, 3),
(39, 'Pride and Prejudice', 'Jane Austen', 'novel', 2003, '9780141439518', 1, 'https://covers.openlibrary.org/b/isbn/9780141439518-M.jpg', 3, 3),
(40, 'Crime and punishment', 'Фёдор Михайлович Достоевский', 'general', 2003, '9780140449136', 1, 'https://covers.openlibrary.org/b/isbn/9780140449136-M.jpg', 4, 4),
(41, 'A Tale of Two Cities', 'Charles Dickens', 'general', 2003, '9780141439600', 1, 'https://covers.openlibrary.org/b/isbn/9780141439600-M.jpg', 4, 4),
(42, 'The Count of Monte Cristo', 'Alexandre Dumas', 'novel', 2003, '9780140449266', 1, 'https://covers.openlibrary.org/b/isbn/9780140449266-M.jpg', 4, 4),
(43, 'A Game of Thrones', 'George R. R. Martin', 'general', 2017, '9780553386790', 1, 'https://covers.openlibrary.org/b/isbn/9780553386790-M.jpg', 4, 4),
(44, 'Sherlock Holmes: The complete novels and stories', 'Arthur Conan Doyle', 'general', 1986, '9780553212419', 1, 'https://covers.openlibrary.org/b/isbn/9780553212419-M.jpg', 3, 3),
(45, 'To Kill a Mockingbird', 'Harper Lee', 'novel', 2006, '9780061120084', 1, 'https://covers.openlibrary.org/b/isbn/9780061120084-M.jpg', 4, 4),
(46, 'Brave New World', 'Aldous Huxley', 'general', 1932, '9780060850524', 1, 'https://covers.openlibrary.org/b/isbn/9780060850524-M.jpg', 4, 4),
(47, 'Lord of the flies', 'William Golding', 'novel', 1999, '9780140283334', 1, 'https://covers.openlibrary.org/b/isbn/9780140283334-M.jpg', 3, 3),
(48, 'The Grapes of Wrath', 'John Steinbeck', 'general', 2006, '9780143039433', 1, 'https://covers.openlibrary.org/b/isbn/9780143039433-M.jpg', 4, 4),
(49, 'The red pony', 'John Steinbeck', 'general', 1994, '9780140187397', 1, 'https://covers.openlibrary.org/b/isbn/9780140187397-M.jpg', 4, 4),
(50, 'The Body Keeps the Score', 'Bessel van der Kolk', 'general', 2015, '9780143127741', 1, 'https://covers.openlibrary.org/b/isbn/9780143127741-M.jpg', 4, 4),
(51, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'general', 2011, '9780062316110', 1, 'https://covers.openlibrary.org/b/isbn/9780062316110-M.jpg', 4, 4),
(52, 'Deep Work', 'Cal Newport', 'general', 2016, '9781455586691', 1, 'https://covers.openlibrary.org/b/isbn/9781455586691-M.jpg', 3, 3),
(53, 'The Subtle Art of Not Giving a Fuck', 'Mark Manson', 'general', 2018, '9780062457714', 1, 'https://covers.openlibrary.org/b/isbn/9780062457714-M.jpg', 4, 4),
(54, 'Principles', 'Ray Dalio', 'general', 2017, '9781501124020', 1, 'https://covers.openlibrary.org/b/isbn/9781501124020-M.jpg', 4, 4),
(55, 'The Lean Startup', 'Eric Ries', 'general', 2011, '9780307887894', 1, 'https://covers.openlibrary.org/b/isbn/9780307887894-M.jpg', 4, 4),
(56, 'Steve Jobs', 'Walter Isaacson', 'general', 2011, '9781451648539', 1, 'https://covers.openlibrary.org/b/isbn/9781451648539-M.jpg', 3, 3),
(57, 'Elon Musk', 'Ashlee Vance', 'general', 2015, '9780062301239', 1, 'https://covers.openlibrary.org/b/isbn/9780062301239-M.jpg', 3, 3),
(58, 'New book', 'Michael Jackson', 'general', 2001, '9780141033570', 1, 'https://covers.openlibrary.org/b/isbn/9780141033570-M.jpg', 1, 1),
(59, 'The Alchemist', 'Paulo Coelho', 'general', 2014, '9780062315007', 1, 'https://covers.openlibrary.org/b/isbn/9780062315007-M.jpg', 4, 4),
(60, 'The Bhagavad gita.', 'Juan Mascaró', 'general', 2003, '9780140449181', 1, 'https://covers.openlibrary.org/b/isbn/9780140449181-M.jpg', 4, 4),
(61, 'The Symposium', 'Πλάτων', 'general', 0, '9780140449273', 1, 'https://covers.openlibrary.org/b/isbn/9780140449273-M.jpg', 4, 4),
(62, 'Frankenstein', 'Mary Shelley', 'general', 2003, '9780141439471', 1, 'https://covers.openlibrary.org/b/isbn/9780141439471-M.jpg', 4, 4),
(63, 'A Study in Scarlet', 'Arthur Conan Doyle', 'novel', 2001, '9780140439083', 1, 'https://covers.openlibrary.org/b/isbn/9780140439083-M.jpg', 3, 3),
(64, 'Great Expectations', 'Charles Dickens', 'general', 1993, '9780141439563', 1, 'https://covers.openlibrary.org/b/isbn/9780141439563-M.jpg', 4, 4),
(65, 'The Epic of Gilgamesh', 'Anonymous', 'general', 2002, '9780140449198', 1, 'https://covers.openlibrary.org/b/isbn/9780140449198-M.jpg', 4, 4),
(66, 'THE BROTHERS KARAMAZOV', 'Фёдор Михайлович Достоевский', 'general', 1993, '9780140449242', 1, 'https://covers.openlibrary.org/b/isbn/9780140449242-M.jpg', 3, 3),
(67, 'The Grapes of Wrath', 'John Steinbeck', 'general', 1992, '9780140186406', 1, 'https://covers.openlibrary.org/b/isbn/9780140186406-M.jpg', 4, 4),
(68, 'The Republic', 'Πλάτων', 'general', 2003, '9780140449143', 1, 'https://covers.openlibrary.org/b/isbn/9780140449143-M.jpg', 4, 4),
(69, 'Harry Potter ve Sırlar Odası – 2', 'J.K. Rowling', 'Antiques & Collectibles', 2022, '9789750837593', 1, 'https://covers.openlibrary.org/b/isbn/9789750837593-L.jpg', 1, 1),
(70, 'The Hobbit', 'J. R. R. Tolkien', 'Fiction', 2009, '9780007322602', 1, 'https://covers.openlibrary.org/b/isbn/9780007322602-L.jpg', 1, 1),
(71, 'Masumiyet müzesi', 'Orhan Pamuk', '', 2008, '', 1, '', 1, 1),
(98, 'A Tour of C++ (2nd Edition) (C++ In-Depth Series)', 'Bjarne Stroustrup', 'science', 2018, '9780134997834', 1, 'https://covers.openlibrary.org/b/isbn/9780134997834-M.jpg', 4, 4),
(99, 'Android Programming: The Big Nerd Ranch Guide (3rd Edition) (Big Nerd Ranch Guides)', 'Bill Phillips', 'general', 2017, '9780134706054', 1, 'https://covers.openlibrary.org/b/isbn/9780134706054-M.jpg', 3, 3),
(100, 'Core Java Volume I--Fundamentals (11th Edition)', 'Cay S. Horstmann', 'science', 2018, '9780135166307', 1, 'https://covers.openlibrary.org/b/isbn/9780135166307-M.jpg', 3, 3),
(101, 'Fluent Python', 'Luciano Ramalho', 'science', 2021, '9781492056355', 1, 'https://covers.openlibrary.org/b/isbn/9781492056355-M.jpg', 4, 4),
(102, 'Effective Modern C++: 42 Specific Ways to Improve Your Use of C++11 and C++14', 'Scott Meyers', 'science', 2014, '9781491903995', 1, 'https://covers.openlibrary.org/b/isbn/9781491903995-M.jpg', 4, 4),
(103, 'R for Data Science: Import, Tidy, Transform, Visualize, and Model Data', 'Hadley Wickham', 'general', 2017, '9781491910399', 1, 'https://covers.openlibrary.org/b/isbn/9781491910399-M.jpg', 4, 4),
(104, 'Think Python', 'Allen B. Downey', 'science', 2015, '9781491939369', 1, 'https://covers.openlibrary.org/b/isbn/9781491939369-M.jpg', 4, 4),
(105, 'Building Microservices: Designing Fine-Grained Systems', 'Sam Newman', 'general', 2015, '9781491950357', 1, 'https://covers.openlibrary.org/b/isbn/9781491950357-M.jpg', 4, 4),
(106, 'Python for Data Analysis: Data Wrangling with Pandas, NumPy, and IPython', 'Wes McKinney', 'science', 2017, '9781491957660', 1, 'https://covers.openlibrary.org/b/isbn/9781491957660-M.jpg', 4, 4),
(107, 'Web Scraping with Python', 'Ryan Mitchell', 'science', 2018, '9781491985571', 1, 'https://covers.openlibrary.org/b/isbn/9781491985571-M.jpg', 4, 4),
(108, 'Deep Learning for Coders with Fastai and Pytorch', 'Jeremy Howard', 'science', 2020, '9781492045526', 1, 'https://covers.openlibrary.org/b/isbn/9781492045526-M.jpg', 4, 4),
(109, 'Speaking JavaScript', 'Axel Rauschmayer', 'general', 2014, '9781449365035', 1, 'https://covers.openlibrary.org/b/isbn/9781449365035-M.jpg', 3, 3),
(110, 'Learning JavaScript Design Pattern', 'Addy Osmani', 'general', 2012, '9781449331818', 1, 'https://covers.openlibrary.org/b/isbn/9781449331818-M.jpg', 4, 4),
(111, 'Python For Data Analysis', 'Wes McKinney', 'science', 2012, '9781449319793', 1, 'https://covers.openlibrary.org/b/isbn/9781449319793-M.jpg', 4, 4),
(112, 'Designing Data-Intensive Applications: The Big Ideas Behind Reliable, Scalable, and Maintainable Systems', 'Martin Kleppmann', 'general', 2017, '9781449373320', 1, 'https://covers.openlibrary.org/b/isbn/9781449373320-M.jpg', 4, 4),
(113, 'Programming PHP: Creating Dynamic Web Pages', 'Kevin Tatroe', 'general', 2013, '9781449392772', 1, 'https://covers.openlibrary.org/b/isbn/9781449392772-M.jpg', 3, 3),
(114, 'Python Cookbook', 'Alex Martelli', 'science', 2013, '9781449340377', 1, 'https://covers.openlibrary.org/b/isbn/9781449340377-M.jpg', 4, 4),
(115, 'Learning Python', 'Mark Lutz', 'science', 2013, '9781449355739', 1, 'https://covers.openlibrary.org/b/isbn/9781449355739-M.jpg', 4, 4),
(116, 'Introduction to Machine Learning with Python', 'Andreas C. Mueller', 'science', 2016, '9781449369415', 1, 'https://covers.openlibrary.org/b/isbn/9781449369415-M.jpg', 4, 4),
(117, 'Hackers & painters', 'Graham, Paul', 'science', 2010, '9781449389550', 1, 'https://covers.openlibrary.org/b/isbn/9781449389550-M.jpg', 4, 4),
(118, 'Elasticsearch', 'Clinton Gormley', 'science', 2015, '9781449358549', 1, 'https://covers.openlibrary.org/b/isbn/9781449358549-M.jpg', 4, 4),
(121, 'JavaScript', 'David Flanagan', 'science', 2011, '9780596805524', 1, 'https://covers.openlibrary.org/b/isbn/9780596805524-M.jpg', 4, 4),
(122, 'Programming Perl', 'Larry Wall', 'science', 2000, '9780596000271', 1, 'https://covers.openlibrary.org/b/isbn/9780596000271-M.jpg', 4, 4),
(123, 'Head first Java', 'Kathy Sierra', 'science', 2005, '9780596009205', 1, 'https://covers.openlibrary.org/b/isbn/9780596009205-M.jpg', 4, 4),
(124, 'Head First Java', 'Kathy Sierra', 'science', 2003, '9780596004651', 1, 'https://covers.openlibrary.org/b/isbn/9780596004651-M.jpg', 4, 4),
(125, 'Head first JavaScript', 'Michael Morrison', 'science', 2008, '9780596527747', 1, 'https://covers.openlibrary.org/b/isbn/9780596527747-M.jpg', 3, 3),
(126, 'Programming Collective Intelligence', 'Toby Segaran', 'general', 2007, '9780596529321', 1, 'https://covers.openlibrary.org/b/isbn/9780596529321-M.jpg', 2, 2),
(127, 'PHP cookbook', 'David Sklar', 'general', 2006, '9780596101015', 1, 'https://covers.openlibrary.org/b/isbn/9780596101015-M.jpg', 4, 4),
(128, 'Patterns of Enterprise Application Architecture', 'Martin Fowler', 'general', 2007, '9780321127426', 1, 'https://covers.openlibrary.org/b/isbn/9780321127426-M.jpg', 4, 4),
(129, 'Effective Java', 'Joshua Bloch', 'science', 2008, '9780321356680', 1, 'https://covers.openlibrary.org/b/isbn/9780321356680-M.jpg', 4, 4),
(130, 'Domain-Driven Design', 'Eric Evans', 'general', 2008, '9780321125217', 1, 'https://covers.openlibrary.org/b/isbn/9780321125217-M.jpg', 4, 4),
(131, 'Test-driven development', 'Kent Beck', 'science', 2006, '9780321146533', 1, 'https://covers.openlibrary.org/b/isbn/9780321146533-M.jpg', 3, 3),
(132, 'Algorithms', 'Robert Sedgewick', 'science', 2011, '9780321573513', 1, 'https://covers.openlibrary.org/b/isbn/9780321573513-M.jpg', 4, 4),
(133, 'C++ primer', 'Stanley B. Lippman', 'science', 2013, '9780321714114', 1, 'https://covers.openlibrary.org/b/isbn/9780321714114-M.jpg', 4, 4),
(134, 'Scala for the impatient', 'Cay S. Horstmann', 'science', 2012, '9780321774095', 1, 'https://covers.openlibrary.org/b/isbn/9780321774095-M.jpg', 4, 4),
(135, 'The Art of Computer Programming, Volumes 1-4A Boxed Set', 'Donald Knuth', 'science', 2011, '9780321751041', 1, 'https://covers.openlibrary.org/b/isbn/9780321751041-M.jpg', 4, 4),
(136, 'Ruby on Rails tutorial', 'Michael Hartl', 'science', 2013, '9780321832054', 1, 'https://covers.openlibrary.org/b/isbn/9780321832054-M.jpg', 4, 4),
(137, 'Java Concurrency in Practice', 'Brian Goetz', 'science', 2006, '9780321349606', 1, 'https://covers.openlibrary.org/b/isbn/9780321349606-M.jpg', 4, 4),
(138, 'Compilers', 'Alfred V. Aho', 'science', 2006, '9780321486813', 1, 'https://covers.openlibrary.org/b/isbn/9780321486813-M.jpg', 4, 4),
(139, 'Design Patterns', 'Erich Gamma', 'general', 1995, '9780201633610', 1, 'https://covers.openlibrary.org/b/isbn/9780201633610-M.jpg', 4, 4),
(140, 'Refactoring', 'Martin Fowler', 'general', 1999, '9780201485677', 1, 'https://covers.openlibrary.org/b/isbn/9780201485677-M.jpg', 4, 4),
(141, 'Concrete mathematics', 'Ronald L. Graham', 'science', 1994, '9780201558029', 1, 'https://covers.openlibrary.org/b/isbn/9780201558029-M.jpg', 4, 4),
(142, 'Visual Basic 2012 How to Program (6th Edition)', 'Paul J. Deitel', 'science', 2013, '9780133406955', 1, 'https://covers.openlibrary.org/b/isbn/9780133406955-M.jpg', 4, 4),
(143, 'C++ Primer', 'Stanley Lippman', 'general', 2012, '9780133053036', 1, 'https://covers.openlibrary.org/b/isbn/9780133053036-M.jpg', 4, 4),
(144, 'Effective Python', 'Brett Slatkin', 'science', 2015, '9780134034287', 1, 'https://covers.openlibrary.org/b/isbn/9780134034287-M.jpg', 4, 4),
(145, 'The Software Craftsman', 'Sandro Mancuso', 'science', 2014, '9780134052502', 1, 'https://covers.openlibrary.org/b/isbn/9780134052502-M.jpg', 3, 3),
(146, 'Domain-Driven Design Distilled', 'Vaughn Vernon', 'science', 2016, '9780134434421', 1, 'https://covers.openlibrary.org/b/isbn/9780134434421-M.jpg', 3, 3),
(147, 'Core Java, Vol. 2', 'Cay S. Horstmann', 'science', 2008, '9780132354790', 1, 'https://covers.openlibrary.org/b/isbn/9780132354790-M.jpg', 4, 4),
(148, 'Artificial Unintelligence', 'Meredith Broussard', 'general', 2018, '9780262038003', 1, 'https://covers.openlibrary.org/b/isbn/9780262038003-M.jpg', 4, 4),
(149, 'People Count', 'Susan Landau', 'general', 2021, '9780262045711', 1, 'https://covers.openlibrary.org/b/isbn/9780262045711-M.jpg', 4, 4),
(155, 'Harry Potter and the Goblet of Fire', 'J.K. Rowling', 'general', 2002, '9780439139601', 1, 'https://covers.openlibrary.org/b/isbn/9780439139601-M.jpg', 4, 4),
(156, 'How Book Reading Affects Student Performance?', 'Tony Kaller', 'general', 2021, '9780545010221', 1, 'https://covers.openlibrary.org/b/isbn/9780545010221-M.jpg', 4, 4),
(157, 'The Hobbit', 'J.R.R. Tolkien', 'general', 2012, '9780547928227', 1, 'https://covers.openlibrary.org/b/isbn/9780547928227-M.jpg', 4, 4),
(158, 'The Two Towers', 'J.R.R. Tolkien', 'general', 1994, '9780547928203', 1, 'https://covers.openlibrary.org/b/isbn/9780547928203-M.jpg', 4, 4),
(183, 'The Shining', 'Stephen King', 'novel', 2012, '9780307743657', 1, 'https://covers.openlibrary.org/b/isbn/9780307743657-M.jpg', 4, 4),
(184, 'Carrie', 'Stephen King', 'novel', 2011, '9780307743664', 1, 'https://covers.openlibrary.org/b/isbn/9780307743664-M.jpg', 3, 3),
(185, 'The Da Vinci Code', 'Dan Brown', 'general', 2009, '9780307474278', 1, 'https://covers.openlibrary.org/b/isbn/9780307474278-M.jpg', 4, 4),
(186, '1Q84', '村上春樹', 'general', 2013, '9780307476463', 1, 'https://covers.openlibrary.org/b/isbn/9780307476463-M.jpg', 4, 4),
(187, 'Gone Girl', 'Gillian Flynn', 'novel', 2014, '9780307588371', 1, 'https://covers.openlibrary.org/b/isbn/9780307588371-M.jpg', 4, 4),
(188, 'The Catcher in the Rye', 'J. D. Salinger', 'novel', 1991, '9780316769488', 1, 'https://covers.openlibrary.org/b/isbn/9780316769488-M.jpg', 4, 4),
(189, 'To Kill a Mockingbird', 'Harper Lee', 'novel', 2016, '9780060935467', 1, 'https://covers.openlibrary.org/b/isbn/9780060935467-M.jpg', 3, 3),
(190, 'The Bean Trees', 'Barbara Kingsolver', 'general', 1989, '9780060915544', 1, 'https://covers.openlibrary.org/b/isbn/9780060915544-M.jpg', 3, 3),
(200, 'Pride and Prejudice', 'Jane Austen', 'novel', 2003, '9780553213102', 1, 'https://covers.openlibrary.org/b/isbn/9780553213102-M.jpg', 4, 4),
(201, 'A Brief History of Time', 'Stephen Hawking', 'general', 1998, '9780553380163', 1, 'https://covers.openlibrary.org/b/isbn/9780553380163-M.jpg', 4, 4),
(202, 'Pride and Prejudice', 'Jane Austen', 'novel', 2000, '9780679783268', 1, 'https://covers.openlibrary.org/b/isbn/9780679783268-M.jpg', 3, 3),
(203, 'The Stranger', 'Albert Camus', 'novel', 1989, '9780679720201', 1, 'https://covers.openlibrary.org/b/isbn/9780679720201-M.jpg', 3, 3),
(204, 'Invisible Man', 'Ralph Ellison', 'novel', 1995, '9780679732761', 1, 'https://covers.openlibrary.org/b/isbn/9780679732761-M.jpg', 4, 4),
(205, 'The Great Gatsby', 'F. Scott Fitzgerald', 'novel', 2021, '9780743273565', 1, 'https://covers.openlibrary.org/b/isbn/9780743273565-M.jpg', 3, 3),
(206, 'The catcher in the rye', 'J. D. Salinger', 'novel', 2001, '9780316769174', 1, 'https://covers.openlibrary.org/b/isbn/9780316769174-M.jpg', 4, 4),
(208, 'Nineteen eighty-four', 'George Orwell', 'general', 2003, '9780452284234', 1, 'https://covers.openlibrary.org/b/isbn/9780452284234-M.jpg', 4, 4),
(209, 'Animal Farm', 'George Orwell', 'novel', 2003, '9780452284241', 1, 'https://covers.openlibrary.org/b/isbn/9780452284241-M.jpg', 4, 4),
(210, 'Wuthering Heights', 'Emily Brontë', 'novel', 2003, '9780141439556', 1, 'https://covers.openlibrary.org/b/isbn/9780141439556-M.jpg', 4, 4),
(211, 'The Decameron', 'Giovanni Boccaccio', 'novel', 2003, '9780140449303', 1, 'https://covers.openlibrary.org/b/isbn/9780140449303-M.jpg', 4, 4),
(212, 'Meditations', 'Marcus Aurelius', 'general', 2006, '9780140449334', 1, 'https://covers.openlibrary.org/b/isbn/9780140449334-M.jpg', 4, 4),
(213, 'The Aeneid', 'Publius Vergilius Maro', 'general', 2003, '9780140449327', 1, 'https://covers.openlibrary.org/b/isbn/9780140449327-M.jpg', 4, 4),
(214, 'The New Machiavelli (Penguin Classics)', 'H. G. Wells', 'novel', 2006, '9780141439990', 1, 'https://covers.openlibrary.org/b/isbn/9780141439990-M.jpg', 4, 4),
(215, 'JANE EYRE; ED. BY STEVIE DAVIES.', 'Charlotte Brontë', 'novel', 2006, '9780141441146', 1, 'https://covers.openlibrary.org/b/isbn/9780141441146-M.jpg', 4, 4),
(216, 'Emma', 'Jane Austen', 'general', 2015, '9780141439587', 1, 'https://covers.openlibrary.org/b/isbn/9780141439587-M.jpg', 4, 4),
(217, 'Caleb Williams (Penguin Classics)', 'William Godwin', 'novel', 2005, '9780141441238', 1, 'https://covers.openlibrary.org/b/isbn/9780141441238-M.jpg', 4, 4),
(1254, 'Fairy Tales and Feminism', 'Donald Haase', 'Literary Criticism', 2004, '9780814330302', 1, 'https://covers.openlibrary.org/b/isbn/9780814330302-L.jpg', 1, 1),
(1260, 'Mai ve Siyah (Günümüz Türkçesiyle)', 'Halid Ziya Uşaklıgil', 'Antiques & Collectibles', 2022, '9789750743689', 1, 'https://covers.openlibrary.org/b/isbn/9789750743689-L.jpg', 1, 1);

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

--
-- Tablo döküm verisi `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `book_id`, `borrow_date`, `due_date`, `return_date`, `status`) VALUES
(2, 2, 217, '2025-12-21', '2025-12-31', NULL, 'returned'),
(3, 2, 215, '2025-12-21', '2025-12-31', NULL, 'returned'),
(4, 2, 216, '2025-12-21', '2025-12-31', NULL, 'returned'),
(5, 3, 216, '2025-12-21', '2025-12-31', NULL, 'returned'),
(6, 3, 188, '2025-12-21', '2025-12-31', NULL, 'returned'),
(7, 3, 213, '2025-12-21', '2025-12-31', NULL, 'rejected'),
(8, 3, 156, '2025-12-21', '2025-12-31', NULL, 'returned'),
(9, 2, 217, '2025-12-22', '2026-01-01', '2025-12-22', 'returned');

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
(2, 'Sinem', 's@gmail.com', '$2y$10$pfQXfxPqes4wYkDhHZBAyOvXCUBATrsFla0.y5P30x/OKEFmpXwxO', 'user'),
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_isbn` (`isbn`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1261;

--
-- Tablo için AUTO_INCREMENT değeri `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
