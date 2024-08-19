<?php
// Include database connection
include '../connection.php';

// Check if the year parameter is provided
if (isset($_GET['year'])) {
    $year = $_GET['year'];

    // Query to fetch data for orders per month in the selected year
    $query = "
        SELECT 
            MONTH(DatumPorudzbine) AS month, 
            COUNT(*) AS order_count
        FROM 
            porudzbine
        WHERE 
            YEAR(DatumPorudzbine) = $year
        GROUP BY 
            YEAR(DatumPorudzbine), MONTH(DatumPorudzbine)
        ORDER BY 
            YEAR(DatumPorudzbine), MONTH(DatumPorudzbine)
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
} else {
    // Return error if year parameter is not provided
    header("HTTP/1.0 400 Bad Request");
    echo "Year parameter is missing.";
}
?>
