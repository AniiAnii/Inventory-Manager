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

        // Provjeravamo da li je slika uspješno učitana
        if ($_FILES['slika']['error'] === UPLOAD_ERR_OK) {
            // Priprema slike za unos
            $slika = file_get_contents($_FILES['slika']['tmp_name']); // Učitavanje sadržaja slike u promenljivu

            // Pripremamo SQL upit za unos novog dijela
            $sql = "INSERT INTO Deo (Slika, Sifra, Naziv, VrstaMaterijala, PrecnikMaterijala, MestoObavljenjaPovrsinskeZastite, KomadiIzSipke, MeraProizvodaUGramima) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Pripremamo prepared statement
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Bindujemo parametre
                $stmt->bind_param("bsssssid", $slika, $_POST['sifra'], $_POST['naziv'], $_POST['vrsta_materijala'], $_POST['precnik_materijala'], $_POST['mesto_obavljenja_zastite'], $_POST['komadi_iz_sipke'], $_POST['mera_proizvoda_grami']);

                // Izvršavamo upit
                if ($stmt->execute()) {
                    echo "Uspešno ste uneli novi deo.";
                } else {
                    echo "Greška pri unosu novog dela: " . $stmt->error;
                }

                // Zatvaramo prepared statement
                $stmt->close();
            } else {
                echo "Greška pri pripremi upita: " . $conn->error;
            }
        } else {
            echo "Greška pri učitavanju slike: " . $_FILES['slika']['error'];
        }

        // Zatvaramo konekciju
        $conn->close();
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="slika">Slika (PDF format):</label>
        <input type="file" id="slika" name="slika" accept="application/pdf"><br><br>

        <label for="sifra">Sifra:</label>
        <input type="text" id="sifra" name="sifra"><br><br>

        <label for="naziv">Naziv:</label>
        <input type="text" id="naziv" name="naziv"><br><br>

        <label for="vrsta_materijala">Vrsta Materijala:</label>
        <input type="text" id="vrsta_materijala" name="vrsta_materijala"><br><br>

        <label for="precnik_materijala">Precnik Materijala:</label>
        <input type="text" id="precnik_materijala" name="precnik_materijala"><br><br>

        <label for="mesto_obavljenja_zastite">Mesto Obavljenja Povrsinske Zastite:</label>
        <input type="text" id="mesto_obavljenja_zastite" name="mesto_obavljenja_zastite"><br><br>

        <label for="komadi_iz_sipke">Komadi iz sipke:</label>
        <input type="text" id="komadi_iz_sipke" name="komadi_iz_sipke"><br><br>

        <label for="mera_proizvoda_grami">Mera proizvoda u gramima:</label>
        <input type="text" id="mera_proizvoda_grami" name="mera_proizvoda_grami"><br><br>

        <input type="submit" value="Submit">
    </form>


</body>

</html>
