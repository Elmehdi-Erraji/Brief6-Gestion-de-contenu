<?php
  include "../config/DB-conn.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

<!-- =============== Navigation ================ -->
    <div class="containerr" style="background-color: #30B7FF;">
        <div class="navigation" style="background-color: #30B7FF;">
            <ul>
                <li>
                    <a href="index.php">
                        <span class="title">Innovation</span>
                    </a>
                </li>

                <li>
                    <a href="../index.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="project.php">
                        <span class="icon">
                        <ion-icon name="receipt-outline"></ion-icon>
                        </span>
                        <span class="title">Projects</span>
                    </a>
                </li>

            </ul>
        </div>

<!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>

<br>
<br>
<br>
<!-- ================ User Details List ================= -->

<div class="container">
    <?php
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        ' . $msg . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    <a href="../models/project/add-project.php" class="btn btn-dark mb-3">Add A New Project</a>

    <table class="table table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Project Name</th>
                <th scope="col">Description</th>
                <th scope="col">Start Date</th>
                <th scope="col">Deadline</th>
                <th scope="col">Status</th>
                <th scope="col">Project manager</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <?php
        $sql = "SELECT p.id, p.project_name, p.description, p.start_date, p.deadline, p.status, u.username
        FROM project p
        LEFT JOIN user u ON p.user_id = u.id";

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die('Error: ' . mysqli_error($conn)); // Display the SQL error
        }
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["project_name"] ?></td>
                <td><?php echo $row["description"] ?></td>
                <td><?php echo $row["start_date"] ?></td>
                <td><?php echo $row["deadline"] ?></td>
                <td><?php echo $row["status"] ?></td>
                <td><?php echo $row["username"] ?></td>
                <td>
                    <a href="../models/project/update-project.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                    <a href="../models/project/delete-project.php?id=<?php echo $row["id"] ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>



  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

            <!-- ================= New Customers ================ -->

        </div>
    </div>  
    </div>

    <!-- =========== Scripts =========  -->
    <script src="../assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</body>

</html>