<?php
require_once 'Book.php';

class Ebook extends Book {
    private $file_format;
    private $file_size; // in MB

    public function __construct($title, $author, $price, $publication_year, $genre, $file_format, $file_size) {
        // Initialize parent class (Book) properties
        parent::__construct($title, $author, $price, $publication_year, $genre);
        
        // Initialize Ebook-specific properties
        $this->file_format = $file_format;
        $this->file_size = $file_size;
    }

    public function displayProduct() {
        parent::displayProduct();
        echo "Format: {$this->file_format}<br>";
        echo "File Size: {$this->file_size} MB<br>";
    }

    public function download() {
        return "Downloading ebook '{$this->product_name}' in {$this->file_format} format...";
    }

    public function getDiscount() {
        // Ebooks get 15% discount by default
        return $this->product_price * 0.15;
    }

    public function save() {
        $db = new Database();
        $conn = $db->connect();

        $query = "INSERT INTO Books 
                  (title, author, price, genre, publication_year, type, file_format, file_size) 
                  VALUES 
                  (:title, :author, :price, :genre, :year, 'ebook', :format, :size)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $this->product_name);
        $stmt->bindParam(':author', $this->author);       // Now properly initialized
        $stmt->bindParam(':price', $this->product_price);
        $stmt->bindParam(':genre', $this->genre);         // Now properly initialized
        $stmt->bindParam(':year', $this->publication_year); // Now properly initialized
        $stmt->bindParam(':format', $this->file_format);
        $stmt->bindParam(':size', $this->file_size);

        return $stmt->execute();
    }

    public static function getAll() {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT * FROM Books WHERE type = 'ebook'";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>