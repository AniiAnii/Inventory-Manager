<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "praksaa"; // Make sure this is the correct database name

// Check connection
$conn = new mysqli($hostname, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
