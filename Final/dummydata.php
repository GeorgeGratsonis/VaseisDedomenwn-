<?php

require_once 'vendor/autoload.php'; 

include 'connection.php';

$faker = Faker\Factory::create('el_GR');

$usernames = [];
while (count($usernames) < 150) {
    $username = $faker->unique()->userName;
    $usernames[] = $username;
}

// Generate administrator

$firstName = $faker->firstName;
$lastName = $faker->lastName;
$username = $usernames[0];
$password = $faker->password;
$age = 50;

$stmt = $conn->prepare("INSERT INTO Administrator (First_Name, Last_Name, Username, Password, Age) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $firstName, $lastName, $username, $password, $age);
$stmt->execute();
$stmt->close();

// Generate schools

$schoolNames = [
    "16ο Γενικό Λύκειο Αθηνών",
    "5ο Γυμνάσιο Θεσσαλονίκης",
    "13ο Γενικό Λύκειο Πειραιά",
    "4ο Δημοτικό Σχολείο Ηρακλείου",
    "9ο Γυμνάσιο Πάτρας",
    "2ο Επαγγελματικό Λύκειο Λάρισας"
];

$cities = [
    "Αθήνα",
    "Θεσσαλονίκη",
    "Πειραιάς",
    "Ηράκλειο",
    "Πάτρα",
    "Λάρισα"
];

$emailDomains = [
    "gmail.com",
    "yahoo.com",
    "hotmail.com",
    "outlook.com",
    "icloud.com"
];

for ($i = 0; $i <= 5; $i++) {
    $name = $schoolNames[$i];
    $address = $faker->streetAddress;
    $city = $cities[$i];
    $emailDomain = $faker->randomElement($emailDomains);
    $email = strtolower(str_replace(' ', '', $name)) . '@' . $emailDomain;
    $phoneNumber = $faker->numerify('2#########');
    $directorFullName = $faker->firstName . ' ' . $faker->lastName;
    $adminId = 1;

    $stmt = $conn->prepare("INSERT INTO School (Name, Address, City, Email, Phone_Number, Director_Fullname, Admin_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $name, $address, $city, $email, $phoneNumber, $directorFullName, $adminId);
    $stmt->execute();
    $stmt->close();
}

// Generate approved library operators

for ($i = 1; $i <= 6; $i++) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $username = $usernames[$i];
    $password = $faker->password;
    $age = $faker->numberBetween(25, 70);
    $approved = 1;
    $adminId = 1;
    $schoolId = $faker->unique()->numberBetween(1, 6);

    $stmt = $conn->prepare("INSERT INTO LibraryOperator (First_Name, Last_Name, Username, Password, Age, Approved, Admin_ID, School_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiii", $firstName, $lastName, $username, $password, $age, $approved, $adminId, $schoolId);
    $stmt->execute();
    $stmt->close();
}

// Generate not approved library operators

for ($i = 1; $i <= 4; $i++) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $username = $usernames[$i+6];
    $password = $faker->password;
    $age = $faker->numberBetween(25, 70);
    $adminId = 1;
    $schoolId = $faker->numberBetween(1, 6);

    $stmt = $conn->prepare("INSERT INTO LibraryOperator (First_Name, Last_Name, Username, Password, Age, Admin_ID, School_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiii", $firstName, $lastName, $username, $password, $age, $adminId, $schoolId);
    $stmt->execute();
    $stmt->close();
}

// Generate approved students

for ($i = 1; $i <= 60; $i++) {
    $username = $usernames[$i+10];
    $password = $faker->password;
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $age = $faker->numberBetween(12, 18);
    $role = 'Student';
    $approved = 1;
    $schoolId = $faker->numberBetween(1, 6);
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM LibraryOperator WHERE School_ID = $schoolId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];

    $stmt = $conn->prepare("INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, Approved, School_ID, LibraryOperator_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisiii", $username, $password, $firstName, $lastName, $age, $role, $approved, $schoolId, $libraryOperatorId);
    $stmt->execute();
    $stmt->close();
}

