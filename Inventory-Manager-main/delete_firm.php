<?php
include 'connection.php';

// Get the firm name from the POST request
$firmName = $_POST['firmName'];

// Prepare a statement to delete the firm
$stmt = $conn->prepare("DELETE FROM firm WHERE name = ?");
$stmt->bind_param("s", $firmName); // "s" indicates a string type

// Execute the statement
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Firm deleted successfully";
    } else {
        echo "Firm not found";
    }
} else {
    echo "Error deleting firm: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
