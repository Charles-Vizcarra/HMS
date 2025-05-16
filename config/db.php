<?php
$host = "localhost";
$dbname = "hms"; // change this to your db name
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
