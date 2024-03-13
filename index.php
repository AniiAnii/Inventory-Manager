<!DOCTYPE html>
<html>
<?php
include 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Process the form data (you can perform database operations or any other tasks here)
    // For demonstration, let's just print the submitted data
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
}
?>


<head>
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    <title>Unos novog dela</title>
    <script>
        // JavaScript za otvaranje/zatvaranje modalnog dijaloga
        function showDeleteConfirmation(PorudzbinaID) {
            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];
            modal.style.display = "block";

            // Zatvori modal klikom na "X"
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Zatvori modal klikom van njega
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            // Potvrdi brisanje porudžbine
            var confirmBtn = document.getElementById("confirmDelete");
            confirmBtn.onclick = function() {
                // Pozovi funkciju za brisanje porudžbine
                obrisiPorudzbinu(PorudzbinaID);
                // Zatvori modal
                modal.style.display = "none";
            }
        }

        // Funkcija za brisanje porudžbine
        function obrisiPorudzbinu(id) {
            // Pitamo korisnika da li je siguran da želi obrisati porudžbinu
            var potvrda = confirm("Da li ste sigurni da želite obrisati ovu porudžbinu?");
            if (potvrda) {
                // Ako korisnik potvrdi brisanje, preusmeravamo ga na stranicu za brisanje porudžbine sa prosleđenim ID-jem
                window.location.href = "obrisi_porudzbinu.php?id=" + id;
            }
        }
    </script>

</head>

<body>

    <div style="text-align: right;">
        <a href="unos_novog_dela.php" class="dugme">Unos novog dela</a>
    </div>

    <h2> Firme </h2>
    <form method="get" action="add_firm.php">
        <input type="submit" value="Dodaj firmu" class="dugme">
    </form>

    <h2>Unos novog dela</h2>

    <h2>Porudžbine</h2>

    <form method="get" action="dodaj_porudzbinu.php">
        <input type="submit" value="Dodaj porudžbinu" class="dugme">
    </form>

    <div style="height: 20px;"></div>

    <?php
    // Dohvatanje porudžbina iz baze podataka
    $sql = "SELECT * FROM Porudzbine";
    $result = $conn->query($sql);

    // Prikazivanje porudžbina u obliku tabele
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                    <th>Šifra Dela</th>
                    <th>Naziv Dela</th>
                    <th>Datum Za Povrsinsku Zastitu</th>
                    <th>Datum Za Termičku Obradu</th>
                    <th>Datum Isporuke Delova</th>
                    <th>Količina</th>
                    <th>Broj Potrebnih Šipki</th>
                    <th>Akcija</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["SifraDela"] . "</td>"; //*
            echo "<td>" . $row["NazivDela"] . "</td>"; //*
            echo "<td>" . $row["DatumZaPovrsinskuZastitu"] . "</td>"; //*
            echo "<td>" . $row["DatumZaTermickuObradu"] . "</td>"; //*
            echo "<td>" . $row["DatumIsporukeDelova"] . "</td>";
            echo "<td>" . $row["Kolicina"] . "</td>";
            echo "<td>" . $row["BrojPotrebnihSipki"] . "</td>";
            echo "<td><button onclick='showDeleteConfirmation(" . $row['PorudzbinaID'] . ")'>Obriši</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nema porudžbina.";
    }

    // Zatvaranje konekcije
    $conn->close();
    ?>
    <!-- Ovdje dodajte redove sa podacima o porudžbinama -->
    </tbody>
    </table>

    <!-- Modal dialog -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Da li ste sigurni da želite obrisati ovu porudžbinu?</p>
            <button id="confirmDelete">Da</button>
            <button id="cancelDelete">Ne</button>
        </div>
    </div>


</body>

</html>