<!DOCTYPE html>
<html>
<head>
    <title>Simple & Compound Interest Calculator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        input { padding: 8px; margin: 5px 0; width: 250px; }
        button { padding: 8px 16px; margin: 5px 5px 5px 0; cursor: pointer; background: #333; color: white; border: none; }
        .result { margin-top: 15px; padding: 15px; background: #e8f5e9; border-radius: 5px; }
    </style>
</head>
<body>

<h1>Simple &amp; Compound Interest Calculator</h1>

<form method="post">
    <label>Principal (P):</label><br>
    <input type="number" name="principal" step="any" required><br>

    <label>Rate (R) %:</label><br>
    <input type="number" name="rate" step="any" required><br>

    <label>Time (T) in years:</label><br>
    <input type="number" name="time" step="any" required><br><br>

    <button type="submit" name="simple">Calculate Simple Interest</button>
    <button type="submit" name="compound">Calculate Compound Interest</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p = $_POST["principal"];
    $r = $_POST["rate"];
    $t = $_POST["time"];

    if (isset($_POST["simple"])) {
        $si = ($p * $r * $t) / 100;
        $total = $p + $si;
        echo "<div class='result'>";
        echo "<h3>Simple Interest</h3>";
        echo "Principal: Rs. $p <br>";
        echo "Rate: $r% <br>";
        echo "Time: $t years <br>";
        echo "<b>Simple Interest = Rs. $si</b><br>";
        echo "<b>Total Amount = Rs. $total</b>";
        echo "</div>";
    }

    if (isset($_POST["compound"])) {
        $ci = $p * pow((1 + $r / 100), $t) - $p;
        $total = $p + $ci;
        $ci = round($ci, 2);
        $total = round($total, 2);
        echo "<div class='result'>";
        echo "<h3>Compound Interest</h3>";
        echo "Principal: Rs. $p <br>";
        echo "Rate: $r% <br>";
        echo "Time: $t years <br>";
        echo "<b>Compound Interest = Rs. $ci</b><br>";
        echo "<b>Total Amount = Rs. $total</b>";
        echo "</div>";
    }
}
?>

</body>
</html>