// Generate approved teachers

for ($i = 1; $i <= 30; $i++) {
    $username = $usernames[$i+70];
    $password = $faker->password;
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $age = $faker->numberBetween(25, 70);
    $role = 'Teacher';
    $approved = 1;
    $schoolId = $faker->numberBetween(1, 6);
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM LibraryOperator WHERE School_ID = $schoolId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];

    $stmt = $conn->prepare("INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, Approved, School_ID, LibraryOperator_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisiii", $username, $password, $firstName, $lastName, $age, $role, $approved, $schoolId, $libraryOperatorId);
    $stmt->execute();
    $stmt->close();
}

// Generate not approved students

for ($i = 1; $i <= 30; $i++) {
    $username = $usernames[$i+100];
    $password = $faker->password;
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $age = $faker->numberBetween(12, 18);
    $role = 'Student';
    $approved = 0;
    $schoolId = $faker->numberBetween(1, 6);
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM LibraryOperator WHERE School_ID = $schoolId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];

    $stmt = $conn->prepare("INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, Approved, School_ID, LibraryOperator_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisiii", $username, $password, $firstName, $lastName, $age, $role, $approved, $schoolId, $libraryOperatorId);
    $stmt->execute();
    $stmt->close();
}

// Generate not approved teachers

for ($i = 1; $i <= 15; $i++) {
    $username = $usernames[$i+130];
    $password = $faker->password;
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $age = $faker->numberBetween(25, 70);
    $role = 'Teacher';
    $approved = 0;
    $schoolId = $faker->numberBetween(1, 6);
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM LibraryOperator WHERE School_ID = $schoolId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];

    $stmt = $conn->prepare("INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, Approved, School_ID, LibraryOperator_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisiii", $username, $password, $firstName, $lastName, $age, $role, $approved, $schoolId, $libraryOperatorId);
    $stmt->execute();
    $stmt->close();
}

// Generate authors

$languages = ['el_GR', 'en_US', 'fr_FR', 'de_DE', 'es_ES', 'it_IT'];

for ($i = 1; $i <= 100; $i++) {
    $language = $faker->randomElement($languages);
    $faker = Faker\Factory::create($language);

    $firstName = $faker->firstName;
    $lastName = $faker->lastName;

    $stmt = $conn->prepare("INSERT INTO Author (First_Name, Last_Name) VALUES (?, ?)");
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $stmt->close();
}

$faker = Faker\Factory::create('el_GR');

// Generate categories

$categories = ['Fiction', 'Non-Fiction', 'Mystery', 'Sci-Fi', 'Romance', 'Thriller', 'Biography', 'History', 'Fantasy', 'Self-Help'];

foreach ($categories as $category) {
    $stmt = $conn->prepare("INSERT INTO Category (Name) VALUES (?)");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $stmt->close();
}

// Generate books

