import random
import string

import mysql.connector

# Connect to the MySQL database
db = mysql.connector.connect(
    host="your_host",
    user="your_username",
    password="your_password",
    database="your_database"
)

# Create a cursor to execute SQL queries
cursor = db.cursor()

# Generate dummy data for Administrator table
admin_data = [
    ("Admin_FirstName", "Admin_LastName", "admin_username", "admin_password")
]

# Generate dummy data for School table
school_data = [
    ("School_Name", "School_Address", "School_City", "school_email", "Director_Fullname", 1)
]

# Generate dummy data for LibraryOperator table
operator_data = [
    ("Operator_FirstName", "Operator_LastName", "operator_username", "operator_password", 1, 1)
]

# Generate dummy data for User table
user_data = []
for i in range(1, 21):
    username = f"user{i}"
    password = f"user{i}_password"
    first_name = f"User{i}_FirstName"
    last_name = f"User{i}_LastName"
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
    num_pages = random.randint(100, 1000)
    summary = f"Summary for Book {i}"
    available_copies = random.randint(1, 5)
    image = f"book{i}.jpg"
    language = "Greek"
    keywords = f"Book{i}, Greek"
    book_data.append((title, publisher, isbn, num_pages, summary, available_copies, image, language, keywords))

# Insert dummy data into the tables
insert_admin_query = "INSERT INTO Administrator (First_Name, Last_Name, Username, Password) VALUES (%s, %s, %s, %s)"
insert_school_query = "INSERT INTO School (Name, Adress, City, Email, Director_Fullname, Admin_ID) VALUES (%s, %s, %s, %s, %s, %s)"
insert_operator_query = "INSERT INTO LibraryOperator (First_Name, Last_Name, Username, Password, Admin_ID, School_ID) VALUES (%s, %s, %s, %s, %s, %s)"
insert_user_query = "INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, School_ID, LibraryOperator_ID) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
insert_book_query = "INSERT INTO Book (Title, Publisher, ISBN, Number_of_pages, Summary, Available_copies, Image, Language, Keywords) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"

cursor.executemany(insert_admin_query, admin_data)
cursor.executemany(insert_school_query, school_data)
cursor.executemany(insert_operator_query, operator_data)
cursor.executemany(insert_user_query, user_data)
cursor.executemany(insert_book_query, book_data)

# Commit the changes to the database
db.commit()

# Close the database connection
db.close()
