<?php
include 'db.php';
$message = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'added')   $message = ['type' => 'success', 'text' => 'Student added successfully!'];
    if ($_GET['msg'] === 'updated') $message = ['type' => 'success', 'text' => 'Student updated successfully!'];
    if ($_GET['msg'] === 'deleted') $message = ['type' => 'success', 'text' => 'Student deleted successfully!'];
}
$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>🎓 Student Management System</h1></header>
<div class="container">
    <?php if ($message): ?>
        <div class="alert alert-<?= $message['type'] ?>"><?= $message['text'] ?></div>
    <?php endif; ?>
    <a href="create.php" class="btn btn-add">+ Add New Student</a>
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>Roll No</th><th>Department</th><th>Semester</th><th>Email</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['roll_no']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= $row['semester'] ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                        &nbsp;
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-delete"
                           onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align:center;padding:20px;color:#777;">No students found. Add one!</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
