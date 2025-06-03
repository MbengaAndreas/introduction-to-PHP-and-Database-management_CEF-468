<?php
require_once '../classes/Book.php';
require_once '../classes/Ebook.php';

// Create objects that implement Discountable
$book = new Book("1984", "George Orwell", 8.99, 1949, "Dystopian");
$ebook = new Ebook("The Hobbit", "J.R.R. Tolkien", 7.99, 1937, "Fantasy", "PDF", 5);

// Demonstrate polymorphism
echo "<h2>Discount Calculations</h2>";
echo "Discount for '{$book->getName()}': $" . $book->getDiscount() . "<br>";
echo "Discount for '{$ebook->getName()}': $" . $ebook->getDiscount() . "<br>";

// Questions Answers
echo "<h2>Exercise 3 Questions</h2>";
echo "<ol>";
echo "<li>Polymorphism in OOP allows objects of different classes to be treated as objects of a common superclass. It's important because it enables flexible and extensible code that can work with objects of various types through a common interface.</li>";
echo "<li>Method overloading involves having multiple methods with the same name but different parameters in the same class (not natively supported in PHP). Method overriding involves a child class providing a different implementation of a method already defined in its parent class.</li>";
echo "<li>PHP supports polymorphism through interfaces (which define method signatures that implementing classes must define) and through method overriding in class inheritance.</li>";
echo "</ol>";
?>