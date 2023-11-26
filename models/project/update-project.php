<?php
include "../DB-conn.php";

// Initialize $id to prevent "Undefined variable" warning
$id = null;

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the form is submitted
    if (isset($_POST["submit"])) {
        $project_name = $_POST['project_name'];
        $description = $_POST['description'];
        $start_date = $_POST['start_date'];
        $deadline = $_POST['deadline'];
        $status = $_POST['status'];
        $user_id = $_POST['user_id'];

        // Update project information in the database
        $updateSQL = "UPDATE project 
                      SET project_name='$project_name', description='$description', start_date='$start_date', deadline='$deadline', status='$status', user_id='$user_id'
                      WHERE id = $id";
        $updateResult = mysqli_query($conn, $updateSQL);

        if ($updateResult) {
            header("Location: ../project.php?msg=Project updated successfully");
            exit();
        } else {
            echo "Error updating project: " . mysqli_error($conn);
        }
    }
} else {
    echo "Project ID is not provided!";
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

        .card {
            width: 100%;
            border: none;
            background-color: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card img {
            width: 200px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card label {
            margin-top: 30px;
            text-align: center;
            height: 40px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .card input {
            display: none;
        }
    </Style>
    <title>Dash RESTIAM - ADD new Product</title>
</head>

<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #30B7FF;">
        Products
    </nav>

    <div class="container">
        <div class="text-center mb-4">
            <h3>Edit Project Information</h3>
            <p class="text-muted">Click  update after changing any information</p>
        </div>

        <?php
        $sqlUsers = "SELECT id, username FROM user";
        $resultUsers = mysqli_query($conn, $sqlUsers);
        
        // Assuming $id is already fetched securely
        $sql = "SELECT p.*, u.username AS owner_username
                FROM project p
                LEFT JOIN user u ON p.user_id = u.id
                WHERE p.id = $id
                LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        ?>



        <div class="container d-flex justify-content-center">
        <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Project Name</label>
                <input type="text" class="form-control" name="project_name" value="<?php echo $row['project_name']; ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description:</label>
            <textarea class="form-control" name="description"><?php echo $row['description']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date:</label>
            <input type="date" class="form-control" name="start_date" value="<?php echo $row['start_date']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline:</label>
            <input type="date" class="form-control" name="deadline" value="<?php echo $row['deadline']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label><br>
            <select id="status" class="form-control" name="status" required>
                <option value="">Select Status</option>
                <option value="In Progress" <?php if ($row['status'] === 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Done" <?php if ($row['status'] === 'Done') echo 'selected'; ?>>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Select the Project manager</label><br>
            <select id="user_id" class="form-control" name="user_id" required>
                <option value="">Select the manager</option>
                <?php
                // Populate users in the dropdown
                if ($resultUsers->num_rows > 0) {
                    while ($userRow = $resultUsers->fetch_assoc()) {
                        $selected = ($userRow['id'] == $row['user_id']) ? 'selected' : '';
                        echo '<option value="' . $userRow['id'] . '" ' . $selected . '>' . $userRow['username'] . '</option>';
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
     <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>