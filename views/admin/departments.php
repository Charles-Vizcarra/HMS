<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}
include('../../includes/sidebar.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Department Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Department Management</h2>

    <!-- Department Form -->
    <form method="post" action="">
        <input type="text" name="department_name" placeholder="Enter Department Name" required>
        <button type="submit" name="add_department">Add Department</button>
    </form>

    <!-- Department Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Department Name</th>
            <th>Action</th>
        </tr>

        <?php
        // Connect database
        $conn = new mysqli("localhost", "root", "", "hms");

        // Add department
        if (isset($_POST['add_department'])) {
            $dept = $_POST['department_name'];
            $conn->query("INSERT INTO departments (department_name) VALUES ('$dept')");
            header("Location: departments.php");
        }

        // Delete department
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM departments WHERE id=$id");
            header("Location: departments.php");
        }

        // Display departments
        $result = $conn->query("SELECT * FROM departments");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['department_name']."</td>
                    <td><a href='?delete=".$row['id']."'>Delete</a></td>
                </tr>";
        }
        ?>
    </table>

</div>

</body>
</html>
