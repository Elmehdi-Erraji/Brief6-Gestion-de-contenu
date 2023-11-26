<?php
include "../../config/DB-conn.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET["id"])) {
    $id = htmlspecialchars($_GET["id"]);

    // Prepare SQL statement to delete corresponding records from role_user table using prepared statements
    $sqlRoleUser = "DELETE FROM role_user WHERE user_id = ?";
    $stmtRoleUser = mysqli_prepare($conn, $sqlRoleUser);

    // Check for errors in preparing the statement
    if (!$stmtRoleUser) {
        die('Error preparing statement: ' . mysqli_error($conn));
    }

    // Bind parameter and execute prepared statement
    mysqli_stmt_bind_param($stmtRoleUser, "i", $id);
    $resultRoleUser = mysqli_stmt_execute($stmtRoleUser);

    // Close prepared statement
    mysqli_stmt_close($stmtRoleUser);

    // Prepare SQL statement to delete user from user table using prepared statements
    $sqlUser = "DELETE FROM user WHERE id = ?";
    $stmtUser = mysqli_prepare($conn, $sqlUser);

    // Check for errors in preparing the statement
    if (!$stmtUser) {
        die('Error preparing statement: ' . mysqli_error($conn));
    }

    // Bind parameter and execute prepared statement
    mysqli_stmt_bind_param($stmtUser, "i", $id);
    $resultUser = mysqli_stmt_execute($stmtUser);

    // Close prepared statement
    mysqli_stmt_close($stmtUser);

    if ($resultRoleUser && $resultUser) {
        // Redirect to success page or show success message
        header("Location: ../../index.php?msg=Data deleted successfully");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    echo "User ID is not provided!";
}
?>
