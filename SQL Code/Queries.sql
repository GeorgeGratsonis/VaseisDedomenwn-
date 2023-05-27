use School_Library;

-- 4.1 Administrator

-- 4.1.1

SELECT School.Name AS School_Name, COUNT(Borrowing.Borrowing_ID) AS Books_Borrowed
FROM School
JOIN User ON School.School_ID = User.School_ID
JOIN Borrowing ON User.User_ID = Borrowing.User_ID
WHERE YEAR(Borrowing.Borrowing_Date) = 2023
AND MONTH(Borrowing.Borrowing_Date) = 5
GROUP BY School.School_ID;

-- 4.1.2

SELECT CONCAT(Author.First_Name, ' ', Author.Last_Name) As Author_Fullname, CONCAT(User.First_Name, ' ', User.Last_Name) As Professor_Fullname
FROM Author
JOIN Book_Author ON Author.Author_ID = Book_Author.Author_ID
JOIN Book ON Book_Author.Book_ID = Book.Book_ID
JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
JOIN Category ON Book_Category.Category_ID = Category.Category_ID
JOIN Borrowing ON Book.Book_ID = Borrowing.Book_ID
JOIN User ON Borrowing.User_ID = User.User_ID
WHERE Category.Name = 'Catergory Name'
AND User.Role = 'Professor'
AND Borrowing.Borrowing_Date >= DATE_SUB(NOW(), INTERVAL 1 YEAR);

-- 4.1.3

SELECT CONCAT(User.First_Name, ' ', User.Last_Name) AS Professor_Fullname, COUNT(Borrowing.Book_ID) AS Books_Borrowed
FROM User
JOIN Borrowing ON User.User_ID = Borrowing.User_ID
WHERE User.Role = 'Professor' AND User.Age < 40
GROUP BY User.User_ID
ORDER BY Books_Borrowed DESC;

-- 4.1.4

SELECT CONCAT(Author.First_Name, ' ', Author.Last_Name) As Author_Fullname
FROM Author
LEFT JOIN Book_Author ON Author.Author_ID = Book_Author.Author_ID
LEFT JOIN Book ON Book_Author.Book_ID = Book.Book_ID
LEFT JOIN Borrowing ON Book.Book_ID = Borrowing.Book_ID
WHERE Borrowing.Book_ID IS NULL;

-- 4.1.5

SELECT GROUP_CONCAT(CONCAT(LibraryOperator.First_Name, ' ', LibraryOperator.Last_Name) SEPARATOR ', ') AS LibraryOperators_Fullnames, Borrowing.Loans
FROM (
  SELECT Borrowing.LibraryOperator_ID, COUNT(*) AS Loans
  FROM Borrowing
  WHERE Borrowing.Borrowing_Date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
  GROUP BY Borrowing.LibraryOperator_ID
  HAVING COUNT(*) > 20
) AS Borrowing
JOIN LibraryOperator ON Borrowing.LibraryOperator_ID = LibraryOperator.LibraryOperator_ID
GROUP BY Borrowing.Loans
HAVING COUNT(*) > 1;

-- 4.1.6

SELECT C1.Name AS Category1, C2.Name AS Category2, COUNT(*) AS Borrowings
FROM Book_Category BC1
JOIN Book_Category BC2 ON BC1.Book_ID = BC2.Book_ID AND BC1.Category_ID < BC2.Category_ID
JOIN Borrowing B ON BC1.Book_ID = B.Book_ID
JOIN Category C1 ON BC1.Category_ID = C1.Category_ID
JOIN Category C2 ON BC2.Category_ID = C2.Category_ID
GROUP BY C1.Name, C2.Name
ORDER BY Borrowings DESC
LIMIT 3;

-- 4.1.7

SELECT CONCAT(Author.First_Name, ' ', Author.Last_Name) As Author_Fullname, COUNT(*) AS Books_Written
FROM Author
JOIN Book_Author ON Author.Author_ID = Book_Author.Author_ID
GROUP BY Author.Author_ID, Author.First_Name, Author.Last_Name
HAVING COUNT(*) >= (
    SELECT MAX(Book_Count) - 5
    FROM (
        SELECT COUNT(*) AS Book_Count
        FROM Book_Author
        GROUP BY Author_ID
    ) AS Counts
);

-- 4.2 Operator

-- 4.2.1

SELECT Book.Title, CONCAT(Author.First_Name, ' ', Author.Last_Name) AS Author_Fullname
FROM Book
JOIN Book_Author ON Book.Book_ID = Book_Author.Book_ID
JOIN Author ON Book_Author.Author_ID = Author.Author_ID
JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
JOIN Category ON Book_Category.Category_ID = Category.Category_ID
WHERE Book.Title LIKE 'Title'
OR Category.Name LIKE 'Category Name'
OR CONCAT(Author.First_Name, ' ', Author.Last_Name) LIKE 'Author Fullname'
OR Book.Available_copies >= 'Number';

-- 4.2.2

SELECT CONCAT(User.First_Name, ' ', User.Last_Name) As User_Fullname, User.Role, DATEDIFF(CURRENT_DATE, Borrowing.Return_Date) AS Delay_Days
FROM User
JOIN Borrowing ON User.User_ID = Borrowing.User_ID
WHERE Borrowing.Returned = FALSE
AND DATEDIFF(CURRENT_DATE, Borrowing.Return_Date) > 0
AND (User.First_Name LIKE 'User First Name'
OR User.Last_Name LIKE 'User Last Name'
OR DATEDIFF(CURRENT_DATE, Borrowing.Return_Date) > 'Delay Days');

-- 4.2.3

SELECT CONCAT(User.First_Name, ' ', User.Last_Name) As User_Fullname, Category.Name AS Category, AVG(Review.Rating) AS Average_Rating
FROM User
JOIN Review ON User.User_ID = Review.User_ID
JOIN Book ON Review.Book_ID = Book.Book_ID
JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
JOIN Category ON Book_Category.Category_ID = Category.Category_ID
WHERE CONCAT(User.First_Name, ' ', User.Last_Name) LIKE 'User Fullname'
OR Category.Name LIKE 'Category Name'
GROUP BY User.User_ID, Category.Category_ID;

-- 4.3 User

-- 4.3.1

SELECT Book.Book_ID, Book.Title, Book.Publisher, Book.ISBN, Book.Number_of_pages, Book.Summary, Book.Available_copies, Book.Image, Book.Language, Book.Keywords, 
GROUP_CONCAT(DISTINCT Author.First_Name, ' ', Author.Last_Name) AS Authors, GROUP_CONCAT(DISTINCT Category.Name) AS Categories
FROM Book
JOIN Book_Author ON Book.Book_ID = Book_Author.Book_ID
JOIN Author ON Book_Author.Author_ID = Author.Author_ID
JOIN Book_Category ON Book.Book_ID = Book_Category.Book_ID
JOIN Category ON Book_Category.Category_ID = Category.Category_ID
WHERE Book.Title LIKE 'Title'
OR CONCAT(Author.First_Name, ' ', Author.Last_Name) LIKE 'Author Fullname'
OR Category.Name LIKE 'Category Name'
GROUP BY Book.Book_ID;

-- 4.3.2

SELECT Book.Book_ID, Book.Title, Book.Publisher, Book.ISBN, Book.Number_of_pages, Book.Summary, Book.Available_copies, Book.Image,Book.Language, Book.Keywords
FROM Borrowing
JOIN User ON Borrowing.User_ID = User.User_ID
JOIN Book ON Borrowing.Book_ID = Book.Book_ID
WHERE User.Username = 'Username';