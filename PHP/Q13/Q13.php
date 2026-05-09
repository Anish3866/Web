<?php
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$msg = "";
$type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload'];
    $fileName = basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $msg = "Error: File upload failed with error code " . $file['error'];
        $type = "error";
    } elseif ($file['size'] > 5000000) { 
        $msg = "Error: File is too large (max 5MB).";
        $type = "error";
    } else {
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $msg = "Success! File '" . htmlspecialchars($fileName) . "' uploaded successfully.";
            $type = "success";
        } else {
            $msg = "Error: Failed to move uploaded file.";
            $type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Upload | Q13</title>
    <style>
        body { font-family: sans-serif; background: #f0f4f8; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; text-align: center; }
        .alert { padding: 10px; margin-bottom: 10px; font-size: 14px; }
        .success { color: green; } .error { color: red; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Upload File</h2>
        <?php if ($msg): ?><p class="<?php echo $type; ?>"><?php echo $msg; ?></p><?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" required><br><br>
            <button type="submit">Upload Now</button>
        </form>
    </div>
</body>
</html>