$publisherNames = [
    // Greek Publishers
    "Εκδόσεις Καστανιώτη",
    "Εκδόσεις Πατάκη",
    "Εκδόσεις Ψυχογιός",
    "Εκδόσεις Παπαδόπουλος",
    "Εκδόσεις Ελληνικά Γράμματα",
    "Εκδόσεις Πολιτεία",
    "Εκδόσεις Μεταίχμιο",
    "Εκδόσεις Κλειδάριθμος",
    "Εκδόσεις Κριτική",
    "Εκδόσεις Ιανός",
    
    // German Publishers
    "Random House Germany",
    "Hanser Verlag",
    "Rowohlt Verlag",
    "Suhrkamp Verlag",
    "Carl Hanser Verlag",
    "Piper Verlag",
    "Dumont Verlag",
    "Fischer Verlag",
    "Kiepenheuer & Witsch",
    "Heyne Verlag",
    
    // Spanish Publishers
    "Editorial Planeta",
    "Grupo Santillana",
    "Random House Mondadori",
    "Ediciones Salamandra",
    "Anagrama",
    "Alfaguara",
    "Ediciones B",
    "Roca Editorial",
    "Siruela",
    "Galaxia Gutenberg",
    
    // Italian Publishers
    "Mondadori",
    "Rizzoli Editore",
    "Giunti Editore",
    "Einaudi",
    "Feltrinelli",
    "Bompiani",
    "Adelphi Edizioni",
    "Sellerio Editore",
    "Garzanti",
    "Marsilio Editori",
    
    // English Publishers
    "Penguin Books",
    "Oxford University Press",
    "Cambridge University Press",
    "HarperCollins",
    "Simon & Schuster",
    "Random House",
    "Macmillan Publishers",
    "Penguin Random House",
    "Hachette Book Group",
    "Scholastic",
    
    // French Publishers
    "Gallimard",
    "Hachette Livre",
    "Éditions du Seuil",
    "Albin Michel",
    "Flammarion",
    "Groupe Éditorial L'Express",
    "Grasset",
    "Éditions Stock",
    "Le Dilettante",
    "Actes Sud",
    ];


$languages = ['Greek', 'English', 'French', 'German', 'Spanish', 'Italian'];

for ($i = 1; $i <= 200; $i++) {
    $title = $faker->realText($faker->numberBetween(10, 50));
    $publisher = $faker->randomElement($publisherNames);
    $isbn = $faker->unique()->isbn13;
    $numPages = $faker->numberBetween(70, 800);
    $summary = $faker->realText($faker->numberBetween(100, 300));
    $availableCopies = $faker->numberBetween(1, 20);
    $image = $faker->imageUrl(400, 600);
    $language = $faker->randomElement($languages);
    $keywords = $faker->words($faker->numberBetween(1, 5));
    $keywords = implode(', ', $keywords);


    $stmt = $conn->prepare("INSERT INTO Book (Title, Publisher, ISBN, Number_of_pages, Summary, Available_copies, Image, Language, Keywords) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisisss", $title, $publisher, $isbn, $numPages, $summary, $availableCopies, $image, $language, $keywords);
    $stmt->execute();
    $bookId = $stmt->insert_id;
    $stmt->close();

    // Add authors to books

    $numAuthors = $faker->numberBetween(1, 3);
    $authorIds = $faker->randomElements(range(1, 100), $numAuthors);

    foreach ($authorIds as $authorId) {
        $stmt = $conn->prepare("INSERT INTO Book_Author (Author_ID, Book_ID) VALUES (?, ?)");
        $stmt->bind_param("ii", $authorId, $bookId);
        $stmt->execute();
        $stmt->close();
    }

    // Add categories to books

    $numCategories = $faker->numberBetween(1, 3);
    $categoryIds = $faker->randomElements(range(1, 10), $numCategories);

    foreach ($categoryIds as $categoryId) {
    $stmt = $conn->prepare("INSERT INTO Book_Category (Category_ID, Book_ID) VALUES (?, ?)");
    $stmt->bind_param("ii", $categoryId, $bookId);
    $stmt->execute();
    $stmt->close();
}

    // Add library operators to books

    $numlibraryOperators = $faker->numberBetween(1, 3);
    $libraryoperatorIds = $faker->randomElements(range(1, 6), $numlibraryOperators);

    foreach ($libraryoperatorIds as $libraryoperatorId) {
        $stmt = $conn->prepare("INSERT INTO Book_LibraryOperator (LibraryOperator_ID, Book_ID) VALUES (?, ?)");
        $stmt->bind_param("ii", $libraryoperatorId, $bookId);
        $stmt->execute();
        $stmt->close();
    }
}

// Generate borrowings

$borrowings = 0;

