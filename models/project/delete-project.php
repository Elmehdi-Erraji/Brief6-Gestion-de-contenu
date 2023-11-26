<?php
include "../DB-conn.php";

$id = $_GET["id"];
$sql = "DELETE FROM `project` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: ../project.php?msg=Project deleted successfully");
} else {
    echo "Failed: " . mysqli_error($conn);
}