SET GLOBAL Event_Scheduler = ON;

CREATE DATABASE IF NOT EXISTS School_Library;

USE School_Library;

-- Table 'Administrator'

CREATE TABLE IF NOT EXISTS Administrator (
	Admin_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    First_Name VARCHAR(50) NOT NULL,
    Last_Name VARCHAR(50) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(50) NOT NULL,
    PRIMARY KEY (Admin_ID)
) ENGINE = InnoDB;

 -- Table 'School'

CREATE TABLE IF NOT EXISTS School (
	School_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL UNIQUE,
    Adress VARCHAR(50) NOT NULL,
    City VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Director_Fullname VARCHAR(50) NOT NULL,
    Admin_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (School_ID),
    INDEX fk_School_Admin_idx (Admin_ID ASC) ,
    CONSTRAINT fk_School_Admin
		FOREIGN KEY (Admin_ID)
		REFERENCES Administrator (Admin_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
) ENGINE = InnoDB;

 -- Table 'LibraryOperator'

CREATE TABLE IF NOT EXISTS LibraryOperator (
	LibraryOperator_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    First_Name VARCHAR(50) NOT NULL,
    Last_Name VARCHAR(50) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(50) NOT NULL,
    Admin_ID INT UNSIGNED NOT NULL,
	School_ID INT UNSIGNED NOT NULL UNIQUE,
    PRIMARY KEY (LibraryOperator_ID),
    INDEX fk_LibraryOperator_Admin_idx (Admin_ID ASC),
    INDEX fk_LibraryOperator_School_idx (School_ID ASC),
    CONSTRAINT fk_LibraryOperator_Admin
		FOREIGN KEY (Admin_ID)
		REFERENCES Administrator (Admin_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    CONSTRAINT fk_LibraryOperator_School
		FOREIGN KEY (School_ID)
		REFERENCES School (School_ID)
		ON DELETE RESTRICT
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
    Role ENUM('Student', 'Professor') NOT NULL,
    CONSTRAINT Check_Age CHECK ( (Role = 'Professor' AND Age > 25) OR (Role = 'Student' AND Age BETWEEN 6 AND 18) ),
	School_ID INT UNSIGNED NOT NULL,
    LibraryOperator_ID INT UNSIGNED NOT NULL,
    PRIMARY KEY (User_ID),
    INDEX fk_User_School_idx (School_ID ASC),
    INDEX fk_User_LibraryOperator_idx (LibraryOperator_ID ASC),
    CONSTRAINT fk_User_School
		FOREIGN KEY (School_ID)
		REFERENCES School (School_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    CONSTRAINT fk_User_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
		ON DELETE RESTRICT
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
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    CONSTRAINT fk_Borrowing_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
	CONSTRAINT fk_Borrowing_Book
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Reservation'

CREATE TABLE IF NOT EXISTS Reservation (
	Reservation_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Reservation_Date DATE NOT NULL,
	Status ENUM('Completed', 'Pending', 'On Hold', 'Cancelled') NOT NULL,
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
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    CONSTRAINT fk_Reservation_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    CONSTRAINT fk_Reservation_Book
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'Review'

CREATE TABLE IF NOT EXISTS Review (
	Review_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Text TEXT NOT NULL,
    Rating INT NOT NULL,
    CONSTRAINT Check_Rating CHECK (Rating BETWEEN 1 AND 5),
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
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    CONSTRAINT fk_Review_LibraryOperator
		FOREIGN KEY (LibraryOperator_ID)
		REFERENCES LibraryOperator (LibraryOperator_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
	CONSTRAINT fk_Review_Book
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE RESTRICT
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
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    CONSTRAINT fk_Book_Author_ID
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE RESTRICT
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
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
	CONSTRAINT fk_Book_Category_ID
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE RESTRICT
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
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
	CONSTRAINT fk_Book_LibraryOperator_ID
		FOREIGN KEY (Book_ID)
		REFERENCES Book (Book_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Table 'School_Phone'

CREATE TABLE IF NOT EXISTS School_Phone (
	School_ID INT UNSIGNED NOT NULL,
	Phone_Number CHAR(10) NOT NULL UNIQUE,
	CONSTRAINT check_phone CHECK (Phone_Number RLIKE('[0-9]{10}')),
	PRIMARY KEY (Phone_Number),
	CONSTRAINT fk_School_ID
		FOREIGN KEY (School_ID)
		REFERENCES School (School_ID)
		ON DELETE RESTRICT
		ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Triggers

DELIMITER //

CREATE TRIGGER Check_Username_Administrator
BEFORE INSERT ON Administrator
FOR EACH ROW
BEGIN
    IF EXISTS(SELECT 1 FROM LibraryOperator WHERE Username = NEW.Username) OR EXISTS(SELECT 1 FROM User WHERE Username = NEW.Username) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Username is already in use.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Check_Username_LibraryOperator
BEFORE INSERT ON LibraryOperator
FOR EACH ROW
BEGIN
    IF EXISTS(SELECT 1 FROM Administrator WHERE Username = NEW.Username) OR EXISTS (SELECT 1 FROM User WHERE Username = NEW.Username) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Username is already in use.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Check_Username_User
BEFORE INSERT ON User
FOR EACH ROW
BEGIN
    IF EXISTS(SELECT 1 FROM Administrator WHERE Username = NEW.Username) OR EXISTS (SELECT 1 FROM LibraryOperator WHERE Username = NEW.Username) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Username is already in use.';
    END IF;
END //

DELIMITER ;

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
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Students are allowed to borrow only two books per week.';
    END IF;
  END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Enforce_Professor_Borrowing_Limit
BEFORE INSERT ON Borrowing
FOR EACH ROW
BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Professor') THEN
    IF (
      SELECT COUNT(*)
      FROM Borrowing
      WHERE User_ID = NEW.User_ID AND Borrowing_Date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    ) >= 1 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Professors are allowed to borrow only one book per week.';
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
      WHERE User_ID = NEW.User_ID AND Status = 'Pending'
    ) >= 2 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Students are allowed to reserve only two books per week.';
    END IF;
  END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Enforce_Professor_Reservation_Limit
BEFORE INSERT ON Reservation
FOR EACH ROW
BEGIN
  IF NEW.User_ID IN (SELECT User_ID FROM User WHERE Role = 'Professor') THEN
    IF (
      SELECT COUNT(*)
      FROM Reservation
      WHERE User_ID = NEW.User_ID AND Status = 'Pending'
    ) >= 1 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Professors are allowed to reserve only one book per week.';
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
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Borrowing not allowed: book not returned on time.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Prevent_Reservation
BEFORE INSERT ON Reservation
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE User_ID = NEW.User_ID AND Book_ID = NEW.Book_ID AND Returned = FALSE
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Reservation not allowed: user has already borrowed the title.';
    END IF;

    IF EXISTS (
        SELECT *
        FROM Borrowing
        WHERE Book_ID = NEW.Book_ID AND Return_Date < CURDATE()
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Reservation not allowed: book not returned on time.';
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER Update_Reservation_Status_OnHold
AFTER INSERT ON Reservation
FOR EACH ROW
BEGIN
    IF (
        SELECT Available_copies
        FROM Book
        WHERE Book_ID = NEW.Book_ID
    ) = 0 THEN
        UPDATE Reservation
        SET Status = 'On Hold'
        WHERE Reservation_ID = NEW.Reservation_ID;
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

DELIMITER //

CREATE TRIGGER Update_Reservation_Status_Completed
AFTER INSERT ON Borrowing
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1
        FROM Reservation
        WHERE User_ID = NEW.User_ID
            AND Book_ID = NEW.Book_ID
            AND Status = 'Pending'
    ) THEN
        UPDATE Reservation
        SET Status = 'Completed'
        WHERE User_ID = NEW.User_ID
            AND Book_ID = NEW.Book_ID;
    END IF;
END //

DELIMITER ;

DELIMITER //

-- Events

CREATE EVENT Cancel_Expired_Reservations
ON SCHEDULE EVERY 1 DAY
DO
    UPDATE Reservation
    SET Status = 'Cancelled'
    WHERE Reservation_Date + INTERVAL 1 WEEK <= CURDATE()
    AND Status != 'Completed';