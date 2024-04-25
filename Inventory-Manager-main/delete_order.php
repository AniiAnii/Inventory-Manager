<?php
include 'connection.php';

// Check if RedniBroj parameter is set in the URL
if (isset($_GET['RedniBroj'])) {
    // Prepare a SQL statement
    $sql = "DELETE FROM delovi WHERE RedniBroj = ?";

    // Prepare the SQL statement for execution
    $stmt = $conn->prepare($sql);

    // Bind the parameter to the SQL statement
    $stmt->bind_param('i', $RedniBroj); // 'i' indicates integer type

    // Get RedniBroj value from GET parameter
    $RedniBroj = $_GET['RedniBroj'];

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
    echo "RedniBroj parameter is not set.";
}
