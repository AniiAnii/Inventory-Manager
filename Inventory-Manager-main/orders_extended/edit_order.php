<?php
include '../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Porudzbina</title>
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
</head>
<body>
    <h1>Izmenite Porudzbinu</h1>

    <?php
    // Check if PorudzbinaID is set in the query string
    if(isset($_GET['PorudzbinaID'])) {
        // Get the PorudzbinaID from the query string
        $porudzbinaID = $_GET['PorudzbinaID'];
        
        $sql = "SELECT * FROM porudzbine WHERE PorudzbinaID = $porudzbinaID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Populate form fields with order details
                $nazivDela = $row["NazivDela"];
                $sifraDela = $row["SifraDela"];
                $DatumZaPovrsinskuZastitu = $row["DatumZaPovrsinskuZastitu"];
                $DatumZaTermickuObradu = $row["DatumZaTermickuObradu"];
                $DatumIsporukeDelova = $row["DatumIsporukeDelova"];
                $Kolicina = $row["Kolicina"];
                $BrojPotrebnihSipki = $row["BrojPotrebnihSipki"];
            }
        } else {
            echo "0 results";
        }

    ?>
    
    <!-- Form to edit order details -->
    <form method="post" action="update_order.php">
        <input type="hidden" name="PorudzbinaID" value="<?php echo $porudzbinaID; ?>">
        
        <label for="nazivDela">Naziv Dela:</label>
        <input type="text" id="nazivDela" name="nazivDela" value="<?php echo isset($nazivDela) ? $nazivDela : ''; ?>"><br><br>
        
        <label for="sifraDela">Sifra Dela:</label>
        <input type="text" id="sifraDela" name="sifraDela" value="<?php echo isset($sifraDela) ? $sifraDela : ''; ?>"><br><br> 

        <label for="DatumZaPovrsinskuZastitu">Datum za povrsinsku zastitu:</label>
        <input type="date" id="DatumZaPovrsinskuZastitu" name="DatumZaPovrsinskuZastitu" value="<?php echo isset($DatumZaPovrsinskuZastitu) ? $DatumZaPovrsinskuZastitu : ''; ?>"><br><br>
        
        <label for="DatumZaTermickuObradu">Datum za termicku obradu:</label>
        <input type="date" id="DatumZaTermickuObradu" name="DatumZaTermickuObradu" value="<?php echo isset($DatumZaTermickuObradu) ? $DatumZaTermickuObradu : ''; ?>"><br><br>
        
        <label for="DatumIsporukeDelova">Datum Isporuke Delova:</label>
        <input type="date" id="DatumIsporukeDelova" name="DatumIsporukeDelova" value="<?php echo isset($DatumIsporukeDelova) ? $DatumIsporukeDelova : ''; ?>"><br><br>
        
        <label for="Kolicina">Kolicina:</label>
        <input type="text" id="Kolicina" name="Kolicina" value="<?php echo isset($Kolicina) ? $Kolicina : ''; ?>"><br><br>
        
        <label for="BrojPotrebnihSipki">BrojPotrebnihSipki:</label>
        <input type="text" id="BrojPotrebnihSipki" name="BrojPotrebnihSipki" value="<?php echo isset($BrojPotrebnihSipki) ? $Kolicina : ''; ?>"><br><br>
        
        <input type="submit" class="dugme" value="Save Changes">
    </form>


    <?php
    } else {
        echo "PorudzbinaID is not set in the query string.";
    }
    ?>

</body>
</html>
