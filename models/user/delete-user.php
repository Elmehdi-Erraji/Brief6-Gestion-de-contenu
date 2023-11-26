<?php
include "../DB-conn.php";
$id = $_GET["id"];

// First, delete the corresponding records from the role_user table
$sqlRoleUser = "DELETE FROM role_user WHERE user_id = $id";
$resultRoleUser = mysqli_query($conn, $sqlRoleUser);

// Then, delete the user from the user table
$sqlUser = "DELETE FROM user WHERE id = $id";
$resultUser = mysqli_query($conn, $sqlUser);

if ($resultRoleUser && $resultUser) {
    header("Location: ../index.php?msg=Data deleted successfully");
} else {
    echo "Failed: " . mysqli_error($conn);
}
?>