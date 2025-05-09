<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}
include('../../includes/sidebar.php');

// Connect DB
$conn = new mysqli("localhost", "root", "", "hms");

// Handle Add User
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password
    $role = $_POST['role'];

    $conn->query("INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')");
    header("Location: employees.php");
    exit();
}

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: employees.php");
    exit();
}

// Fetch Users
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>

<div class="content">
    <h2>Employee Management</h2>

    <!-- Add User Form -->
    <form method="POST">
        <input type="text" name="username" placeholder="Full Name" required>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">-- Select Role --</option>
            <option value="Doctor">Doctor</option>
            <option value="Nurse">Nurse</option>
            <option value="Pharmacist">Pharmacist</option>
            <option value="Cashier">Cashier</option>
        </select>
        <button type="submit" name="add_user" class="button">Add Employee</button>
    </form>

    <h3>Employee List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['role'] ?></td>
            <td>
                <a href="employees.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
