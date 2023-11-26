<?php
include "../../config/DB-conn.php";

$id = $_GET["id"];
$sql = "DELETE FROM `project` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: ../../views/project.php?msg=Project deleted successfully");
} else {
    echo "Failed: " . mysqli_error($conn);
}
