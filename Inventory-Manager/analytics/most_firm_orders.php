<?php
// Include database connection
include '../connection.php';


// Query to fetch data with LIMIT
$query = "
    SELECT f.name AS firm_name, COUNT(fo.orderId) AS order_count
    FROM firm_orders fo
    INNER JOIN firm f ON fo.firmId = f.firmId
    GROUP BY f.firmId
    ORDER BY order_count DESC
    LIMIT 7
";

// Fetch data
$result = $conn->query($query);

// Convert data to associative array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close connection
$conn->close();

// Output JSON data
header('Content-Type: application/json');
echo json_encode($data);
?>
