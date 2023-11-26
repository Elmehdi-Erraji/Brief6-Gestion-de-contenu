<?php
include "../../config/DB-conn.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET["id"])) {
    $id = htmlspecialchars($_GET["id"]);

    // Prepare SQL statement to delete project using prepared statements
    $sql = "DELETE FROM `project` WHERE id = ?";
    $stmtDeleteProject = mysqli_prepare($conn, $sql);

    // Check for errors in preparing the statement
    if (!$stmtDeleteProject) {
        die('Error preparing statement: ' . mysqli_error($conn));
    }

    // Bind parameter and execute prepared statement
    mysqli_stmt_bind_param($stmtDeleteProject, "i", $id);
    $result = mysqli_stmt_execute($stmtDeleteProject);

    if ($result) {
        // Close prepared statement
        mysqli_stmt_close($stmtDeleteProject);
        
        // Redirect to success page or show success message
        header("Location: ../../views/project.php?msg=Project deleted successfully");
        exit();
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
} else {
    echo "Project ID is not provided!";
}
?>

