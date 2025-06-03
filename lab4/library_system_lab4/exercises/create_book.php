<?php
require_once '../classes/Book.php';

// Create a new Book object
$book = new Book("The Great Gatsby", "F. Scott Fitzgerald", 12.99, 1925, "Classic");

// Display book information
echo "<h2>Book Information</h2>";
$book->displayProduct();

// Questions Answers
echo "<h2>Exercise 1 Questions</h2>";
echo "<ol>";
echo "<li>A class in PHP is a blueprint for creating objects. It defines properties and methods that the created objects will have. An object is an instance of a class.</li>";
echo "<li>The constructor in a class is a special method that is automatically called when an object is created. It's typically used to initialize the object's properties.</li>";
echo "<li>You instantiate an object from a class using the 'new' keyword followed by the class name and parentheses, optionally passing arguments to the constructor.</li>";
echo "</ol>";
?>