<?php
session_start(); // Start session

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "praksaa";

    // Connect to the database
    $conn = new mysqli($hostname, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

        // Close statement
        $stmt->close();
        // Close connection
        $conn->close();

        // Redirect to index.php after 2 seconds
        echo '<script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 2000);
        </script>';
    } else {
        echo "Greška prilikom dodavanja porudžbine: " . $stmt->error;

        // Close statement
        $stmt->close();
        // Close connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dodaj porudžbinu</title>
</head>

<body>

    <h2>Dodaj porudžbinu</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="sifra_dela">Šifra Dela:</label>
        <input type="text" id="sifra_dela" name="sifra_dela"><br><br>

        <label for="naziv_dela">Naziv Dela:</label>
        <input type="text" id="naziv_dela" name="naziv_dela"><br><br>

        <label for="datum_za_povrsinsku_zastitu">Datum Za Površinsku Zaštitu:</label>
        <input type="date" id="datum_za_povrsinsku_zastitu" name="datum_za_povrsinsku_zastitu"><br><br>

        <label for="datum_za_termicku_obradu">Datum Za Termičku Obradu:</label>
        <input type="date" id="datum_za_termicku_obradu" name="datum_za_termicku_obradu"><br><br>

        <label for="datum_isporuke_delova">Datum Isporuke Delova:</label>
        <input type="date" id="datum_isporuke_delova" name="datum_isporuke_delova"><br><br>

        <label for="kolicina">Količina:</label>
        <input type="number" id="kolicina" name="kolicina"><br><br>

        <label for="broj_potrebnih_sipki">Broj Potrebnih Šipki:</label>
        <input type="number" id="broj_potrebnih_sipki" name="broj_potrebnih_sipki"><br><br>

        <input type="submit" value="Dodaj porudžbinu">
    </form>

</body>

</html>
