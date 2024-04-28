<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles/index.css">
</head>
<body>
    <?php
    include 'connection.php';

    // Check if part ID is provided in the URL
    if(isset($_GET['edit'])) {
        // Retrieve the part ID from the URL
        $partId = $_GET['edit'];
        
        // Fetch part information from the database based on the part ID
        $sql = "SELECT * FROM delovi WHERE Sifra = $partId";
        $result = $conn->query($sql);
        
        // Check if part exists
        if ($result->num_rows > 0) {
            $part = $result->fetch_assoc();
            
            echo "<h1>Promeni informacije o delu</h1>";
            echo "<form action='update_part.php' method='post'>";
            echo "<input type='hidden' name='partId' value='" . $part['Sifra'] . "'>";
            echo "<br>";
            echo "Sifra: <input type='text' name='Sifra' value='" . $part['Sifra'] . "'>";
            echo "<br>";
            echo "<br>";
            echo "Naziv: <input type='text' name='Naziv' value='" . $part['Naziv'] . "'><br>";
            echo "<br>";
            echo "Vrsta Materijala: <input type='text' name='VrstaMaterijala' value='" . $part['VrstaMaterijala'] . "'><br>";
            echo "<br>";
            echo "Zastita: <input type='text' name='Zastita' value='" . $part['Zastita'] . "'><br>";
            echo "<br>";
            echo "Komadi iz sipke: <input type='text' name='KomadiIzSipke' value='" . $part['KomadiIzSipke'] . "'><br>";
            echo "<br>";
            echo "Mera porizvoda u gramima: <input type='text' name='MeraProizvodaGrami' value='" . $part['MeraProizvodaGrami'] . "'><br>";
            echo "<br>";
            
            echo "<input type='submit' class='dugme' value='Save Changes'>";
            echo "</form>";
        } else {
            echo "Part not found.";
        }
    } else {
        echo "Part ID not provided.";
    }
    ?>
</body>
</html>

