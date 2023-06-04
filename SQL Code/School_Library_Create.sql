-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 04 Ιουν 2023 στις 22:49:52
-- Έκδοση διακομιστή: 10.4.28-MariaDB
-- Έκδοση PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `school_library`
--
CREATE DATABASE IF NOT EXISTS `school_library` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `school_library`;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE `administrator` (
  `Admin_ID` int(10) UNSIGNED NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Age` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `Author_ID` int(10) UNSIGNED NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `Book_ID` int(10) UNSIGNED NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Publisher` varchar(50) NOT NULL,
  `ISBN` varchar(50) NOT NULL,
  `Number_of_pages` int(10) UNSIGNED NOT NULL,
  `Summary` text NOT NULL,
  `Available_copies` int(10) UNSIGNED NOT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Language` varchar(50) NOT NULL,
  `Keywords` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Δείκτες `book`
--
DROP TRIGGER IF EXISTS `Update_Reservation_Status_OnHold`;
DELIMITER $$
CREATE TRIGGER `Update_Reservation_Status_OnHold` AFTER UPDATE ON `book` FOR EACH ROW BEGIN
    IF NEW.Available_copies = 0 THEN
        UPDATE Reservation
        SET Status = 'On Hold'
        WHERE Book_ID = NEW.Book_ID
        AND Status = 'Pending';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Update_Reservation_Status_Pending`;
DELIMITER $$
CREATE TRIGGER `Update_Reservation_Status_Pending` AFTER UPDATE ON `book` FOR EACH ROW BEGIN
    IF NEW.Available_copies > 0 THEN
        UPDATE Reservation
        SET Status = 'Pending'
        WHERE Book_ID = NEW.Book_ID
        AND Status = 'On Hold';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `book_author`
--

DROP TABLE IF EXISTS `book_author`;
CREATE TABLE `book_author` (
  `Author_ID` int(10) UNSIGNED NOT NULL,
  `Book_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `book_category`
--

DROP TABLE IF EXISTS `book_category`;
CREATE TABLE `book_category` (
  `Category_ID` int(10) UNSIGNED NOT NULL,
  `Book_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `book_libraryoperator`
--

DROP TABLE IF EXISTS `book_libraryoperator`;
CREATE TABLE `book_libraryoperator` (
  `LibraryOperator_ID` int(10) UNSIGNED NOT NULL,
  `Book_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `borrowing`
--

DROP TABLE IF EXISTS `borrowing`;
CREATE TABLE `borrowing` (
  `Borrowing_ID` int(10) UNSIGNED NOT NULL,
  `Borrowing_Date` date NOT NULL,
  `Return_Date` date NOT NULL,
  `Returned` tinyint(1) DEFAULT 0,
  `User_ID` int(10) UNSIGNED NOT NULL,
  `LibraryOperator_ID` int(10) UNSIGNED NOT NULL,
  `Book_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Δείκτες `borrowing`
--
DROP TRIGGER IF EXISTS `Enforce_Student_Borrowing_Limit`;
DELIMITER $$
CREATE TRIGGER `Enforce_Student_Borrowing_Limit` BEFORE INSERT ON `borrowing` FOR EACH ROW BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Student') THEN
    IF (
      SELECT COUNT(*)
      FROM Borrowing
      WHERE User_ID = NEW.User_ID AND Borrowing_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 2 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Students are allowed to borrow only two books per week!';
    END IF;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Enforce_Teacher_Borrowing_Limit`;
DELIMITER $$
CREATE TRIGGER `Enforce_Teacher_Borrowing_Limit` BEFORE INSERT ON `borrowing` FOR EACH ROW BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Teacher') THEN
    IF (
      SELECT COUNT(*)
      FROM Borrowing
      WHERE User_ID = NEW.User_ID AND Borrowing_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 1 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Teachers are allowed to borrow only one book per week!';
    END IF;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Prevent_Borrowing_If_No_Available_Copies`;
DELIMITER $$
CREATE TRIGGER `Prevent_Borrowing_If_No_Available_Copies` BEFORE INSERT ON `borrowing` FOR EACH ROW BEGIN
    IF (
        SELECT Available_copies
        FROM Book
        WHERE Book_ID = NEW.Book_ID
    ) = 0 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Borrowing not allowed: no available copies!';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Prevent_Borrowing_If_User_Has_Borrowed_This_Title`;
DELIMITER $$
CREATE TRIGGER `Prevent_Borrowing_If_User_Has_Borrowed_This_Title` BEFORE INSERT ON `borrowing` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE User_ID = NEW.User_ID AND Book_ID = NEW.Book_ID AND Returned = FALSE
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Borrowing not allowed: user has already borrowed the title!';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Prevent_Borrowing_If_User_Has_Delayed_Return`;
DELIMITER $$
CREATE TRIGGER `Prevent_Borrowing_If_User_Has_Delayed_Return` BEFORE INSERT ON `borrowing` FOR EACH ROW BEGIN
    IF (
        SELECT COUNT(*)
        FROM Borrowing
        WHERE User_ID = NEW.User_ID
        AND Return_Date < CURDATE()
        AND Returned = FALSE
    ) > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Borrowing not allowed: book not returned on time!';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Udate_Available_Copies_Borrowing`;
DELIMITER $$
CREATE TRIGGER `Udate_Available_Copies_Borrowing` AFTER INSERT ON `borrowing` FOR EACH ROW BEGIN
    UPDATE Book
    SET Available_copies = Available_copies - 1
    WHERE Book_ID = NEW.Book_ID;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Update_Available_Copies_Return`;
DELIMITER $$
CREATE TRIGGER `Update_Available_Copies_Return` AFTER UPDATE ON `borrowing` FOR EACH ROW BEGIN
    IF NEW.Returned = TRUE THEN
        UPDATE Book
        SET Available_copies = Available_copies + 1
        WHERE Book_ID = NEW.Book_ID;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `Category_ID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `libraryoperator`
--

DROP TABLE IF EXISTS `libraryoperator`;
CREATE TABLE `libraryoperator` (
  `LibraryOperator_ID` int(10) UNSIGNED NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Age` int(10) UNSIGNED NOT NULL,
  `Approved` tinyint(1) DEFAULT 0,
  `Admin_ID` int(10) UNSIGNED NOT NULL,
  `School_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `Reservation_ID` int(10) UNSIGNED NOT NULL,
  `Reservation_Date` date NOT NULL,
  `Status` enum('Completed','Pending','On Hold') DEFAULT 'Pending',
  `User_ID` int(10) UNSIGNED NOT NULL,
  `LibraryOperator_ID` int(10) UNSIGNED NOT NULL,
  `Book_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Δείκτες `reservation`
--
DROP TRIGGER IF EXISTS `Enforce_Student_Reservation_Limit`;
DELIMITER $$
CREATE TRIGGER `Enforce_Student_Reservation_Limit` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Student') THEN
    IF (
      SELECT COUNT(*)
      FROM Reservation
      WHERE User_ID = NEW.User_ID AND Reservation_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 2 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Students are allowed to reserve only two books per week!';
    END IF;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Enforce_Teacher_Reservation_Limit`;
DELIMITER $$
CREATE TRIGGER `Enforce_Teacher_Reservation_Limit` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Teacher') THEN
    IF (
      SELECT COUNT(*)
      FROM Reservation
      WHERE User_ID = NEW.User_ID AND Reservation_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 1 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Teachers are allowed to reserve only one book per week!';
    END IF;
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Insert_Reservation_Status_OnHold`;
DELIMITER $$
CREATE TRIGGER `Insert_Reservation_Status_OnHold` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
    IF (
        SELECT Available_copies
        FROM Book
        WHERE Book_ID = NEW.Book_ID
    ) = 0 THEN
        SET NEW.Status = 'On Hold';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Prevent_Reservation_If_User_Has_Borrowed_This_Title`;
DELIMITER $$
CREATE TRIGGER `Prevent_Reservation_If_User_Has_Borrowed_This_Title` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE User_ID = NEW.User_ID AND Book_ID = NEW.Book_ID AND Returned = FALSE
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Reservation not allowed: user has already borrowed the title!';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `Prevent_Reservation_If_User_Has_Delayed_Return`;
DELIMITER $$
CREATE TRIGGER `Prevent_Reservation_If_User_Has_Delayed_Return` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
	IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE User_ID = NEW.User_ID AND Return_Date < CURDATE() AND Returned = FALSE
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Reservation not allowed: book not returned on time!';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `Review_ID` int(10) UNSIGNED NOT NULL,
  `Text` text NOT NULL,
  `Rating` int(11) NOT NULL,
  `Approved` tinyint(1) DEFAULT 0,
  `User_ID` int(10) UNSIGNED NOT NULL,
  `LibraryOperator_ID` int(10) UNSIGNED NOT NULL,
  `Book_ID` int(10) UNSIGNED NOT NULL
) ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `school`
--

DROP TABLE IF EXISTS `school`;
CREATE TABLE `school` (
  `School_ID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone_Number` char(10) NOT NULL,
  `Director_Fullname` varchar(50) NOT NULL,
  `Admin_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `User_ID` int(10) UNSIGNED NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Age` int(10) UNSIGNED NOT NULL,
  `Role` enum('Student','Teacher') NOT NULL,
  `Approved` tinyint(1) DEFAULT 0,
  `School_ID` int(10) UNSIGNED NOT NULL,
  `LibraryOperator_ID` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`Admin_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Ευρετήρια για πίνακα `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`Author_ID`),
  ADD KEY `Author_idx` (`Author_ID`);

--
-- Ευρετήρια για πίνακα `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`Book_ID`);

--
-- Ευρετήρια για πίνακα `book_author`
--
ALTER TABLE `book_author`
  ADD PRIMARY KEY (`Author_ID`,`Book_ID`),
  ADD KEY `fk_Book_Author_ID_idx` (`Book_ID`);

--
-- Ευρετήρια για πίνακα `book_category`
--
ALTER TABLE `book_category`
  ADD PRIMARY KEY (`Category_ID`,`Book_ID`),
  ADD KEY `fk_Book_Category_ID_idx` (`Book_ID`);

--
-- Ευρετήρια για πίνακα `book_libraryoperator`
--
ALTER TABLE `book_libraryoperator`
  ADD PRIMARY KEY (`LibraryOperator_ID`,`Book_ID`),
  ADD KEY `fk_Book_LibraryOperator_ID_idx` (`Book_ID`);

--
-- Ευρετήρια για πίνακα `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`Borrowing_ID`),
  ADD KEY `fk_Borrowing_User_idx` (`User_ID`),
  ADD KEY `fk_Borrowing_LibraryOperator_idx` (`LibraryOperator_ID`),
  ADD KEY `fk_Borrowing_Book_idx` (`Book_ID`);

--
-- Ευρετήρια για πίνακα `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `Category_idx` (`Category_ID`);

--
-- Ευρετήρια για πίνακα `libraryoperator`
--
ALTER TABLE `libraryoperator`
  ADD PRIMARY KEY (`LibraryOperator_ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `fk_LibraryOperator_Admin_idx` (`Admin_ID`),
  ADD KEY `fk_LibraryOperator_School_idx` (`School_ID`);

--
-- Ευρετήρια για πίνακα `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Reservation_ID`),
  ADD KEY `fk_Reservation_User_idx` (`User_ID`),
  ADD KEY `fk_Reservation_LibraryOperator_idx` (`LibraryOperator_ID`),
  ADD KEY `fk_Reservation_Book_idx` (`Book_ID`);

--
-- Ευρετήρια για πίνακα `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Review_ID`),
  ADD KEY `fk_Review_User_idx` (`User_ID`),
  ADD KEY `fk_Review_LibraryOperator_idx` (`LibraryOperator_ID`),
  ADD KEY `fk_Review_Book_idx` (`Book_ID`);

--
-- Ευρετήρια για πίνακα `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`School_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`),
  ADD KEY `fk_School_Admin_idx` (`Admin_ID`);

--
-- Ευρετήρια για πίνακα `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `fk_User_School_idx` (`School_ID`),
  ADD KEY `fk_User_LibraryOperator_idx` (`LibraryOperator_ID`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `administrator`
--
ALTER TABLE `administrator`
  MODIFY `Admin_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `author`
--
ALTER TABLE `author`
  MODIFY `Author_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `book`
--
ALTER TABLE `book`
  MODIFY `Book_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `borrowing`
--
ALTER TABLE `borrowing`
  MODIFY `Borrowing_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `libraryoperator`
--
ALTER TABLE `libraryoperator`
  MODIFY `LibraryOperator_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Reservation_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `review`
--
ALTER TABLE `review`
  MODIFY `Review_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `school`
--
ALTER TABLE `school`
  MODIFY `School_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `fk_Author_ID` FOREIGN KEY (`Author_ID`) REFERENCES `author` (`Author_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Book_Author_ID` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `book_category`
--
ALTER TABLE `book_category`
  ADD CONSTRAINT `fk_Book_Category_ID` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Category_ID` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `book_libraryoperator`
--
ALTER TABLE `book_libraryoperator`
  ADD CONSTRAINT `fk_Book_LibraryOperator_ID` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_LibraryOperator_ID` FOREIGN KEY (`LibraryOperator_ID`) REFERENCES `libraryoperator` (`LibraryOperator_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `borrowing`
--
ALTER TABLE `borrowing`
  ADD CONSTRAINT `fk_Borrowing_Book` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Borrowing_LibraryOperator` FOREIGN KEY (`LibraryOperator_ID`) REFERENCES `libraryoperator` (`LibraryOperator_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Borrowing_User` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `libraryoperator`
--
ALTER TABLE `libraryoperator`
  ADD CONSTRAINT `fk_LibraryOperator_Admin` FOREIGN KEY (`Admin_ID`) REFERENCES `administrator` (`Admin_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_LibraryOperator_School` FOREIGN KEY (`School_ID`) REFERENCES `school` (`School_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_Reservation_Book` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Reservation_LibraryOperator` FOREIGN KEY (`LibraryOperator_ID`) REFERENCES `libraryoperator` (`LibraryOperator_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Reservation_User` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_Review_Book` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Review_LibraryOperator` FOREIGN KEY (`LibraryOperator_ID`) REFERENCES `libraryoperator` (`LibraryOperator_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Review_User` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `fk_School_Admin` FOREIGN KEY (`Admin_ID`) REFERENCES `administrator` (`Admin_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Περιορισμοί για πίνακα `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_LibraryOperator` FOREIGN KEY (`LibraryOperator_ID`) REFERENCES `libraryoperator` (`LibraryOperator_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_User_School` FOREIGN KEY (`School_ID`) REFERENCES `school` (`School_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Συμβάντα
--
DROP EVENT IF EXISTS `Cancel_Expired_Reservations`$$
CREATE DEFINER=`root`@`localhost` EVENT `Cancel_Expired_Reservations` ON SCHEDULE EVERY 1 DAY STARTS '2023-06-04 23:49:03' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM Reservation
    WHERE Reservation_Date + INTERVAL 1 WEEK <= CURDATE()
    AND Status = 'Pending'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