while (TRUE) {
    try {
    $borrowingDate = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d');
    $returnDate = date('Y-m-d', strtotime($borrowingDate . '+7 days'));
    $returned = $faker->boolean(80) ? 1 : 0;
    $userId = $faker->numberBetween(1, 90);
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM user WHERE user_id = $userId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];
    $stmt = $conn->prepare("SELECT Book_ID FROM book_libraryoperator WHERE LibraryOperator_id = $libraryOperatorId ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $bookId = $row['Book_ID'];

    $stmt = $conn->prepare("INSERT INTO Borrowing (Borrowing_Date, Return_Date, Returned, User_ID, LibraryOperator_ID, Book_ID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiii", $borrowingDate, $returnDate, $returned, $userId, $libraryOperatorId, $bookId);
    $stmt->execute();
    $stmt->close();

    $borrowings += 1;

    if ($borrowings == 100) {
        break;
    }
    } catch (Exception $e) {
        echo "An exception occurred: " . $e->getMessage(). "<br>";
        continue;
    }
}

// Generate reservations

$statuses = ['Completed', 'Completed', 'Pending'];

$reservations = 0;

while (TRUE) {
    try {
    $status = $faker->randomElement($statuses);
    if ($status === 'Completed') {
        $reservationDate = $faker->dateTimeBetween('-1 year', '-8 days')->format('Y-m-d');
    }
    else {
        $reservationDate = $faker->dateTimeBetween('-7 days', 'now')->format('Y-m-d');
    }
    $userId = $faker->numberBetween(1, 90);
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM user WHERE user_id = $userId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];
    $stmt = $conn->prepare("SELECT Book_ID FROM book_libraryoperator WHERE LibraryOperator_id = $libraryOperatorId ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $bookId = $row['Book_ID'];

    $stmt = $conn->prepare("INSERT INTO Reservation (Reservation_Date, Status, User_ID, LibraryOperator_ID, Book_ID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $reservationDate, $status, $userId, $libraryOperatorId, $bookId);
    $stmt->execute();
    $stmt->close();

    $reservations += 1;

    if ($reservations == 80) {
        break;
    }
    } catch (Exception $e) {
        echo "An exception occurred: " . $e->getMessage(). "<br>";
        continue; 
    }
}

// Generate students reviews
for ($i = 1; $i <= 100; $i++) {
    $text = $faker->realText($faker->numberBetween(10, 100));
    $rating = $faker->numberBetween(1, 5);
    $approved = $faker->boolean(80) ? 1 : 0;
    $stmt = $conn->prepare("SELECT Book_ID, User_ID FROM Borrowing WHERE user_id <= 60 ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $userId = $row['User_ID'];
    $bookId = $row['Book_ID'];
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM user WHERE user_id = $userId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];

    $stmt = $conn->prepare("INSERT INTO Review (Text, Rating, Approved, User_ID, LibraryOperator_ID, Book_ID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiii", $text, $rating, $approved, $userId, $libraryOperatorId, $bookId);
    $stmt->execute();
    $stmt->close();
}

// Generate teachers reviews
for ($i = 1; $i <= 50; $i++) {
    $text = $faker->realText($faker->numberBetween(10, 100));
    $rating = $faker->numberBetween(1, 5);
    $approved = 1;
    $stmt = $conn->prepare("SELECT Book_ID, User_ID FROM Borrowing WHERE 60 < user_id <= 90 ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $userId = $row['User_ID'];
    $bookId = $row['Book_ID'];
    $stmt = $conn->prepare("SELECT LibraryOperator_ID FROM user WHERE user_id = $userId");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $libraryOperatorId = $row['LibraryOperator_ID'];

    $stmt = $conn->prepare("INSERT INTO Review (Text, Rating, Approved, User_ID, LibraryOperator_ID, Book_ID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiii", $text, $rating, $approved, $userId, $libraryOperatorId, $bookId);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

echo "<br>";
echo "Data generation and insertion completed!";

?>