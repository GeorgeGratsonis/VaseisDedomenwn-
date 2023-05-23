import random
import string

import mysql.connector

# Greek book titles
greek_titles = [
    "Το Μυστικό του Πειρατή", "Ο Χαμένος Κόσμος", "Η Κληρονομιά", "Ο Αναγνώστης", "Το Νησί των Θησαυρών",
    "Ο Άρχοντας των Δαχτυλιδιών", "Ο Κώδικας του Δα Βίντσι", "Η Αλίκη στη Χώρα των Θαυμάτων", "Ο Υποβρύχιος Κόσμος", "Ο Ανανάς Express",
    "Ο Μάγος της Οζ", "Η Ιστορία της Πεντάμορφης", "Το Πορτρέτο του Ντόριαν Γκρέι", "Ο Πόλεμος των Κόσμων", "Ο Πειρατής της Καραϊβικής",
    "Το Νησί του Δρ. Μορό", "Ο Φύλακας των Αστρων", "Η Σκιά του Ανέμου", "Ο Πόλεμος των Θεών", "Η Πριγκίπισσα του Βορρά"
]

# Greek publishers
greek_publishers = [
    "Εκδόσεις Παπαδόπουλος", "Εκδόσεις Δημητρίου", "Εκδόσεις Παππάς", "Εκδόσεις Κωνσταντίνου", "Εκδόσεις Γεωργίου",
    "Εκδόσεις Αντωνίου", "Εκδόσεις Στεφανίδης", "Εκδόσεις Νικολάου", "Εκδόσεις Αθανασίου", "Εκδόσεις Σωτηρίου"
]

# Greek summaries
greek_summaries = [
    "Αυτό είναι ένα μυστηριώδες βιβλίο γεμάτο περιπέτεια και ανατροπές.",
    "Ένας κόσμος που έχει χαθεί, αναμένει να ανακαλυφθεί από εξερευνητές.",
    "Μια κληρονομιά που αλλάζει τα πάντα και φέρνει αναταραχή.",
    "Ο Αναγνώστης έχει τη δύναμη να αλλάξει τον κόσμο.",
    "Ένα νησί γεμάτο θησαυρούς περιμένει τον τυχερό εξερευνητή.",
    "Ο απόλυτος αγώνας για την εξουσία και τον έλεγχο των δαχτυλιδιών.",
    "Ένας κώδικας που κρύβει πολλά μυστικά από τον Λεονάρντο ντα Βίντσι.",
    "Μια αξέχαστη περιπέτεια στην Χώρα των Θαυμάτων.",
    "Μια υποβρύχια εξερεύνηση στον βυθό του ωκεανού.",
    "Ένα εκρηκτικό εκδηλωτικό πλοίο με προορισμό τον Ανανά.",
    "Η μαγεία της Οζ επιστρέφει σε μια συναρπαστική περιπέτεια.",
    "Η ιστορία μιας πεντάμορφης πριγκίπισσας που καταραμένη να ζει ως πεταλούδα.",
    "Το πορτρέτο του Ντόριαν Γκρέι, ένας νεαρός που διατηρεί την αιωνιότητα.",
    "Ο πόλεμος των κόσμων, ένας επικίνδυνος αγώνας ανάμεσα σε εξωγήινους.",
    "Ο πειρατής της Καραϊβικής, οι περιπέτειες του καπετάνιου Τζακ Σπάροου.",
    "Το νησί του Δρ. Μορό, μια απομονωμένη τοποθεσία με μυστήρια και κίνδυνο.",
    "Ο φύλακας των αστρων, μια επική περιπέτεια στο διάστημα.",
    "Η σκιά του ανέμου, ένα μυστηριώδες θρίλερ με ένταση και ανατροπές.",
    "Ο πόλεμος των θεών, η αναμέτρηση μεταξύ θεών και ανθρώπων.",
    "Η πριγκίπισσα του Βορρά, μια επική φαντασία γεμάτη μαγεία και περιπέτεια."
]

# Greek first names
greek_first_names = [
    "Γιάννης", "Δημήτρης", "Γεώργιος", "Νικόλαος", "Αντώνης",
    "Σταύρος", "Αλέξανδρος", "Κωνσταντίνος", "Αθανάσιος", "Σωτήρης",
    "Πέτρος", "Μιχάλης", "Παναγιώτης", "Θεόδωρος", "Ιωάννης"
]

# Greek last names
greek_last_names = [
    "Παπαδόπουλος", "Δημητρίου", "Παππάς", "Κωνσταντίνου", "Γεωργίου",
    "Αντωνίου", "Στεφανίδης", "Νικολάου", "Αθανασίου", "Σωτηρίου",
    "Πετρίδης", "Μιχαλόπουλος", "Παναγιωτίδης", "Θεοδωρίδης", "Ιωαννίδης"
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
    password = "".join(random.choices(string.ascii_letters + string.digits, k=10))
    first_name = random.choice(greek_first_names)
    last_name = random.choice(greek_last_names)
    age = random.randint(6, 18)
    role = "Student"
    school_id = random.randint(1, 5)
    library_operator_id = random.randint(1, 2)
    user_data.append((username, password, first_name, last_name, age, role, school_id, library_operator_id))

# Insert dummy data into the User table
insert_user_query = "INSERT INTO User (Username, Password, First_Name, Last_Name, Age, Role, School_ID, LibraryOperator_ID) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
cursor.executemany(insert_user_query, user_data)

# Generate dummy data for Book table with Greek titles and details
book_data = []
for i in range(1, 101):
    title = random.choice(greek_titles) + " " + str(i)
    publisher = random.choice(greek_publishers)
    isbn = "".join(random.choices(string.digits, k=13))
    num_pages = random.randint(100, 500)
    summary = random.choice(greek_summaries)
    available_copies = random.randint(1, 5)
    image = f"book{i}.jpg"
    language = "Greek"
    keywords = f"Book{i}, Greek"
    book_data.append((title, publisher, isbn, num_pages, summary, available_copies, image, language, keywords))

# Insert dummy data into the Book table
insert_book_query = "INSERT INTO Book (Title, Publisher, ISBN, Number_of_pages, Summary, Available_copies, Image, Language, Keywords) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
cursor.executemany(insert_book_query, book_data)

# Commit the changes to the database
db.commit()

# Close the database connection
db.close()
