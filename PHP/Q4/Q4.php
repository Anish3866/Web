<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        input, select { padding: 8px; margin: 5px 0; width: 300px; }
        button { padding: 8px 20px; background: #333; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 14px; }
        .success { color: green; font-size: 14px; }
        label { font-weight: bold; }
    </style>
</head>
<body>

<h1>Registration Form</h1>

<?php
$name = $email = $password = $phone = $gender = $faculty = "";
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $phone = trim($_POST["phone"]);
    $gender = $_POST["gender"] ?? "";
    $faculty = $_POST["faculty"];

    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($password) || strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) $errors[] = "Phone must be 10 digits.";
    if (empty($gender)) $errors[] = "Gender is required.";
    if (empty($faculty)) $errors[] = "Faculty is required.";

    if (empty($errors)) {
        $conn = new mysqli("localhost", "root", "", "project");

        if ($conn->connect_error) {
            $errors[] = "Database connection failed: " . $conn->connect_error;
        } else {


            $stmt = $conn->prepare("INSERT INTO registrations (name, email, password, phone, gender, faculty) VALUES (?, ?, ?, ?, ?, ?)");
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssssss", $name, $email, $hashed, $phone, $gender, $faculty);

            if ($stmt->execute()) {
                $success = "Registration successful!";
                $name = $email = $password = $phone = $gender = $faculty = "";
            } else {
                $errors[] = "Error: " . $stmt->error;
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>

<?php if (!empty($errors)): ?>
    <div class="error">
        <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <p class="success"><b><?php echo $success; ?></b></p>
<?php endif; ?>

<form method="post">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $name; ?>"><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $email; ?>"><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?php echo $phone; ?>"><br>

    <label>Gender:</label><br>
    <input type="radio" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>> Male
    <input type="radio" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>> Female
    <input type="radio" name="gender" value="Other" <?php if ($gender == "Other") echo "checked"; ?>> Other<br><br>

    <label>Faculty:</label><br>
    <select name="faculty">
        <option value="">-- Select --</option>
        <option value="BCA" <?php if ($faculty == "BCA") echo "selected"; ?>>BCA</option>
        <option value="BIT" <?php if ($faculty == "BIT") echo "selected"; ?>>BIT</option>
        <option value="CSIT" <?php if ($faculty == "CSIT") echo "selected"; ?>>CSIT</option>
        <option value="BBA" <?php if ($faculty == "BBA") echo "selected"; ?>>BBA</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
