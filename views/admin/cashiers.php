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
    <title>Cashier Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Cashier Management</h2>

    <!-- Cashier Form -->
    <form method="post" action="">
        <input type="text" name="cashier_name" placeholder="Enter Cashier Name" required>
        <input type="email" name="cashier_email" placeholder="Enter Email" required>
        <button type="submit" name="add_cashier">Add Cashier</button>
    </form>

    <!-- Cashier Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Cashier Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php
        // Connect database
        $conn = new mysqli("localhost", "root", "", "hms");

        // Add cashier
        if (isset($_POST['add_cashier'])) {
            $name = $_POST['cashier_name'];
            $email = $_POST['cashier_email'];
            $conn->query("INSERT INTO cashiers (name, email) VALUES ('$name', '$email')");
            header("Location: cashiers.php");
        }

        // Delete cashier
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM cashiers WHERE id=$id");
            header("Location: cashiers.php");
        }

        // Display cashiers
        $result = $conn->query("SELECT * FROM cashiers");
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
