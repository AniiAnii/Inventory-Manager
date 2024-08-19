<?php
include 'connection.php';

// Get the firm name from the POST request
$firmName = $_POST['firmName'];

// Delete the firm from the database
$sql = "DELETE FROM firm WHERE name = '$firmName'";

if ($conn->query($sql) === TRUE) {
    echo "Firm deleted successfully";
} else {
    echo "Error deleting firm: " . $conn->error;
}

// Close the connection
$conn->close();
