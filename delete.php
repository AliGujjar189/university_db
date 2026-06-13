<?php
include 'db.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: index.php"); exit(); }
$id = intval($_GET['id']);
$check = mysqli_query($conn, "SELECT id FROM students WHERE id = $id");
if (mysqli_num_rows($check) === 0) { header("Location: index.php"); exit(); }
$sql = "DELETE FROM students WHERE id = $id";
if (mysqli_query($conn, $sql)) header("Location: index.php?msg=deleted");
else header("Location: index.php?msg=error");
exit();
?>
