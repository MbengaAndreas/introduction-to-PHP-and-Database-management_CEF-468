# Library System Web App (Lab 5)

This is a PHP & MySQL-based Library Management System built as part of Lab 6 coursework.

## 🔧 Requirements
- PHP >= 7.4
- MySQL
- Composer
- Web server (e.g. XAMPP)

## 📁 Folder Structure
- `auth/` - Authentication scripts (login, register, logout)
- `books/` - CRUD operations (add, edit, delete, view books)
- `config/` - Database connection
- `includes/` - Shared layout files (header, footer)
- `vendor/` - Composer dependencies (Google API Client, etc.)
- `assets/` - CSS, JS, images

## 📂 Files
- `db_setup.php` — Creates necessary tables
- `home.php`, `library.php`, `profile.php` — Main application pages
- `composer.json`, `composer.lock` — Dependency management
- `library_auth_system.sql` — SQL export of the database

## 🚀 Setup Instructions

1. Clone or download the project into `htdocs`:
   ```bash
   git clone https://github.com/yourusername/library_system_lab6.git
Import the SQL file:

Open phpMyAdmin.

Create a database named library_auth_system.

Import library_auth_system.sql.
Install dependencies:
cd library_system_lab5
composer install
Run the app:

Start Apache and MySQL from XAMPP.

Visit: http://localhost/library_system_lab6/home.php