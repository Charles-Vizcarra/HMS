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
    <title>Billing Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Billing Management</h2>

    <!-- Billing Form -->
    <form method="post" action="">
        <input type="text" name="patient_name" placeholder="Enter Patient Name" required>
        <input type="number" name="doctor_fee" placeholder="Enter Doctor Fee" step="0.01" required>
        <input type="number" name="medicine_cost" placeholder="Enter Medicine Cost" step="0.01" required>
        <button type="submit" name="add_bill">Add Bill</button>
    </form>

    <!-- Billing Table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Patient Name</th>
            <th>Doctor Fee</th>
            <th>Medicine Cost</th>
            <th>Total Amount</th>
            <th>Action</th>
        </tr>

        <?php
        // Connect database
        $conn = new mysqli("localhost", "root", "", "hms");

        // Add bill
        if (isset($_POST['add_bill'])) {
            $patient = $_POST['patient_name'];
            $doctor_fee = $_POST['doctor_fee'];
            $medicine_cost = $_POST['medicine_cost'];
            $total = $doctor_fee + $medicine_cost;

            $conn->query("INSERT INTO billing (patient_name, doctor_fee, medicine_cost, total_amount) VALUES ('$patient', $doctor_fee, $medicine_cost, $total)");
            header("Location: billing.php");
        }

        // Delete bill
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $conn->query("DELETE FROM billing WHERE id=$id");
            header("Location: billing.php");
        }

        // Display bills
        $result = $conn->query("SELECT * FROM billing");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['patient_name']."</td>
                    <td>".$row['doctor_fee']."</td>
                    <td>".$row['medicine_cost']."</td>
                    <td>".$row['total_amount']."</td>
                    <td><a href='?delete=".$row['id']."'>Delete</a></td>
                </tr>";
        }
        ?>
    </table>

</div>

</body>
</html>
