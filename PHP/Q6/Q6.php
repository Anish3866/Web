<?php
session_start();
$action = $_GET['action'] ?? '';

if ($action == 'set') {
    $_SESSION['user'] = "User_" . rand(1, 100);
    $_SESSION['status'] = "Active";
    $msg = "Session Set!";
} elseif ($action == 'destroy') {
    session_destroy();
    header("Location: Q6.php?msg=Session Destroyed!");
    exit;
}
$msg = $_GET['msg'] ?? ($msg ?? "");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Q6</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .nav a { background: #333; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        pre { background: #fff; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h2>Session Manager</h2>
    <div class="nav">
        <a href="?action=set">Store Data</a>
        <a href="?action=destroy">Destroy Session</a>
        <a href="Q6.php">Refresh</a>
    </div>
    <p><b>Status:</b> <?php echo $msg ?: "Ready"; ?></p>
    <h3>$_SESSION Contents:</h3>
    <pre><?php print_r($_SESSION); ?></pre>
</body>
</html>



