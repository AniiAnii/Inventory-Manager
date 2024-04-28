function getOrdersPerFirm() {
    // Include the database connection
    include '../connection.php';

    // Initialize an empty array to store the results
    $ordersPerFirm = array();

    // Query to count the number of orders for each firm
    $sql = "SELECT firmId, COUNT(*) AS orderCount FROM firm_orders GROUP BY firmId";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Loop through the results and store them in the array
        while ($row = $result->fetch_assoc()) {
            $ordersPerFirm[$row['firmId']] = $row['orderCount'];
        }
    } else {
        // If there was an error in the query, display an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();

    // Return the array containing the number of orders for each firm
    return $ordersPerFirm;
}
