<?php
// Include database connection
include '../connection.php';

// Query to fetch data
$query = "
    SELECT NazivDela, COUNT(*) AS count
    FROM porudzbine
    GROUP BY NazivDela
    ORDER BY count DESC
    LIMIT 7;
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
