<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
    } else {
        $conn = new mysqli("localhost", "root", "", "project");
        if ($conn->connect_error) {
            $_SESSION['error'] = "Connection failed: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("SELECT name, password FROM registrations WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($user = $result->fetch_assoc()) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['success'] = "Login successful! Welcome, " . htmlspecialchars($user['name']);
                } else {
                    $_SESSION['error'] = "Invalid email or password.";
                }
            } else {
                $_SESSION['error'] = "Invalid email or password.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
$error = $_SESSION['error'] ?? "";
$success = $_SESSION['success'] ?? "";
unset($_SESSION['error'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Project</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        body { background: #0f172a; height: 100vh; display: flex; align-items: center; justify-content: center; color: #f8fafc; }
        .login-container { background: #1e293b; padding: 2rem; border-radius: 16px; width: 100%; max-width: 380px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        h1 { font-size: 1.5rem; text-align: center; margin-bottom: 0.5rem; color: #818cf8; }
        p.subtitle { text-align: center; color: #94a3b8; margin-bottom: 1.5rem; font-size: 0.9rem; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 0.4rem; font-size: 0.85rem; color: #94a3b8; }
        input { width: 100%; padding: 0.7rem; background: #0f2342; border: 1px solid #334155; border-radius: 8px; color: white; font-size: 0.95rem; }
        .btn-login { width: 100%; padding: 0.7rem; background: #6366f1; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 0.5rem; }
        .btn-login:hover { background: #4f46e5; }
        .alert { padding: 0.8rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.85rem; text-align: center; }
        .alert-error { background: #450a0a; color: #f87171; }
        .alert-success { background: #064e3b; color: #34d399; }
        .footer-text { text-align: center; margin-top: 1.5rem; font-size: 0.8rem; color: #94a3b8; }
        .footer-text a { color: #6366f1; text-decoration: none; }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Login</h1>
    <p class="subtitle">Enter your credentials</p>
    <?php if ($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
        <button type="submit" class="btn-login">Sign In</button>
    </form>
    <div class="footer-text">No account? <a href="../Q4/Q4.php">Register</a></div>
</div>
</body>
</html>

