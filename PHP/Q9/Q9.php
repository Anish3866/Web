<?php
session_start();
$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publisher VARCHAR(100),
    author VARCHAR(100),
    edition VARCHAR(50),
    no_of_page INT,
    price DECIMAL(10,2),
    publish_date DATE,
    isbn VARCHAR(20)
)";
$conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO books (title, publisher, author, edition, no_of_page, price, publish_date, isbn) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssidss", $_POST['title'], $_POST['publisher'], $_POST['author'], $_POST['edition'], $_POST['pages'], $_POST['price'], $_POST['p_date'], $_POST['isbn']);
    
    if ($stmt->execute()) {
        $_SESSION['msg'] = "Book added successfully!";
    } else {
        $_SESSION['msg'] = "Error: " . $conn->error;
    }
    $stmt->close();
    header("Location: Q9.php");
    exit;
}

$msg = $_SESSION['msg'] ?? "";
unset($_SESSION['msg']);
$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Store | Q9</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f8fafc; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px; margin-bottom: 15px; }
        input { width: 100%; padding: 5px; box-sizing: border-box; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 14px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Book System</h2>
    <?php if ($msg): ?><p style="color:green"><?php echo $msg; ?></p><?php endif; ?>
    <form method="POST">
        <div class="grid">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="author" placeholder="Author">
            <input type="text" name="publisher" placeholder="Publisher">
            <input type="text" name="edition" placeholder="Edition">
            <input type="number" name="pages" placeholder="Pages">
            <input type="number" step="0.01" name="price" placeholder="Price">
            <input type="date" name="p_date">
            <input type="text" name="isbn" placeholder="ISBN">
        </div>
        <button type="submit">Save Book</button>
    </form>
    <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Publisher</th><th>Edition</th><th>Pages</th><th>Price</th><th>Date</th><th>ISBN</th></tr>
        <?php while($row = $books->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><?php echo htmlspecialchars($row['publisher']); ?></td>
            <td><?php echo htmlspecialchars($row['edition']); ?></td>
            <td><?php echo $row['no_of_page']; ?></td>
            <td>$<?php echo $row['price']; ?></td>
            <td><?php echo $row['publish_date']; ?></td>
            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>

