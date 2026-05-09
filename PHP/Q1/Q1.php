<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Content Generation in PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #333; color: white; }
        .cards { display: flex; gap: 15px; flex-wrap: wrap; margin-top: 10px; }
        .card { background: #4a90d9; color: white; padding: 15px; border-radius: 8px; width: 200px; }
    </style>
</head>
<body>

<h1>Dynamic Content Generation using Arrays &amp; Loops</h1>

<h2>1. List</h2>
<?php
$fruits = array("Apple", "Banana", "Mango", "Orange", "Grapes");
echo "<ul>";
foreach ($fruits as $fruit) {
    echo "<li>$fruit</li>";
}
echo "</ul>";
?>

<h2>2. Table</h2>
<?php
$students = array(
    array("Anish", "BCA", 85),
    array("Sita", "BIT", 92),
    array("Ramesh", "CSIT", 78),
    array("Gita", "BCA", 88),
);

echo "<table>";
echo "<tr><th>Name</th><th>Course</th><th>Marks</th></tr>";
foreach ($students as $s) {
    echo "<tr><td>$s[0]</td><td>$s[1]</td><td>$s[2]</td></tr>";
}
echo "</table>";
?>

<h2>3. Cards</h2>
<?php
$products = array(
    array("Laptop", "Rs. 95,000"),
    array("Phone", "Rs. 45,000"),
    array("Headphones", "Rs. 8,500"),
    array("Smartwatch", "Rs. 12,000"),
);

echo '<div class="cards">';
foreach ($products as $p) {
    echo '<div class="card">';
    echo "<h3>$p[0]</h3>";
    echo "<p>$p[1]</p>";
    echo '</div>';
}
echo '</div>';
?>

</body>
</html>
