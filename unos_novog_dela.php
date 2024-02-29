<!DOCTYPE html>
<html>

<head>
    <title>Unos novog dela</title>
</head>

<body>

    <div style="text-align: right;">
        <a href="unos_novog_dela.php">Unos novog dela</a>
    </div>

    <h2>Unos novog dela</h2>

    <?php
    // Provjeravamo da li je forma poslana
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Spajamo se na bazu podataka
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "praksaa";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Provjeravamo konekciju
        if ($conn->connect_error) {
            die("Neuspjela konekcija: " . $conn->connect_error);
        }

        // Pripremamo SQL upit za unos novog dijela
        $sql = "INSERT INTO delovi (RedniBroj, Sifra, Naziv, VrstaMaterijala, Zastita, KomadiIzSipke, MeraProizvodaGrami)
    VALUES ('$_POST[redni_broj]', '$_POST[sifra]', '$_POST[naziv]', '$_POST[vrsta_materijala]', '$_POST[zastita]', '$_POST[komadi_iz_sipke]', '$_POST[mera_proizvoda_grami]')";

        // Izvršavamo SQL upit
        if ($conn->query($sql) === TRUE) {
            echo "Novi zapis je uspješno dodan.";
        } else {
            echo "Greška prilikom dodavanja zapisa: " . $conn->error;
        }

        // Zatvaramo konekciju
        $conn->close();
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="redni_broj">Redni Broj:</label>
        <input type="text" id="redni_broj" name="redni_broj"><br><br>

        <label for="sifra">Sifra:</label>
        <input type="text" id="sifra" name="sifra"><br><br>

        <label for="naziv">Naziv:</label>
        <input type="text" id="naziv" name="naziv"><br><br>

        <label for="vrsta_materijala">Vrsta Materijala:</label>
        <input type="text" id="vrsta_materijala" name="vrsta_materijala"><br><br>

        <label for="zastita">*** Zastita:</label>
        <input type="text" id="zastita" name="zastita"><br><br>

        <label for="komadi_iz_sipke">Komadi iz sipke:</label>
        <input type="text" id="komadi_iz_sipke" name="komadi_iz_sipke"><br><br>

        <label for="mera_proizvoda_grami">Mera proizvoda u gramima:</label>
        <input type="text" id="mera_proizvoda_grami" name="mera_proizvoda_grami"><br><br>

        <input type="submit" value="Submit">
    </form>

</body>

</html>
