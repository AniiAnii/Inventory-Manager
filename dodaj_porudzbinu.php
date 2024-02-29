<?php
// Provjera da li je zahtjev poslan metod POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Spajanje na bazu podataka
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "praksaa";

    // Provjera konekcije
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Neuspješna konekcija: " . $conn->connect_error);
    }

    // Provjera sesije
    if (!isset($_SESSION)) {
        session_start();
    }

    // Priprema SQL upita za unos nove porudžbine
    $sql = "INSERT INTO Porudzbine (DatumZaTermicku, VrstaTermickeObrade, DatumIsporukeDelova, Kolicina, GrPotrebnihSipki)
    VALUES (?, ?, ?, ?, ?)";

    // Priprema SQL naredbe za izvršenje s parametrima
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $_POST['datum_za_termicku'], $_POST['vrsta_termicke_obrade'], $_POST['datum_isporuke_delova'], $_POST['kolicina'], $_POST['gr_potrebnih_sipki']);

    // Izvršavanje pripremljene SQL naredbe
    if ($stmt->execute() === TRUE) {
        echo "Nova porudžbina je uspješno dodana.";

        // Zatvaranje konekcije
        $stmt->close();
        $conn->close();

        // Preusmjeravanje na početnu stranicu nakon 2 sekunde
        echo '<script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 2000);
        </script>';
    } else {
        echo "Greška prilikom dodavanja porudžbine: " . $stmt->error;

        // Zatvaranje konekcije
        $stmt->close();
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
        <label for="datum_za_termicku">Datum Za Termičku:</label>
        <input type="date" id="datum_za_termicku" name="datum_za_termicku"><br><br>

        <label for="vrsta_termicke_obrade">Vrsta Termičke Obrade:</label>
        <input type="text" id="vrsta_termicke_obrade" name="vrsta_termicke_obrade"><br><br>

        <label for="datum_isporuke_delova">Datum Isporuke Delova:</label>
        <input type="date" id="datum_isporuke_delova" name="datum_isporuke_delova"><br><br>

        <label for="kolicina">Količina:</label>
        <input type="number" id="kolicina" name="kolicina"><br><br>

        <label for="gr_potrebnih_sipki">Gr Potrebnih Sipki:</label>
        <input type="text" id="gr_potrebnih_sipki" name="gr_potrebnih_sipki"><br><br>

        <input type="submit" value="Dodaj porudžbinu">
    </form>


</body>

</html>
