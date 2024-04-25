<?php
// Include your database connection file
include 'connection.php';

// Check if id parameter is set in the URL
if (isset($_GET['id'])) {
    // Prepare a SQL statement
    $sql = "DELETE FROM delovi WHERE Sifra = ?";

    // Prepare the SQL statement for execution
    $stmt = $conn->prepare($sql);

    // Bind the parameter to the SQL statement
    $stmt->bind_param('i', $Sifra); // 'i' indicates integer type

    // Get RedniBroj value from GET parameter
    $Sifra = $_GET['id']; // Updated to 'id' from the URL parameter

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the main page after deleting the part
        header('Location: index.php');
    } else {
        echo "Error deleting part: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "ID parameter is not set.";
}
