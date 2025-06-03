<?php
require_once 'Product.php';
require_once 'Loanable.php';
require_once 'Discountable.php';

class Book extends Product implements Loanable, Discountable {
    protected $author;
    protected $publication_year;
    protected $genre;
    private $is_borrowed = false;

    public function __construct($title, $author, $price, $publication_year, $genre) {
        parent::__construct($title, $price);
        $this->author = $author;
        $this->publication_year = $publication_year;
        $this->genre = $genre;
    }

    public function displayProduct() {
        parent::displayProduct();
        echo "Author: {$this->author}<br>";
        echo "Publication Year: {$this->publication_year}<br>";
        echo "Genre: {$this->genre}<br>";
        echo "Status: " . ($this->is_borrowed ? "Borrowed" : "Available") . "<br>";
    }

    // Loanable interface methods
    public function borrowBook() {
        $this->is_borrowed = true;
        return "Book '{$this->product_name}' has been borrowed.";
    }

    public function returnBook() {
        $this->is_borrowed = false;
        return "Book '{$this->product_name}' has been returned.";
    }

    public function isBorrowed() {
        return $this->is_borrowed;
    }

    // Discountable interface method
    public function getDiscount() {
        // 10% discount for books older than 5 years
        $current_year = date('Y');
        if (($current_year - $this->publication_year) > 5) {
            return $this->product_price * 0.10;
        }
        return 0;
    }

    // Database methods
    public function save() {
        $db = new Database();
        $conn = $db->connect();

        $query = "INSERT INTO Books 
                  (title, author, price, genre, publication_year, type) 
                  VALUES 
                  (:title, :author, :price, :genre, :year, 'physical')";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $this->product_name);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':price', $this->product_price);
        $stmt->bindParam(':genre', $this->genre);
        $stmt->bindParam(':year', $this->publication_year);

        return $stmt->execute();
    }

    public static function getAll() {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT * FROM Books WHERE type = 'physical'";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>