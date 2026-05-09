<?php
session_start();
$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;
$book = null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $book = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE books SET title=?, publisher=?, author=?, edition=?, no_of_page=?, price=?, publish_date=?, isbn=? WHERE id=?");
    $stmt->bind_param("ssssidssi", $_POST['title'], $_POST['publisher'], $_POST['author'], $_POST['edition'], $_POST['pages'], $_POST['price'], $_POST['p_date'], $_POST['isbn'], $id);
    
    if ($stmt->execute()) {
        $_SESSION['msg'] = "Book updated successfully!";
        header("Location: Q11.php");
        exit;
    }
    $stmt->close();
}

$msg = $_SESSION['msg'] ?? "";
unset($_SESSION['msg']);
$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Books | Q11</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f8fafc; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px; }
        input { width: 100%; padding: 5px; box-sizing: border-box; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px; }
    </style>
</head>
<body>
    <h2>Modify Books</h2>
    <?php if ($msg): ?><p style="color:green"><?php echo $msg; ?></p><?php endif; ?>
    <?php if ($book): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
            <div class="grid">
                <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>">
                <input type="text" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>">
                <input type="text" name="edition" value="<?php echo htmlspecialchars($book['edition']); ?>">
                <input type="number" name="pages" value="<?php echo $book['no_of_page']; ?>">
                <input type="number" step="0.01" name="price" value="<?php echo $book['price']; ?>">
                <input type="date" name="p_date" value="<?php echo $book['publish_date']; ?>">
                <input type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>">
            </div>
            <button type="submit" name="update">Update</button>
            <a href="Q11.php">Cancel</a>
        </form>
    <?php endif; ?>
    <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Action</th></tr>
        <?php while($row = $books->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><a href="?id=<?php echo $row['id']; ?>" style="color:blue">Edit</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
