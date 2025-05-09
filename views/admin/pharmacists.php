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
    <title>Pharmacist Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Pharmacist Management</h2>

    <!-- Pharmacist Form -->
    <form method="post" action="">
        <input type="text" name="pharmacist_name" placeholder="Enter Pharmacist Name" required>
        <input type="email" name="pharmacist_email" placeholder="Enter Email" required>
        <button type="submit" name="add_pharmacist">Add Pharmacist</button>
    </form>

    <!-- Pharmacist Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Pharmacist Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php
        // Connect database
        $conn = new mysqli("localhost", "root", "", "hms");

        // Add pharmacist
        if (isset($_POST['add_pharmacist'])) {
            $name = $_POST['pharmacist_name'];
            $email = $_POST['pharmacist_email'];
            $conn->query("INSERT INTO pharmacists (name, email) VALUES ('$name', '$email')");
            header("Location: pharmacists.php");
        }

        // Delete pharmacist
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM pharmacists WHERE id=$id");
            header("Location: pharmacists.php");
        }

        // Display pharmacists
        $result = $conn->query("SELECT * FROM pharmacists");
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
