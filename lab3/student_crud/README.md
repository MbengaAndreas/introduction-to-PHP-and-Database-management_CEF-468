# Student CRUD Application

This is a simple PHP CRUD application for managing student records using MySQL.

## 📁 Folder: `student_crud`

### 🗃️ Database Name:
`studentdb`

### 📄 Table Structure:
Table: `Students`
- `student_id` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `name` (VARCHAR)
- `email` (VARCHAR)
- `phone_number` (VARCHAR)

### 📦 Files:
- `add_student.php` – Form to add a new student
- `insert_student.php` – Processes new student insertion
- `view_students.php` – Displays all students
- `edit_student.php` – Edit existing student data
- `update_student.php` – Save edited student data
- `delete_student.php` – Delete a student record
- `studentdb.sql` – SQL file to create and populate the database
- `db.php` – Database connection file (if used)

## 🚀 How to Run:
1. Import the `studentdb.sql` file into phpMyAdmin to create the database.
2. Place the `student_crud` folder into your `htdocs` directory.
3. Access the app in your browser:
