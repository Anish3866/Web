<?php
$file = "test.txt";
$msg = "";

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $content = $_POST['content'] ?? "";

    if ($action == 'write') {
        file_put_contents($file, $content);
        $msg = "File rewritten successfully.";
    } elseif ($action == 'append') {
        file_put_contents($file, "\n" . $content, FILE_APPEND);
        $msg = "Content appended successfully.";
    }
}

$fileData = file_exists($file) ? file_get_contents($file) : "File does not exist yet.";
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Ops | Q14</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .box { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; max-width: 500px; }
        textarea { width: 100%; height: 60px; margin-bottom: 10px; }
        pre { background: #eee; padding: 10px; border: 1px solid #ccc; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="box">
        <h2>File Operations (Read/Write/Append)</h2>
        <?php if ($msg): ?><p style="color:blue"><?php echo $msg; ?></p><?php endif; ?>
        
        <form method="POST">
            <textarea name="content" placeholder="Enter text here..."></textarea><br>
            <button type="submit" name="action" value="write">Write (Overwrite)</button>
            <button type="submit" name="action" value="append">Append</button>
        </form>

        <h3>Current File Content:</h3>
        <pre><?php echo htmlspecialchars($fileData); ?></pre>
    </div>
</body>
</html>
