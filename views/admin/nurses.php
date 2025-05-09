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
    <title>Nurse Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Nurse Management</h2>

    <!-- Nurse Form -->
    <form method="post" action="">
        <input type="text" name="nurse_name" placeholder="Enter Nurse Name" required>
        <input type="email" name="nurse_email" placeholder="Enter Email" required>
        <button type="submit" name="add_nurse">Add Nurse</button>
    </form>

    <!-- Nurse Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nurse Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php
        // Connect database
        $conn = new mysqli("localhost", "root", "", "hms");

        // Add nurse
        if (isset($_POST['add_nurse'])) {
            $name = $_POST['nurse_name'];
            $email = $_POST['nurse_email'];
            $conn->query("INSERT INTO nurses (name, email) VALUES ('$name', '$email')");
            header("Location: nurses.php");
        }

        // Delete nurse
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM nurses WHERE id=$id");
            header("Location: nurses.php");
        }

        // Display nurses
        $result = $conn->query("SELECT * FROM nurses");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['email']."</td>
                    <td><a href='?delete=".$row['id']."'>Delete</a></td>
                </tr>";
        }
        ?>
    </table>

</div>

</body>
</html>
