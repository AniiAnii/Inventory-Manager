<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unos novog dela</title>
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    <link rel="stylesheet" type="text/css" href="styles/add_firm.css">
    <script>
        function showDeleteConfirmation(PorudzbinaID) {
            var modal = document.getElementById("deleteModal"); // Promijenjen ID
            var span = modal.getElementsByClassName("close")[0]; // Promijenjen ID
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

        // Funkcija za prihvatanje porudžbine
        function prihvatiPorudzbinu(PorudzbinaID) {
            // AJAX request to change status to "prihvacen"
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert("Isporuka je zavrsena i poslata u istorijat.");
                        // Reload page to reflect changes
                        window.location.reload();
                    } else {
                        alert("Greška prilikom prihvatanja porudžbine.");
                    }
                }
            };
            xhr.open("POST", "change_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("PorudzbinaID=" + PorudzbinaID + "&status=poslat");
        }


        function showOrders(firmName) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Update the HTML content with the fetched orders
                        document.getElementById("orders").innerHTML = xhr.responseText;
                    } else {
                        alert("Error fetching orders.");
                    }
                }
            };
            xhr.open("GET", "get_orders.php?firmName=" + encodeURIComponent(firmName), true);
            xhr.send();
        }
    </script>
</head>

<body>
    <!-- Dodati skriveni input za čuvanje ID-ja porudžbine -->
    <input type="hidden" id="deleteOrderId" name="deleteOrderId">

    <!-- Ostatak koda ostaje isti -->
    <!-- Modal dialog -->
    <div id="myModal" class="Firm_modal">
        <div class="Firm_modal-content">
            <span class="Firm_close" onclick="closeModal()">&times;</span>
            <form id="addFirmForm">
                <label for="firmName">Firm Name:</label>
                <input type="text" name="firm_name" id="firmName" required>
                <!-- Promenite submit dugme u button -->
                <button type="submit">Potvrđujem</button>
            </form>
        </div>
    </div>

    <h2> Firme </h2>

    <!-- Display firms -->
    <?php
    // Fetch firms from the database
    $sql_firms = "SELECT * FROM firm";
    $result_firms = $conn->query($sql_firms);

    if ($result_firms->num_rows > 0) {
        echo "<ul class='firm-list'>"; // Add a class to the ul element
        while ($row_firm = $result_firms->fetch_assoc()) {
            echo "<li><a href='#'>" . $row_firm["name"] . "</a> <button class='firm_button' onclick='showOrders(\"" . $row_firm["name"] . "\")'>Prikazi porudzbine</button></li>";
        }
        echo "</ul>";
    } else {
        echo "Nema firmi.";
    }
    ?>
    <div id="orders"></div>

    <br>

    <!-- Button to open the modal -->
    <button onclick="openModal()" class="dugme">Dodaj firmu</button>

    <!-- JavaScript for the modal -->
    <script>
        // Function to open the modal
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Submit form via AJAX
        document.getElementById("addFirmForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            // Create FormData object to send form data
            var formData = new FormData(this);

            // Send AJAX request to insert_firm.php
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // On successful insertion, close modal and reload page
                        closeModal();
                        window.location.reload();
                    } else {
                        // If insertion fails, show error message
                        alert("Error inserting firm: " + xhr.responseText);
                    }
                }
            };
            xhr.open("POST", "insert_firm.php", true);
            xhr.send(formData);
        });
    </script>

    <h2>Delovi</h2>
    <a href="add_new_part.php" class="dugme">Unos novog dela</a>

    <?php
    $sql = "SELECT * FROM delovi";
    $result = $conn->query($sql);

    ?>
    <div class="table-wrapper">
        <table class="custom-table">
            <tr>
                <th>Picture</th>
                <th>Sifra</th>
                <th>Naziv</th>
                <th>Vrsta Materijala</th>
                <th>Precnik Materijala</th>
                <th>Zastita</th>
                <th>Komadi Iz Sipke</th>
                <th>Mera Proizvoda Grami</th>
            </tr>
            <?php
            // Check if there are rows in the result
            if ($result->num_rows > 0) {
                // Loop through each row and display data in table cells
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><img src='" . $row["PicturePath"] . "' alt='Slika'></td>";
                    echo "<td>" . $row["Sifra"] . "</td>";
                    echo "<td>" . $row["Naziv"] . "</td>";
                    echo "<td>" . $row["VrstaMaterijala"] . "</td>";
                    echo "<td>" . $row["RedniBroj"] . "</td>";
                    echo "<td>" . $row["Zastita"] . "</td>";
                    echo "<td>" . $row["KomadiIzSipke"] . "</td>";
                    echo "<td>" . $row["MeraProizvodaGrami"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Nema podataka u tabeli.</td></tr>";
            }
            ?>
        </table>
    </div <h2>Porudžbine</h2>

    <form method="get" action="dodaj_porudzbinu.php">
        <input type="submit" value="Dodaj porudžbinu" class="dugme">
    </form>

    <div style="height: 20px;"></div>
    <div class="table-wrapper">
        <table class="custom-table">
            <?php
            // Dohvatanje porudžbina iz baze podataka
            $sql = "SELECT p.*, f.name AS firm_name, fo.status 
        FROM Porudzbine p 
        INNER JOIN firm_orders fo ON p.PorudzbinaID = fo.orderId 
        INNER JOIN firm f ON fo.firmId = f.firmId
        ORDER BY DatumIsporukeDelova ASC"; // Sortiranje po DatumIsporukeDelova u opadajućem redosledu
            $result = $conn->query($sql);

            // Prikazivanje porudžbina u obliku tabele
            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr>
            <th>Firma</th>
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

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["firm_name"] . "</td>";
                    echo "<td>" . $row["SifraDela"] . "</td>"; //*
                    echo "<td>" . $row["NazivDela"] . "</td>"; //*
                    echo "<td>" . $row["DatumZaPovrsinskuZastitu"] . "</td>"; //*
                    echo "<td>" . $row["DatumZaTermickuObradu"] . "</td>"; //*
                    echo "<td>" . $row["DatumIsporukeDelova"] . "</td>";
                    echo "<td>" . $row["Kolicina"] . "</td>";
                    echo "<td>" . $row["BrojPotrebnihSipki"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td><button onclick='showDeleteConfirmation(" . $row['PorudzbinaID'] . ")'>Obriši</button></td>";
                    echo "<td><button onclick='prihvatiPorudzbinu(" . $row['PorudzbinaID'] . ")'>Porudzbina gotova</button></td>";
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

        <!-- Modal dialog for delete confirmation -->
        <div id="deleteModal" class="Amodal">
            <div class="Amodal-content">
                <span class="close">&times;</span>
                <p>Da li ste sigurni da želite obrisati ovu porudžbinu?</p>
                <button id="confirmDelete">Da</button>
                <button id="cancelDelete">Ne</button>
            </div>
        </div>


</body>

</html>