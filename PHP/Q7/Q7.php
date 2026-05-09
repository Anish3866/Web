<?php
$action = $_GET['action'] ?? '';
$msg = "";

if ($action == 'set') {
    setcookie("user_name", "Antigravity", time() + 3600, "/");
    setcookie("last_visit", date("Y-m-d H:i:s"), time() + 3600, "/");
    header("Location: Q7.php?msg=Cookies Set!");
    exit;
} elseif ($action == 'destroy') {
    setcookie("user_name", "", time() - 3600, "/");
    setcookie("last_visit", "", time() - 3600, "/");
    header("Location: Q7.php?msg=Cookies Destroyed!");
    exit;
}
$msg = $_GET['msg'] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cookie Q7</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #fdfdfd; }
        .nav a { background: #ed8936; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        pre { background: #fff; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h2>Cookie Manager</h2>
    <div class="nav">
        <a href="?action=set">Set Cookies</a>
        <a href="?action=destroy">Destroy Cookies</a>
        <a href="Q7.php">Refresh</a>
    </div>
    <p><b>Status:</b> <?php echo htmlspecialchars($msg) ?: "Ready"; ?></p>
    <h3>$_COOKIE Contents:</h3>
    <pre><?php print_r($_COOKIE); ?></pre>
</body>
</html>

