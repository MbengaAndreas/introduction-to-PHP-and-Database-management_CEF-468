# Employee Management App - PHP & MySQL (Lab 3 - Part 1)

This PHP web application allows you to manage employees and departments using a MySQL database normalized to **Third Normal Form (3NF)**.

## 📁 Project Structure


## 🧰 Requirements

- XAMPP or similar (Apache + MySQL + PHP)
- phpMyAdmin for managing MySQL

## 🚀 Setup Instructions

1. **Place the folder in your `htdocs/` directory:**


2. **Start Apache and MySQL** in XAMPP

3. **Import the database:**
- Go to `http://localhost/phpmyadmin`
- Click **New**, and name the database `EmployeeDB`
- Open the `EmployeeDB` database
- Go to the **Import** tab
- Select the file `EmployeeDB.sql` from your project folder
- Click **Go**

4. **Run the App:**
- Add Employee: `http://localhost/employee_app/add_employee.php`
- View Employees: `http://localhost/employee_app/display_employees.php`

## 🧠 Lab Questions & Answers

### Q1: How does 3NF differ from 2NF, and why is it important?

- **2NF** removes partial dependencies (non-key attributes depend on the full primary key).
- **3NF** removes transitive dependencies (non-key attributes should depend only on the primary key, not on other non-key attributes).
- Applying **3NF** ensures a well-structured schema with no redundant data and supports data integrity.

### Q2: What problems arise if a database isn't normalized beyond 1NF?

- **Data redundancy**: Repeating data in multiple rows.
- **Update anomalies**: Changes in one row require changes in many rows.
- **Insertion/deletion anomalies**: Hard to add or remove data without affecting others.

### Q3: What are the advantages of splitting tables in relational database design?

- **Reduced redundancy**
- **Improved data integrity**
- **Easier maintenance**
- **Clear relationships** via foreign keys between entities (e.g., Employees ↔ Departments)

## 👤 Author

[Your Full Name]  
Lab 3 – PHP and Database Management  
Department of [Your Department Name]
