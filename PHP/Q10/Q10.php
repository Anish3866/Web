<?php
$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Inventory | Q10</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f1f5f9; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #f8fafc; }
    </style>
</head>
<body>
    <h2>Book Inventory</h2>
    <p><a href="Q10.php">Refresh Data</a></p>
    <table>
        <tr><th>ID</th><th>Book Title</th><th>Author</th><th>Publisher</th><th>Pages</th><th>Price</th><th>ISBN</th></tr>
        <?php while($row = $books->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><?php echo htmlspecialchars($row['publisher']); ?></td>
            <td><?php echo $row['no_of_page']; ?></td>
            <td>$<?php echo number_format($row['price'], 2); ?></td>
            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
