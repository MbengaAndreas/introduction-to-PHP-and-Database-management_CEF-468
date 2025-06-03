<?php
require_once 'classes/Book.php';
require_once 'classes/Ebook.php';
require_once 'classes/Member.php';
require_once 'config/database.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_book'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $price = $_POST['price'];
        $year = $_POST['year'];
        $genre = $_POST['genre'];
        
        $book = new Book($title, $author, $price, $year, $genre);
        $book->save();
    } elseif (isset($_POST['add_ebook'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $price = $_POST['price'];
        $year = $_POST['year'];
        $genre = $_POST['genre'];
        $format = $_POST['format'];
        $size = $_POST['size'];
        
        $ebook = new Ebook($title, $author, $price, $year, $genre, $format, $size);
        $ebook->save();
    } elseif (isset($_POST['add_member'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        $member = new Member($name, $email);
        $member->save();
    } elseif (isset($_POST['borrow_book'])) {
        $book_id = $_POST['book_id'];
        $member_id = $_POST['member_id'];
        
        $member = new Member("", "", "");
        $member->borrowBook($book_id, $member_id);
    } elseif (isset($_POST['return_book'])) {
        $loan_id = $_POST['loan_id'];
        
        $member = new Member("", "", "");
        $member->returnBook($loan_id);
    }
}

// Get all data
$books = Book::getAll();
$ebooks = Ebook::getAll();
$all_books = array_merge($books, $ebooks);
$members = Member::getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin-bottom: 30px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 15px; }
        input, select { margin: 5px 0; padding: 5px; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .alert-success { background-color: #dff0d8; color: #3c763d; }
        .alert-danger { background-color: #f2dede; color: #a94442; }
    </style>
</head>
<body>
    <h1>Library System</h1>

    <!-- Members Section -->
    <div class="section">
        <h2>Members</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit" name="add_member">Add Member</button>
        </form>

        <h3>Current Members</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Member Since</th>
            </tr>
            <?php foreach ($members as $member): ?>
            <tr>
                <td><?= $member['member_id'] ?></td>
                <td><?= htmlspecialchars($member['name']) ?></td>
                <td><?= htmlspecialchars($member['email']) ?></td>
                <td><?= $member['membership_date'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Books Section -->
    <div class="section">
        <h2>Books</h2>
        <form method="post">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="number" name="year" placeholder="Publication Year" required>
            <input type="text" name="genre" placeholder="Genre">
            <button type="submit" name="add_book">Add Book</button>
        </form>

        <h3>Add Ebook</h3>
        <form method="post">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="number" name="year" placeholder="Publication Year" required>
            <input type="text" name="genre" placeholder="Genre">
            <input type="text" name="format" placeholder="File Format (e.g., PDF)" required>
            <input type="number" name="size" placeholder="File Size (MB)" required>
            <button type="submit" name="add_ebook">Add Ebook</button>
        </form>
    </div>

    <!-- Available Books -->
    <!-- Available Books -->
<div class="section">
    <h2>Available Books</h2>
    <?php
    // Get available books
    $db = new Database();
    $conn = $db->connect();
    $query = "SELECT b.* FROM Books b
             WHERE NOT EXISTS (
                 SELECT 1 FROM BookLoans bl 
                 WHERE bl.book_id = b.book_id 
                 AND bl.return_date IS NULL
             )";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $available_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Year</th>
            <th>Genre</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <?php foreach ($available_books as $book): ?>
        <tr>
            <td><?= htmlspecialchars($book['title']) ?></td>
            <td><?= htmlspecialchars($book['author']) ?></td>
            <td>$<?= number_format($book['price'], 2) ?></td>
            <td><?= $book['publication_year'] ?></td>
            <td><?= htmlspecialchars($book['genre']) ?></td>
            <td><?= $book['type'] === 'ebook' ? 'Ebook' : 'Physical' ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                    <select name="member_id" required style="width:150px">
                        <option value="">Select Member</option>
                        <?php foreach ($members as $member): ?>
                        <option value="<?= $member['member_id'] ?>">
                            #<?= $member['member_id'] ?> - <?= htmlspecialchars($member['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="borrow_book" class="btn-borrow">Borrow</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

    <!-- Borrowed Books -->
    <div class="section">
        <h2>Borrowed Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Borrower</th>
                <th>Loan Date</th>
                <th>Days Out</th>
                <th>Action</th>
            </tr>
            <?php
            $db = new Database();
            $conn = $db->connect();
            $query = "SELECT b.title, b.author, m.name as borrower_name, bl.loan_date, bl.loan_id 
                      FROM BookLoans bl 
                      JOIN Books b ON bl.book_id = b.book_id 
                      JOIN Members m ON bl.member_id = m.member_id
                      WHERE bl.return_date IS NULL";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($loans as $loan): ?>
            <tr>
                <td><?= htmlspecialchars($loan['title']) ?></td>
                <td><?= htmlspecialchars($loan['author']) ?></td>
                <td><?= htmlspecialchars($loan['borrower_name']) ?></td>
                <td><?= $loan['loan_date'] ?></td>
                <td><?= floor((time() - strtotime($loan['loan_date'])) / (60 * 60 * 24)) ?></td>
                <td>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="loan_id" value="<?= $loan['loan_id'] ?>">
                        <button type="submit" name="return_book">Return</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>