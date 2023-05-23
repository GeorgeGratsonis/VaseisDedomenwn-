import random
import string

import mysql.connector

# Greek first names
greek_first_names = [
    "Γιάννης", "Γεώργιος", "Δημήτρης", "Κώστας", "Νικόλαος",
    "Αντώνης", "Παναγιώτης", "Βασίλης", "Χρήστος", "Αλέξανδρος"
]

# Greek last names
greek_last_names = [
    "Παπαδόπουλος", "Δημητρίου", "Παππάς", "Κωνσταντίνου", "Γεωργίου",
    "Πέτρου", "Αντωνίου", "Αθανασίου", "Στεφανίδης", "Νικολάου"
]

# Connect to the MySQL database
db = mysql.connector.connect(
    host="your_host",
    user="your_username",
    password="your_password",
    database="your_database"
)

# Create a cursor to execute SQL queries
cursor = db.cursor()

# Generate dummy data for User table with Greek names
user_data = []
for i in range(1, 21):
    username = f"user{i}"
    password = f"user{i}_password"
    first_name = random.choice(greek_first_names)
    last_name = random.choice(greek_last_names)
    age = random.randint(6, 18) if i <= 10 else random.randint(26, 60)
    role = "Student" if i <= 10 else "Professor"
    school_id = 1
    operator_id = 1
    user_data.append((username, password, first_name, last_name, age, role, school_id, operator_id))

# Generate dummy data for Book table
book_data = []
for i in range(1, 101):
    title = f"Book{i}_Title"
    publisher = f"Book{i}_Publisher"
    isbn = "".join(random.choices(string.digits, k=13))
    num_pages = random.randint(100, 500)
    summary = f"Summary for Book {i}"
    available_copies = random.randint(1, 5)
    image = f"book{i}.jpg"
    language = "Greek"
    keywords = f"Book{i}, Greek"
    book_data.append((title, publisher, isbn, num_pages, summary, available_copies, image, language, keywords))

# Insert dummy data into the User and Book tables
insert_user_query = "INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, School_ID, LibraryOperator_ID) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
insert_book_query = "INSERT INTO Book (Title, Publisher, ISBN, Number_of_pages, Summary, Available_copies, Image, Language, Keywords) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"

cursor
