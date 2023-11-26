<?php
include "../DB-conn.php";

if (isset($_POST["submit"])) {
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $deadline = $_POST['deadline'];
    $status = $_POST['status'];
    $user_id = $_POST['user_id'];

    // Insert project data into the 'projects' table
    $sqlInsertProject = "INSERT INTO project (project_name, description, start_date, deadline, status, user_id)
                        VALUES ('$project_name', '$description', '$start_date', '$deadline', '$status', '$user_id')";
    $resultInsertProject = mysqli_query($conn, $sqlInsertProject);

    if ($resultInsertProject) {
        // Close the database connection
        mysqli_close($conn);

        // Redirect to success page or show success message
        header("Location: ../index.php?msg=Project added successfully");
        exit();
    } else {
        echo "Error inserting data into 'project' table: " . mysqli_error($conn);
    }
}

$sqlUsers = "SELECT id, username FROM user";
$resultUsers = mysqli_query($conn, $sqlUsers);

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
   <title>ADD new Project</title>
</head>

<body>
   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #30B7FF;">
       Project
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3>Add New Project</h3>
         <p class="text-muted">Complete the form below to add a new project</p>
      </div>

      <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Project Name</label>
            <input type="text" class="form-control" name="project_name" placeholder="Project Name" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Description:</label>
        <textarea class="form-control" name="description" placeholder="Project Description"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Start Date:</label>
        <input type="date" class="form-control" name="start_date" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Deadline:</label>
        <input type="date" class="form-control" name="deadline" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status:</label><br>
        <select id="status" class="form-control" name="status" required>
            <option value="">Select Status</option>
            <option value="In Progress">In Progress</option>
            <option value="Done">Completed</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="user_id" class="form-label">Select Owner/User:</label><br>
        <select id="user_id" class="form-control" name="user_id" required>
            <option value="">Select an Owner/User</option>
            <?php
            // Populate users in the dropdown
            if ($resultUsers->num_rows > 0) {
                while ($row = $resultUsers->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <div class="button-container">
        <button type="submit" class="btn btn-success" name="submit" style="background-color: #30B7FF; border: 2px solid black">Save</button>
        <a href="../index.php" class="btn btn-danger" style="background-color: #30B7FF; border: 2px solid black">Cancel</a>
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