<?php
require_once 'config/database.php';

class Member {
    private $name;
    private $email;
    private $membership_date;
    private $member_id;

    public function __construct($name, $email, $membership_date = null) {
        $this->name = $name;
        $this->email = $email;
        $this->membership_date = $membership_date ?: date('Y-m-d');
    }

    public function displayInfo() {
        echo "Member: {$this->name}<br>";
        echo "Email: {$this->email}<br>";
        echo "Membership Date: {$this->membership_date}<br>";
    }

    public function borrowBook($book_id, $member_id) {
    $db = new Database();
    $conn = $db->connect();

    // 1. Check if book exists
    $book_check = "SELECT book_id FROM Books WHERE book_id = :book_id";
    $stmt = $conn->prepare($book_check);
    $stmt->bindParam(':book_id', $book_id);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        throw new Exception("Book doesn't exist!");
    }

    // 2. Check if already borrowed
    $loan_check = "SELECT loan_id FROM BookLoans 
                  WHERE book_id = :book_id AND return_date IS NULL";
    $stmt = $conn->prepare($loan_check);
    $stmt->bindParam(':book_id', $book_id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        throw new Exception("Book already borrowed!");
    }

    // 3. Process loan
    $query = "INSERT INTO BookLoans 
             (book_id, member_id, loan_date) 
             VALUES 
             (:book_id, :member_id, CURDATE())";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':book_id', $book_id);
    $stmt->bindParam(':member_id', $member_id);
    
    return $stmt->execute();
}

    public function returnBook($loan_id) {
        $db = new Database();
        $conn = $db->connect();

        $query = "UPDATE BookLoans SET return_date = CURDATE() WHERE loan_id = :loan_id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':loan_id', $loan_id);
        
        return $stmt->execute();
    }

    public function getBorrowedBooks() {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT b.title, b.author, bl.loan_date 
                  FROM BookLoans bl 
                  JOIN Books b ON bl.book_id = b.book_id 
                  WHERE bl.member_id = :member_id AND bl.return_date IS NULL";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':member_id', $this->member_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save() {
        $db = new Database();
        $conn = $db->connect();

        $query = "INSERT INTO Members (name, email, membership_date) 
                  VALUES (:name, :email, :membership_date)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':membership_date', $this->membership_date);
        $stmt->execute();
        
        $this->member_id = $conn->lastInsertId();
        return $this->member_id;
    }

    public static function getByEmail($email) {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT * FROM Members WHERE email = :email";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll() {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT * FROM Members ORDER BY name";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>