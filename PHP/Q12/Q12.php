<?php
session_start();
$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['msg'] = "Book #$id has been removed successfully.";
    } else {
        $_SESSION['msg'] = "Error removing record: " . $conn->error;
    }
    $stmt->close();
    header("Location: Q12.php");
    exit;
}

$msg = $_SESSION['msg'] ?? "";
unset($_SESSION['msg']);
$books = $conn->query("SELECT * FROM books ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Books | Q12</title>
    <style>
        body { font-family: sans-serif; background: #fef2f2; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #fee2e2; color: #b91c1c; }
        .btn-del { color: #ef4444; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Remove Books</h2>
    <?php if ($msg): ?><p style="color:red"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
    <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Action</th></tr>
        <?php while($row = $books->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><a href="?del_id=<?php echo $row['id']; ?>" class="btn-del" onclick="return confirm('Delete this book?');">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
