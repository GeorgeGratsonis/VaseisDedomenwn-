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
    Availiable_copies INT UNSIGNED NOT NULL,
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
    Cancelled BOOLEAN DEFAULT FALSE,
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
    SET Availiable_copies = Availiable_copies - 1
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
        SET Availiable_copies = Availiable_copies + 1
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

CREATE TRIGGER Cancel_Expired_Reservations
BEFORE INSERT ON Borrowing
FOR EACH ROW
BEGIN
  UPDATE Reservation SET Cancelled = 1 WHERE Book_ID = NEW.Book_ID AND User_ID = NEW.User_ID AND Reservation_Date < DATE_SUB(CURDATE(), INTERVAL 7 DAY);
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
      WHERE User_ID = NEW.User_ID AND Cancelled = FALSE
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
      WHERE User_ID = NEW.User_ID AND Cancelled = FALSE
    ) >= 1 THEN
      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Professors are allowed to reserve only one book per week.';
    END IF;
  END IF;
END //

DELIMITER ;

-- Views