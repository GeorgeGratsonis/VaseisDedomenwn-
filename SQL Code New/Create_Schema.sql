CREATE SCHEMA IF NOT EXISTS School_Library;

USE School_Library;

-- Table 'Administrator'

CREATE TABLE IF NOT EXISTS Administrator (
	Admin_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    First_Name VARCHAR(50) NOT NULL,
    Last_Name VARCHAR(50) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(50) NOT NULL,
    Age INT UNSIGNED NOT NULL,
    PRIMARY KEY (Admin_ID)
) ENGINE = InnoDB;

 -- Table 'School'

CREATE TABLE IF NOT EXISTS School (
	School_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL UNIQUE,
    Address VARCHAR(50) NOT NULL,
    City VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Phone_Number CHAR(10) NOT NULL UNIQUE,
    Director_Fullname VARCHAR(50) NOT NULL,
    Admin_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (School_ID),
    INDEX fk_School_Admin_idx (Admin_ID ASC) ,
    CONSTRAINT fk_School_Admin
		FOREIGN KEY (Admin_ID)
		REFERENCES Administrator (Admin_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

 -- Table 'LibraryOperator'

CREATE TABLE IF NOT EXISTS LibraryOperator (
	LibraryOperator_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    First_Name VARCHAR(50) NOT NULL,
    Last_Name VARCHAR(50) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(50) NOT NULL,
    Age INT UNSIGNED NOT NULL,
	Approved BOOLEAN DEFAULT FALSE,
    Admin_ID INT UNSIGNED NOT NULL,
	School_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (LibraryOperator_ID),
    INDEX fk_LibraryOperator_Admin_idx (Admin_ID ASC),
    INDEX fk_LibraryOperator_School_idx (School_ID ASC),
    CONSTRAINT fk_LibraryOperator_Admin
		FOREIGN KEY (Admin_ID)
		REFERENCES Administrator (Admin_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
    CONSTRAINT fk_LibraryOperator_School
		FOREIGN KEY (School_ID)
		REFERENCES School (School_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'User'

CREATE TABLE IF NOT EXISTS User (
	User_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(50) NOT NULL,
    First_Name VARCHAR(50) NOT NULL,
    Last_Name VARCHAR(50) NOT NULL,
    Age INT UNSIGNED NOT NULL,
    Role ENUM('Student', 'Teacher') NOT NULL,
	Approved BOOLEAN DEFAULT FALSE,
	School_ID INT UNSIGNED NOT NULL,
    LibraryOperator_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (User_ID),
    INDEX fk_User_School_idx (School_ID ASC),
    INDEX fk_User_LibraryOperator_idx (LibraryOperator_ID ASC),
    CONSTRAINT fk_User_School
		FOREIGN KEY (School_ID)
		REFERENCES School (School_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
    CONSTRAINT fk_User_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
        ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Book'

CREATE TABLE IF NOT EXISTS Book (
	Book_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Title VARCHAR(50) NOT NULL,
    Publisher VARCHAR(50) NOT NULL,
    ISBN VARCHAR(50) NOT NULL,
    Number_of_pages INT UNSIGNED NOT NULL,
    Summary TEXT NOT NULL,
    Available_copies INT UNSIGNED NOT NULL,
    Image VARCHAR(100),
    Language VARCHAR(50) NOT NULL,
    Keywords VARCHAR(100) NOT NULL,
    PRIMARY KEY (Book_ID)
) ENGINE = InnoDB;

-- Table 'Author'

CREATE TABLE IF NOT EXISTS Author (
	Author_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    First_Name VARCHAR(50) NOT NULL,
    Last_Name VARCHAR(50) NOT NULL,
    INDEX Author_idx (Author_ID),
    PRIMARY KEY (Author_ID)
) ENGINE = InnoDB;

-- Table 'Category'

CREATE TABLE IF NOT EXISTS Category (
	Category_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL UNIQUE,
    INDEX Category_idx (Category_ID),
    PRIMARY KEY (Category_ID)
) ENGINE = InnoDB;

-- Table 'Borrowing'

CREATE TABLE IF NOT EXISTS Borrowing (
	Borrowing_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Borrowing_Date DATE NOT NULL,
    Return_Date DATE NOT NULL,
    Returned BOOLEAN DEFAULT FALSE,
	User_ID INT UNSIGNED NOT NULL,
    LibraryOperator_ID INT UNSIGNED NOT NULL,
    Book_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (Borrowing_ID),
    INDEX fk_Borrowing_User_idx (User_ID ASC),
    INDEX fk_Borrowing_LibraryOperator_idx (LibraryOperator_ID ASC),
    INDEX fk_Borrowing_Book_idx (Book_ID ASC),
    CONSTRAINT fk_Borrowing_User
		FOREIGN KEY (User_ID)
		REFERENCES User (User_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
    CONSTRAINT fk_Borrowing_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
		ON DELETE CASCADE		
        ON UPDATE CASCADE,
	CONSTRAINT fk_Borrowing_Book
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Reservation'

CREATE TABLE IF NOT EXISTS Reservation (
	Reservation_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Reservation_Date DATE NOT NULL,
	Status ENUM('Completed', 'Pending', 'On Hold') DEFAULT 'Pending',
	User_ID INT UNSIGNED NOT NULL,
    LibraryOperator_ID INT UNSIGNED NOT NULL,
    Book_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (Reservation_ID),
    INDEX fk_Reservation_User_idx (User_ID ASC),
    INDEX fk_Reservation_LibraryOperator_idx (LibraryOperator_ID ASC),
    INDEX fk_Reservation_Book_idx (Book_ID ASC),
    CONSTRAINT fk_Reservation_User
		FOREIGN KEY (User_ID)
		REFERENCES User (User_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
    CONSTRAINT fk_Reservation_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
		ON DELETE CASCADE		
        ON UPDATE CASCADE,
    CONSTRAINT fk_Reservation_Book
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Review'

CREATE TABLE IF NOT EXISTS Review (
	Review_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Text TEXT NOT NULL,
    Rating INT NOT NULL,
    CONSTRAINT Check_Rating CHECK (Rating BETWEEN 1 AND 5),
	Approved BOOLEAN DEFAULT FALSE,
	User_ID INT UNSIGNED NOT NULL,
    LibraryOperator_ID INT UNSIGNED NOT NULL,
    Book_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (Review_ID),
    INDEX fk_Review_User_idx (User_ID ASC),
    INDEX fk_Review_LibraryOperator_idx (LibraryOperator_ID ASC),
    INDEX fk_Review_Book_idx (Book_ID ASC),
    CONSTRAINT fk_Review_User
		FOREIGN KEY (User_ID)
		REFERENCES User (User_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
    CONSTRAINT fk_Review_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
        ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk_Review_Book
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Book_Author'

CREATE TABLE IF NOT EXISTS Book_Author (
	Author_ID INT UNSIGNED NOT NULL,
    Book_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (Author_ID, Book_ID),
    INDEX fk_Book_Author_ID_idx (Book_ID ASC),
    CONSTRAINT fk_Author_ID
		FOREIGN KEY (Author_ID)
		REFERENCES Author (Author_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
    CONSTRAINT fk_Book_Author_ID
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Book_Category'

CREATE TABLE IF NOT EXISTS Book_Category (
	Category_ID INT UNSIGNED NOT NULL,
	Book_ID INT UNSIGNED NOT NULL,
	PRIMARY KEY (Category_ID, Book_ID),
	INDEX fk_Book_Category_ID_idx (Book_ID ASC),
	CONSTRAINT fk_Category_ID
		FOREIGN KEY (Category_ID)
		REFERENCES Category (Category_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk_Book_Category_ID
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Book_LibraryOperator'

CREATE TABLE IF NOT EXISTS Book_LibraryOperator (
	LibraryOperator_ID INT UNSIGNED NOT NULL,
	Book_ID INT UNSIGNED NOT NULL,
	PRIMARY KEY (LibraryOperator_ID, Book_ID),
	INDEX fk_Book_LibraryOperator_ID_idx (Book_ID ASC),
	CONSTRAINT fk_LibraryOperator_ID
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT fk_Book_LibraryOperator_ID
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Triggers

DELIMITER //

CREATE TRIGGER Udate_Available_Copies_Borrowing
AFTER INSERT ON Borrowing
FOR EACH ROW
BEGIN
    UPDATE Book
    SET Available_copies = Available_copies - 1
    WHERE Book_ID = NEW.Book_ID;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Update_Available_Copies_Return
AFTER UPDATE ON Borrowing
FOR EACH ROW
BEGIN
    IF NEW.Returned = TRUE THEN
        UPDATE Book
        SET Available_copies = Available_copies + 1
        WHERE Book_ID = NEW.Book_ID;
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Enforce_Student_Borrowing_Limit
BEFORE INSERT ON Borrowing
FOR EACH ROW
BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Student') THEN
    IF (
      SELECT COUNT(*)
      FROM Borrowing
      WHERE User_ID = NEW.User_ID AND Borrowing_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 2 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Students are allowed to borrow only two books per week!';
    END IF;
  END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Enforce_Teacher_Borrowing_Limit
BEFORE INSERT ON Borrowing
FOR EACH ROW
BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Teacher') THEN
    IF (
      SELECT COUNT(*)
      FROM Borrowing
      WHERE User_ID = NEW.User_ID AND Borrowing_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 1 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Teachers are allowed to borrow only one book per week!';
    END IF;
  END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Enforce_Student_Reservation_Limit
BEFORE INSERT ON Reservation
FOR EACH ROW
BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Student') THEN
    IF (
      SELECT COUNT(*)
      FROM Reservation
      WHERE User_ID = NEW.User_ID AND Reservation_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 2 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Students are allowed to reserve only two books per week!';
    END IF;
  END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Enforce_Teacher_Reservation_Limit
BEFORE INSERT ON Reservation
FOR EACH ROW
BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Teacher') THEN
    IF (
      SELECT COUNT(*)
      FROM Reservation
      WHERE User_ID = NEW.User_ID AND Reservation_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 1 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Teachers are allowed to reserve only one book per week!';
    END IF;
  END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Prevent_Borrowing_If_User_Has_Delayed_Return
BEFORE INSERT ON Borrowing
FOR EACH ROW
BEGIN
    IF (
        SELECT COUNT(*)
        FROM Borrowing
        WHERE User_ID = NEW.User_ID
        AND Return_Date < CURDATE()
        AND Returned = FALSE
    ) > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Borrowing not allowed: book not returned on time!';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Prevent_Borrowing_If_No_Available_Copies
BEFORE INSERT ON Borrowing
FOR EACH ROW
BEGIN
    IF (
        SELECT Available_copies
        FROM Book
        WHERE Book_ID = NEW.Book_ID
    ) = 0 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Borrowing not allowed: no available copies!';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Prevent_Borrowing_If_User_Has_Borrowed_This_Title
BEFORE INSERT ON Borrowing
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE User_ID = NEW.User_ID AND Book_ID = NEW.Book_ID AND Returned = FALSE
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Borrowing not allowed: user has already borrowed the title!';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Prevent_Reservation_If_User_Has_Borrowed_This_Title
BEFORE INSERT ON Reservation
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE User_ID = NEW.User_ID AND Book_ID = NEW.Book_ID AND Returned = FALSE
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Reservation not allowed: user has already borrowed the title!';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Prevent_Reservation_If_User_Has_Delayed_Return
BEFORE INSERT ON Reservation
FOR EACH ROW
BEGIN
	IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE User_ID = NEW.User_ID AND Return_Date < CURDATE() AND Returned = FALSE
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Reservation not allowed: book not returned on time!';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Insert_Reservation_Status_OnHold
BEFORE INSERT ON Reservation
FOR EACH ROW
BEGIN
    IF (
        SELECT Available_copies
        FROM Book
        WHERE Book_ID = NEW.Book_ID
    ) = 0 THEN
        SET NEW.Status = 'On Hold';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Update_Reservation_Status_OnHold
AFTER UPDATE ON Book
FOR EACH ROW
BEGIN
    IF NEW.Available_copies = 0 THEN
        UPDATE Reservation
        SET Status = 'On Hold'
        WHERE Book_ID = NEW.Book_ID
        AND Status = 'Pending';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Update_Reservation_Status_Pending
AFTER UPDATE ON Book
FOR EACH ROW
BEGIN
    IF NEW.Available_copies > 0 THEN
        UPDATE Reservation
        SET Status = 'Pending'
        WHERE Book_ID = NEW.Book_ID
        AND Status = 'On Hold';
    END IF;
END //

DELIMITER ;

-- Events

SET GLOBAL Event_Scheduler = ON;

CREATE EVENT Cancel_Expired_Reservations
ON SCHEDULE EVERY 1 DAY
DO
    DELETE FROM Reservation
    WHERE Reservation_Date + INTERVAL 1 WEEK <= CURDATE()
    AND Status = 'Pending';
    
    drop schema school_library;
