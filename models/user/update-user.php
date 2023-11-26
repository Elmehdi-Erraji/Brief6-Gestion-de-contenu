<?php
include "../../config/DB-conn.php";

// Check if the form is submitted
if (isset($_POST["submit"])) {
    if (isset($_GET["id"])) {
        $user_id = htmlspecialchars($_GET["id"]); // Sanitize the user ID from the URL or form data

        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role_id = $_POST['role'];

        // Check if passwords match
        if ($password !== $confirm_password) {
            echo "Passwords do not match.";
            exit(); // Stop execution if passwords don't match
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to update user data using prepared statements
        $sqlUpdateUser = "UPDATE user SET username = ?, email = ?, Password = ? WHERE id = ?";
        $stmtUpdateUser = mysqli_prepare($conn, $sqlUpdateUser);

        // Check for errors in preparing the statement
        if (!$stmtUpdateUser) {
            die('Error preparing statement: ' . mysqli_error($conn));
        }

        // Bind parameters and execute prepared statement
        mysqli_stmt_bind_param($stmtUpdateUser, "sssi", $username, $email, $hashed_password, $user_id);
        $resultUpdateUser = mysqli_stmt_execute($stmtUpdateUser);

        if ($resultUpdateUser) {
            // Close prepared statement
            mysqli_stmt_close($stmtUpdateUser);
            
            // Prepare SQL statement to update user role in the 'role_user' table using prepared statements
            $sqlUpdateRoleUser = "UPDATE role_user SET role_id = ? WHERE user_id = ?";
            $stmtUpdateRoleUser = mysqli_prepare($conn, $sqlUpdateRoleUser);

            // Check for errors in preparing the statement
            if (!$stmtUpdateRoleUser) {
                die('Error preparing statement: ' . mysqli_error($conn));
            }

            // Bind parameters and execute prepared statement
            mysqli_stmt_bind_param($stmtUpdateRoleUser, "ii", $role_id, $user_id);
            $resultUpdateRoleUser = mysqli_stmt_execute($stmtUpdateRoleUser);

            if ($resultUpdateRoleUser) {
                // Close prepared statement
                mysqli_stmt_close($stmtUpdateRoleUser);
                
                // Redirect to success page or show success message
                header("Location: ../../index.php?msg=User updated successfully");
                exit();
            } else {
                echo "Error updating user role: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating user data: " . mysqli_error($conn);
        }
    } else {
        echo "User ID is not provided!";
    }
}

// Fetch user details and populate the form for updating
if (isset($_GET["id"])) {
    $user_id = htmlspecialchars($_GET["id"]); // Sanitize the user ID from the URL or form data

    $sqlFetchUser = "SELECT * FROM user WHERE id = ?";
    $stmtFetchUser = mysqli_prepare($conn, $sqlFetchUser);

    // Check for errors in preparing the statement
    if (!$stmtFetchUser) {
        die('Error preparing statement: ' . mysqli_error($conn));
    }

    // Bind parameter and execute prepared statement
    mysqli_stmt_bind_param($stmtFetchUser, "i", $user_id);
    mysqli_stmt_execute($stmtFetchUser);
    $resultFetchUser = mysqli_stmt_get_result($stmtFetchUser);
    $row = mysqli_fetch_assoc($resultFetchUser);

    // Close prepared statement
    mysqli_stmt_close($stmtFetchUser);

    $sqlRoles = "SELECT * FROM role";
    $resultRoles = $conn->query($sqlRoles);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <Style>
    .button-container {
            text-align: center;
        }
  </Style>

  <title>Dash RESTIAM</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color:  #30B7FF;">
  Client
  </nav>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit Client Information</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>

   

    <div class="container d-flex justify-content-center">
    <form action="" method="post" style="width:50vw; min-width:300px;">
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="Enter New Password">
    </div>

    <div class="mb-3">
        <label class="form-label">Password confirmation:</label>
        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password">
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Select Role:</label><br>
        <select id="role" class="form-control" name="role" required>
            <option value="">Select a Role</option>
            <?php
            // Populate roles in the dropdown
            if ($resultRoles->num_rows > 0) {
                while ($role = $resultRoles->fetch_assoc()) {
                    $selected = ($role['id'] == $row['role_id']) ? 'selected' : '';
                    echo '<option value="' . $role['id'] . '" ' . $selected . '>' . $role['role_name'] . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <div class="button-container">
        <button type="submit" class="btn btn-success" name="submit" style="background-color: #30B7FF; border: 2px solid black">Update</button>
        <a href="../../index.php" class="btn btn-danger" style="background-color: #30B7FF;  border: 2px solid black">Cancel</a>
    </div>
    <br>
    <br>
</form>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>