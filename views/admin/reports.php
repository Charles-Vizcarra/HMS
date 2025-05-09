<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}
include('../../includes/sidebar.php');

// Connect database
$conn = new mysqli("localhost", "root", "", "hms");

// Billing Summary Report
$billing = $conn->query("SELECT * FROM billing");

// Doctor List Report
$doctors = $conn->query("SELECT doctors.*, departments.department_name FROM doctors LEFT JOIN departments ON doctors.department_id = departments.id");

// Nurses List Report
$nurses = $conn->query("SELECT * FROM nurses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Reports</h2>

    <!-- Billing Summary -->
    <h3>Billing Summary</h3>

    <!-- Export Button -->
    <form method="post" action="export_billing_pdf.php">
    <button type="submit" class="button">Export Billing to PDF</button>
</form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Patient Name</th>
            <th>Doctor Fee</th>
            <th>Medicine Cost</th>
            <th>Total Amount</th>
        </tr>
        <?php while ($row = $billing->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['patient_name'] ?></td>
            <td><?= $row['doctor_fee'] ?></td>
            <td><?= $row['medicine_cost'] ?></td>
            <td><?= $row['total_amount'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Doctor List -->
    <h3>Doctors List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialty</th>
            <th>Department</th>
        </tr>
        <?php while ($row = $doctors->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['specialty'] ?></td>
            <td><?= $row['department_name'] ?? 'Not Assigned' ?></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Nurses List -->
    <h3>Nurses List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nurse Name</th>
            <th>Email</th>
        </tr>
        <?php while ($row = $nurses->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>
