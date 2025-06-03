# PHP OOP Library System (Lab 4)

This is a PHP Object-Oriented Programming project simulating a Library System. It includes concepts such as Classes, Inheritance, Interfaces, and Polymorphism, along with MySQL integration.

## 📁 Folder Structure

- `classes/` — PHP classes like `Book.php`, `Member.php`, `Ebook.php`
- `config/` — Database connection file (e.g., `db.php`)
- `exercises/` — Lab exercise files (e.g., `test_inheritance.php`)
- `includes/` — Common includes (e.g., `header.php`)
- `library_test.php` — Main test file to run the app
- `library_system_lab4.sql` — SQL file to recreate the database
- `README.md` — Instructions

## 🗃️ Database

**Name:** `library_system_lab4`

### Tables:

1. `Books` — book_id, title, author, price, genre, year
2. `Members` — member_id, name, email, membership_date
3. `BookLoans` — id, book_id, member_id, loan_date, return_date

## 🛠️ Setup Instructions

1. Import the SQL file into phpMyAdmin:
   - Go to `phpMyAdmin`
   - Click on `Import`
   - Select `library_system_lab4.sql`
   - Click `Go`

2. Place this folder into your `htdocs/` directory (e.g., `htdocs/library_system_lab4`).

3. Access in browser:
http://localhost/library_system_lab4/library_test.php
## 🧪 Features Demonstrated

- Class definitions with constructors
- Inheritance (`Book` extends `Product`)
- Interfaces (`Loanable`, `Discountable`)
- Polymorphism via method overriding
- Book borrowing and returning via MySQL
