<?php
include 'db.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: index.php"); exit(); }
$id = intval($_GET['id']);
$errors = [];
$result = mysqli_query($conn, "SELECT * FROM students WHERE id = $id");
if (mysqli_num_rows($result) === 0) { header("Location: index.php"); exit(); }
$student = mysqli_fetch_assoc($result);
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
        $sql = "UPDATE students SET name='$name', roll_no='$roll_no', department='$department', semester=$semester, email='$email' WHERE id=$id";
        if (mysqli_query($conn, $sql)) { header("Location: index.php?msg=updated"); exit(); }
        else $errors[] = "Database error: " . mysqli_error($conn);
    } else {
        $student['name'] = $_POST['name']; $student['roll_no'] = $_POST['roll_no'];
        $student['department'] = $_POST['department']; $student['semester'] = $_POST['semester'];
        $student['email'] = $_POST['email'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>🎓 Student Management System</h1></header>
<div class="container">
    <div class="form-card">
        <h2>Edit Student</h2>
        <?php foreach ($errors as $err): ?><div class="alert alert-error"><?= htmlspecialchars($err) ?></div><?php endforeach; ?>
        <form method="POST" action="edit.php?id=<?= $id ?>">
            <div class="form-group"><label>Full Name</label><input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required></div>
            <div class="form-group"><label>Roll Number</label><input type="text" name="roll_no" value="<?= htmlspecialchars($student['roll_no']) ?>" required></div>
            <div class="form-group"><label>Department</label><input type="text" name="department" value="<?= htmlspecialchars($student['department']) ?>" required></div>
            <div class="form-group"><label>Semester</label>
                <select name="semester" required>
                    <?php for ($s = 1; $s <= 8; $s++): ?>
                        <option value="<?= $s ?>" <?= ($student['semester'] == $s) ? 'selected' : '' ?>>Semester <?= $s ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group"><label>Email Address</label><input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required></div>
            <button type="submit">Update Student</button>
            &nbsp;&nbsp;<a href="index.php" class="btn btn-back">Back to List</a>
        </form>
    </div>
</div>
</body>
</html>
