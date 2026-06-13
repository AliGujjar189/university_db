<?php
include 'db.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $roll_no    = trim(mysqli_real_escape_string($conn, $_POST['roll_no']));
    $department = trim(mysqli_real_escape_string($conn, $_POST['department']));
    $semester   = intval($_POST['semester']);
    $email      = trim(mysqli_real_escape_string($conn, $_POST['email']));
    if (empty($name))       $errors[] = "Name is required.";
    if (empty($roll_no))    $errors[] = "Roll Number is required.";
    if (empty($department)) $errors[] = "Department is required.";
    if ($semester < 1 || $semester > 8) $errors[] = "Semester must be between 1 and 8.";
    if (empty($email) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "A valid email is required.";
    if (empty($errors)) {
        $sql = "INSERT INTO students (name, roll_no, department, semester, email) VALUES ('$name', '$roll_no', '$department', $semester, '$email')";
        if (mysqli_query($conn, $sql)) { header("Location: index.php?msg=added"); exit(); }
        else $errors[] = "Database error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>🎓 Student Management System</h1></header>
<div class="container">
    <div class="form-card">
        <h2>Add New Student</h2>
        <?php foreach ($errors as $err): ?><div class="alert alert-error"><?= htmlspecialchars($err) ?></div><?php endforeach; ?>
        <form method="POST" action="create.php">
            <div class="form-group"><label>Full Name</label><input type="text" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" placeholder="e.g. Ali Hassan" required></div>
            <div class="form-group"><label>Roll Number</label><input type="text" name="roll_no" value="<?= isset($_POST['roll_no']) ? htmlspecialchars($_POST['roll_no']) : '' ?>" placeholder="e.g. BSCS-004" required></div>
            <div class="form-group"><label>Department</label><input type="text" name="department" value="<?= isset($_POST['department']) ? htmlspecialchars($_POST['department']) : '' ?>" placeholder="e.g. Computer Science" required></div>
            <div class="form-group"><label>Semester</label>
                <select name="semester" required>
                    <?php for ($s = 1; $s <= 8; $s++): ?>
                        <option value="<?= $s ?>" <?= (isset($_POST['semester']) && $_POST['semester'] == $s) ? 'selected' : '' ?>>Semester <?= $s ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" placeholder="e.g. student@example.com" required></div>
            <button type="submit">Add Student</button>
            &nbsp;&nbsp;<a href="index.php" class="btn btn-back">Back to List</a>
        </form>
    </div>
</div>
</body>
</html>
