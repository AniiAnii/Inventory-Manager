<?php
include 'connection.php';

if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Delete the order from the database
    $sql_delete_order = "DELETE FROM Porudzbine WHERE PorudzbinaID = $orderId";
    if ($conn->query($sql_delete_order) === TRUE) {
        // If deletion is successful, send back a success response
        echo "Order deleted successfully";
    } else {
        // If deletion fails, send back an error response
        echo "Error deleting order: " . $conn->error;
    }
}
?>
