<?php
include 'connection.php';

if (isset($_GET['firmName'])) {
    $firmName = $_GET['firmName'];

    // Fetch firm ID based on the firm name
    $sql_firm_id = "SELECT firmId FROM firm WHERE name = '$firmName'";
    $result_firm_id = $conn->query($sql_firm_id);

    if ($result_firm_id->num_rows > 0) {
        $row_firm_id = $result_firm_id->fetch_assoc();
        $firmId = $row_firm_id['firmId'];

        // Fetch orders for the selected firm
        $sql_orders = "SELECT p.*, f.name AS firm_name, fo.status 
            FROM Porudzbine p 
            INNER JOIN firm_orders fo ON p.PorudzbinaID = fo.orderId 
            INNER JOIN firm f ON fo.firmId = f.firmId
            WHERE f.firmId = $firmId";
        $result_orders = $conn->query($sql_orders);

        if ($result_orders->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr>
                        <th>Šifra Dela</th>
                        <th>Naziv Dela</th>
                        <th>Datum Za Povrsinsku Zastitu</th>
                        <th>Datum Za Termičku Obradu</th>
                        <th>Datum Isporuke Delova</th>
                        <th>Količina</th>
                        <th>Broj Potrebnih Šipki</th>
                        <th>Status</th>
                        <th>Akcija</th>
                    </tr>";
            while ($row_order = $result_orders->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_order["SifraDela"] . "</td>";
                echo "<td>" . $row_order["NazivDela"] . "</td>";
                echo "<td>" . $row_order["DatumZaPovrsinskuZastitu"] . "</td>";
                echo "<td>" . $row_order["DatumZaTermickuObradu"] . "</td>";
                echo "<td>" . $row_order["DatumIsporukeDelova"] . "</td>";
                echo "<td>" . $row_order["Kolicina"] . "</td>";
                echo "<td>" . $row_order["BrojPotrebnihSipki"] . "</td>";
                echo "<td>" . $row_order["status"] . "</td>";
                echo "<td><button onclick='showDeleteConfirmation(" . $row_order['PorudzbinaID'] . ")'>Obriši</button></td>";
                echo "<td><button onclick='prihvatiPorudzbinu(" . $row_order['PorudzbinaID'] . ")'>Porudzbina gotova</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No orders for the selected firm.";
        }
    } else {
        echo "Firm not found.";
    }
}
?>
