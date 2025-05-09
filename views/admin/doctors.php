<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}
include('../../includes/sidebar.php');

// Connect database
$conn = new mysqli("localhost", "root", "", "hms");

// Handle Add Doctor
if (isset($_POST['add_doctor'])) {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $dept_id = $_POST['department_id'];

    $sql = "INSERT INTO doctors (name, specialty, department_id) VALUES ('$name', '$specialty', $dept_id)";
    $conn->query($sql);
    header("Location: doctors.php");
    exit();
}

// Handle Delete Doctor
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM doctors WHERE id=$id");
    header("Location: doctors.php");
    exit();
}

// Fetch doctors with department names
$doctors = $conn->query("SELECT doctors.*, departments.department_name FROM doctors LEFT JOIN departments ON doctors.department_id = departments.id");

// Fetch departments for dropdown
$departments = $conn->query("SELECT * FROM departments");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Doctor Management</h2>

    <!-- Add Doctor Form -->
    <form method="POST">
        <input type="text" name="name" placeholder="Doctor Name" required>
        <input type="text" name="specialty" placeholder="Specialty" required>
        <select name="department_id" required>
            <option value="">-- Select Department --</option>
            <?php while ($dept = $departments->fetch_assoc()) { ?>
                <option value="<?php echo $dept['id']; ?>"><?php echo $dept['department_name']; ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="add_doctor" class="button">Add Doctor</button>
    </form>

    <h3>Doctor List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialty</th>
            <th>Department</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $doctors->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['specialty']; ?></td>
            <td><?php echo $row['department_name'] ?? 'Not Assigned'; ?></td>
            <td>
                <a href="doctors.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this doctor?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
