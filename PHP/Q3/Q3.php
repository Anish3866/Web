<?php
$subjects = ['Web', 'DSA', 'Java', 'SAD', 'Statistics'];
$marks    = [];
$errors   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($subjects as $i => $subject) {
        $val = trim($_POST['mark_' . $i] ?? '');
        if ($val === '' || !is_numeric($val) || $val < 0 || $val > 100) {
            $errors[$i] = true;
        } else {
            $marks[$i] = (int)$val;
        }
    }
}

$showResult = $_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors);
$total      = $showResult ? array_sum($marks) : 0;
$percentage = $showResult ? $total / count($subjects) : 0;

function getGrade($p) {
    if ($p >= 90) return 'A+';
    if ($p >= 80) return 'A';
    if ($p >= 70) return 'B+';
    if ($p >= 60) return 'B';
    if ($p >= 50) return 'C';
    if ($p >= 40) return 'D';
    return 'F';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Marksheet</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; }
    h1, h2 { text-align: center; }
    form { max-width: 350px; margin: 20px auto; }
    label { display: block; margin-top: 10px; font-weight: bold; }
    input[type="number"] { width: 100%; padding: 6px; margin-top: 4px; }
    .err { color: red; font-size: 0.85em; }
    input.err-input { border: 1px solid red; }
    button { margin-top: 16px; width: 100%; padding: 8px; background: #333; color: #fff; border: none; cursor: pointer; }
    table { border-collapse: collapse; width: 60%; margin: 20px auto; }
    th, td { border: 1px solid #999; padding: 8px 14px; text-align: center; }
    th { background: #333; color: #fff; }
    tr:nth-child(even) { background: #f2f2f2; }
    .result { text-align: center; margin-top: 10px; font-size: 1.1em; }
    .pass { color: green; font-weight: bold; }
    .fail { color: red; font-weight: bold; }
  </style>
</head>
<body>

<h1>Student Marksheet</h1>

<form method="POST">
  <?php foreach ($subjects as $i => $subject): ?>
    <label for="m<?= $i ?>"><?= $subject ?> (0–100)</label>
    <input type="number" id="m<?= $i ?>" name="mark_<?= $i ?>" min="0" max="100"
      value="<?= htmlspecialchars($_POST['mark_'.$i] ?? '') ?>"
      <?= isset($errors[$i]) ? 'class="err-input"' : '' ?>>
    <?php if (isset($errors[$i])): ?>
      <span class="err">Enter a valid mark (0–100).</span>
    <?php endif; ?>
  <?php endforeach; ?>
  <button type="submit">Generate Marksheet</button>
</form>

<?php if ($showResult): ?>
<h2>Marksheet</h2>
<table>
  <tr>
    <th>#</th>
    <th>Subject</th>
    <th>Marks Obtained</th>
    <th>Max Marks</th>
  </tr>
  <?php foreach ($subjects as $i => $subject): ?>
  <tr>
    <td><?= $i + 1 ?></td>
    <td><?= $subject ?></td>
    <td><?= $marks[$i] ?></td>
    <td>100</td>
  </tr>
  <?php endforeach; ?>
  <tr>
    <td colspan="2"><strong>Total</strong></td>
    <td><strong><?= $total ?></strong></td>
    <td><strong><?= count($subjects) * 100 ?></strong></td>
  </tr>
</table>
<div class="result">
  Percentage: <strong><?= number_format($percentage, 1) ?>%</strong> &nbsp;|&nbsp;
  Grade: <strong><?= getGrade($percentage) ?></strong> &nbsp;|&nbsp;
  Result: <span class="<?= $percentage >= 40 ? 'pass' : 'fail' ?>">
    <?= $percentage >= 40 ? 'PASS' : 'FAIL' ?>
  </span>
</div>
<?php endif; ?>

</body>
</html>
