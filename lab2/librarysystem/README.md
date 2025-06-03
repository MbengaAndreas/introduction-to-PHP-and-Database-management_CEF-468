
## 🧰 Requirements

- XAMPP or another local server with PHP and MySQL
- phpMyAdmin for database import

## 🚀 How to Run the Project

1. **Move the folder** into your `htdocs/` directory:

2. **Start Apache and MySQL** in XAMPP

3. **Import the Database**:
- Go to `http://localhost/phpmyadmin`
- Click **New**, create a database named `LibrarySystemDB`
- Click the `LibrarySystemDB` database
- Go to the **Import** tab
- Upload `LibrarySystemDB.sql` from your project folder
- Click **Go**

4. **Run the App**:
- Add authors: `http://localhost/librarysystem/add_author.php`
- Add books: `http://localhost/librarysystem/add_book.php`
- View books: `http://localhost/librarysystem/display_books.php`

## 📘 Notes

- Authors must be added before adding books.
- Books are linked to authors via foreign key (`author_id`), satisfying 2NF.
- All input is validated (e.g., price must be a valid number).

## 🧠 Answers to Lab Questions

**Q1. What is the difference between 1NF and 2NF?**  
- 1NF ensures each column has atomic values and no repeating groups.  
- 2NF builds on 1NF and removes partial dependencies (i.e., non-key attributes must depend on the whole primary key).

**Q2. Why are foreign keys necessary?**  
- Foreign keys enforce relationships between tables and ensure data integrity (e.g., each book is linked to a valid author).

**Q3. How do you validate form data before inserting it into the database?**  
- Use PHP to check:
- If required fields are filled
- If `email` or `number` formats are valid
- If values are within expected ranges or types (e.g., `price` is a float)

---

## 👤 Author
[Your Full Name]  
Lab 2 – PHP and Database Management  
Department of [Your Department Name]
