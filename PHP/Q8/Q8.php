<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: Q8.php?msg=Logged Out Successfully");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['user'] = $username;
        $_SESSION['login_time'] = date("H:i:s");
        header("Location: Q8.php");
        exit;
    } else {
        $error = "Invalid Username or Password!";
    }
}

$msg = $_GET['msg'] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Authentication | Q8</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 300px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: #c81e1e; font-size: 13px; }
        .msg { color: #1e429f; font-size: 13px; }
    </style>
</head>
<body>
<div class="card">
    <?php if (isset($_SESSION['user'])): ?>
        <h2>Dashboard</h2>
        <p>User: <?php echo htmlspecialchars($_SESSION['user']); ?></p>
        <p>Login: <?php echo $_SESSION['login_time']; ?></p>
        <a href="?logout=1" style="color:red">Logout</a>
    <?php else: ?>
        <h2>Login</h2>
        <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <?php if ($msg): ?><p class="msg"><?php echo htmlspecialchars($msg); ?></p><?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="admin" required>
            <input type="password" name="password" placeholder="password123" required>
            <button type="submit">Sign In</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

