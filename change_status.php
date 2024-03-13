<?php
// Include the database connection
include 'connection.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if PorudzbinaID and status are set
    if (isset($_POST['PorudzbinaID']) && isset($_POST['status'])) {
        // Sanitize the input
        $porudzbinaID = mysqli_real_escape_string($conn, $_POST['PorudzbinaID']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Update the status in the firm_orders table
        $sql = "UPDATE firm_orders SET status = '$status' WHERE orderId = $porudzbinaID";

        if (mysqli_query($conn, $sql)) {
            // Status updated successfully
            http_response_code(200); // OK
            echo "Status successfully updated to $status";
        } else {
            // Error updating status
            http_response_code(500); // Internal Server Error
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        // Required parameters not provided
        http_response_code(400); // Bad Request
        echo "PorudzbinaID and status are required parameters.";
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed.";
}

// Close the database connection
mysqli_close($conn);
?>
