<?php
// Function to get the number of orders for each firm along with firm names and counts per status
function getOrdersPerFirmWithNamesAndStatusCounts() {
    include '../connection.php';

    $ordersPerFirm = array();

    $sql = "SELECT fo.firmId, f.name AS firmName, 
                SUM(CASE WHEN fo.status = 'poslat' THEN 1 ELSE 0 END) AS poslatCount,
                SUM(CASE WHEN fo.status = 'porucen' THEN 1 ELSE 0 END) AS porucenCount
            FROM firm_orders fo 
            INNER JOIN firm f ON fo.firmId = f.firmId 
            GROUP BY fo.firmId";

    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $firmId = $row['firmId'];
            $firmName = $row['firmName'];
            $poslatCount = $row['poslatCount'];
            $porucenCount = $row['porucenCount'];
            $ordersPerFirm[$firmId] = array(
                'firmName' => $firmName,
                'poslatCount' => $poslatCount,
                'porucenCount' => $porucenCount
            );
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    return $ordersPerFirm;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetchOrders'])) {
    $ordersPerFirmWithNamesAndStatusCounts = getOrdersPerFirmWithNamesAndStatusCounts();
    echo "<div style='margin-top: 20px; background-color: rgb(0, 0, 0, 0.5); margin-bottom: 20px; padding-top: 20px;'>";

    foreach ($ordersPerFirmWithNamesAndStatusCounts as $firmId => $data) {
        echo $data['firmName'] . "<br>";
        echo "Broj porudzbina poslatih: " . $data['poslatCount'] . "<br>";
        echo "Broj porudzbina porucenih: " . $data['porucenCount'] . "<br><br>";
    }

    echo "</div>";
}
?>
