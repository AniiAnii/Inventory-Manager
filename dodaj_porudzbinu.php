<?php
// Initialize an empty array to store errors
$errors = array();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connection.php';

    // Prepare SQL statement for inserting a new order
    $sql = "INSERT INTO Porudzbine (SifraDela, NazivDela, DatumZaPovrsinskuZastitu, DatumZaTermickuObradu, DatumIsporukeDelova, Kolicina, BrojPotrebnihSipki)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare SQL statement with parameters
    $stmt = $conn->prepare($sql);
    // Bind parameters
    $stmt->bind_param("sssssss", $_POST['sifra_dela'], $_POST['naziv_dela'], $_POST['datum_za_povrsinsku_zastitu'], $_POST['datum_za_termicku_obradu'], $_POST['datum_isporuke_delova'], $_POST['kolicina'], $_POST['broj_potrebnih_sipki']);

    // Execute prepared SQL statement
    if ($stmt->execute() === TRUE) {
        echo "Nova porudžbina je uspješno dodana.";

        // Get the last inserted order ID
        $orderId = $stmt->insert_id;

        // Insert into firm_orders table
        $firmId = $_POST['firm']; // Assuming 'firm' is the name of the select element
        $status = "porucen";

        $sql_firm_orders = "INSERT INTO firm_orders (firmId, orderId, status) VALUES (?, ?, ?)";
        $stmt_firm_orders = $conn->prepare($sql_firm_orders);
        $stmt_firm_orders->bind_param("iis", $firmId, $orderId, $status);

        if ($stmt_firm_orders->execute() === TRUE) {
            echo "Nova porudžbina je uspješno dodana u firm_orders.";
        } else {
            echo "Greška prilikom dodavanja porudžbine u firm_orders: " . $stmt_firm_orders->error;
        }

        // Close statement
        $stmt_firm_orders->close();
    } else {
        echo "Greška prilikom dodavanja porudžbine: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
    // Close connection
    $conn->close();
}

// Fetch firms from the database
include 'connection.php';
$sql_firms = "SELECT * FROM firm";
$result_firms = $conn->query($sql_firms);

// Check if there are any errors in fetching firms
if (!$result_firms) {
    $errors[] = "Error fetching firms: " . $conn->error;
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles/add_order.css">
    < <title>Dodaj porudžbinu</title>
</head>

<body class="body">
    <div class="container">
        <a class="a" href="index.php">Vrati se</a>
        <h2 class=" heading">Dodaj porudžbinu</h2>
        <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Add firm selection dropdown -->
            <label for="firm" class="label">Firma:</label>
            <select id="firm" name="firm" class="input">
                <?php
                // Display firms in the dropdown menu
                if ($result_firms->num_rows > 0) {
                    while ($row_firm = $result_firms->fetch_assoc()) {
                        echo "<option value='" . $row_firm["firmId"] . "'>" . $row_firm["name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>Nema dostupnih firmi</option>";
                }
                ?>
            </select><br><br>

            <label for="sifra_dela" class="label">Šifra Dela:</label>
            <input type="text" id="sifra_dela" name="sifra_dela" class="input"><br><br>

            <label for="naziv_dela" class="label">Naziv Dela:</label>
            <input type="text" id="naziv_dela" name="naziv_dela" class="input"><br><br>

            <label for="datum_za_povrsinsku_zastitu" class="label">Datum Za Površinsku Zaštitu:</label>
            <input type="date" id="datum_za_povrsinsku_zastitu" name="datum_za_povrsinsku_zastitu" class="input"><br><br>

            <label for="datum_za_termicku_obradu" class="label">Datum Za Termičku Obradu:</label>
            <input type="date" id="datum_za_termicku_obradu" name="datum_za_termicku_obradu" class="input"><br><br>

            <label for="datum_isporuke_delova" class="label">Datum Isporuke Delova:</label>
            <input type="date" id="datum_isporuke_delova" name="datum_isporuke_delova" class="input"><br><br>

            <label for="kolicina" class="label">Količina:</label>
            <input type="number" id="kolicina" name="kolicina" class="input"><br><br>

            <label for="broj_potrebnih_sipki" class="label">Broj Potrebnih Šipki:</label>
            <input type="number" id="broj_potrebnih_sipki" name="broj_potrebnih_sipki" class="input"><br><br>

            <input type="submit" value="Dodaj porudžbinu" class="submit">
        </form>
    </div>

</body>

</html>