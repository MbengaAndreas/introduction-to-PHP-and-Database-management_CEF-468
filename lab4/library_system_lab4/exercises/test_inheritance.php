<?php
require_once '../classes/Product.php';
require_once '../classes/Book.php';

// Create a Product object
$product = new Product("Generic Product", 9.99);
echo "<h2>Product Information</h2>";
$product->displayProduct();

// Create a Book object
$book = new Book("To Kill a Mockingbird", "Harper Lee", 10.99, 1960, "Fiction");
echo "<h2>Book Information</h2>";
$book->displayProduct();

// Questions Answers
echo "<h2>Exercise 2 Questions</h2>";
echo "<ol>";
echo "<li>Inheritance in OOP allows a class to inherit properties and methods from another class. It promotes code reuse by allowing common functionality to be defined in a parent class and specialized functionality in child classes.</li>";
echo "<li>You override methods in a child class by defining a method with the same name as the parent class method. The child class's version will be called instead of the parent's.</li>";
echo "<li>Yes, a child class can call a parent class's method using the parent:: keyword followed by the method name, e.g., parent::displayProduct().</li>";
echo "</ol>";
?>