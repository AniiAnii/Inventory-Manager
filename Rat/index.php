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
    <link rel="stylesheet" type="text/css" href="styles/image.css">
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

        function showDeleteConfirmation2(orderId) {
            if (confirm("Are you sure you want to delete this order?")) {
                // If user confirms deletion, make an AJAX request to delete the order
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // If deletion is successful, reload the page to reflect changes
                        location.reload();
                    }
                };
                xhttp.open("GET", "delete_order.php?orderId=" + orderId, true);
                xhttp.send();
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


        // JavaScript function to show or hide orders table
        function showOrders(firmName) {
            var ordersDiv = document.getElementById("orders");

            // If orders are already visible, hide them
            if (ordersDiv.style.display === 'block' && ordersDiv.getAttribute('data-firm') === firmName) {
                ordersDiv.style.display = 'none';
            } else {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Update the HTML content with the fetched orders
                            ordersDiv.innerHTML = xhr.responseText;
                            // Show orders and set the firm name attribute
                            ordersDiv.style.display = 'block';
                            ordersDiv.setAttribute('data-firm', firmName);
                        } else {
                            alert("Error fetching orders.");
                        }
                    }
                };
                xhr.open("GET", "get_orders.php?firmName=" + encodeURIComponent(firmName), true);
                xhr.send();
            }
        }
    </script>
    <style>
        /* Table styles */
        .table-wrapper {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(19, 19, 19, 0.5); /* Black background with 80% opacity */
            color: white;
        }

        .custom-table th,
        .custom-table td {
            padding: 8px;
            border: 2px solid #1a1a1a; /* Change border color to a lighter shade */
            color: white;
        }

        .custom-table th {
            background-color: rgba(255, 255, 255, 0.3); /* Light gray background with opacity */
            text-align: left;
        }

        .custom-table td {
            text-align: center;
        }

        .custom-table img {
            max-width: 100px;
            height: auto;
        }
    </style>

</head>

<body>
    <header>
        <img src="styles/logooo.png" style='height:100px; width:100px;'>
        <h2>DESKE metal press</h2>
    </header>
    <input type="hidden" id="deleteOrderId" name="deleteOrderId">


    <h1>Porudžbine</h1>

    <div class="button-container">
        <form method="get" action="dodaj_porudzbinu.php">
            <input type="submit" value="Dodaj porudžbinu" class="dugme">
        </form>
        <form method="get" action="orders_extended/orders_page.php">
            <input type="submit" value="Prikazi sve porudzbine" class="dugme">
        </form>
        <form method="get" action="analytics/analytics.php">
            <input type="submit" value="Analitika" class="dugme">
        </form>
    </div>


    <div style="height: 20px;"></div>
    <div class="underlay">
        <div class="table-wrapper">
            <table class="custom-table">
                <?php
                // Dohvatanje porudžbina iz baze podataka
                $sql = "SELECT p.*, f.name AS firm_name, fo.status 
        FROM Porudzbine p 
        INNER JOIN firm_orders fo ON p.PorudzbinaID = fo.orderId 
        INNER JOIN firm f ON fo.firmId = f.firmId
        WHERE fo.status = 'porucen' 
        ORDER BY DatumIsporukeDelova ASC 
        LIMIT 5"; // Dodat LIMIT 5

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
                </tr>";

                    while ($row = $result->fetch_assoc()) {
                        if ($row["status"] == "porucen") {
                            echo "<tr>";
                            echo "<td>" . $row["firm_name"] . "</td>";
                            echo "<td>" . $row["SifraDela"] . "</td>"; //*
                            echo "<td>" . $row["NazivDela"] . "</td>"; //*
                            echo "<td>" . $row["DatumZaPovrsinskuZastitu"] . "</td>"; //*
                            echo "<td>" . $row["DatumZaTermickuObradu"] . "</td>"; //*
                            echo "<td>" . $row["DatumIsporukeDelova"] . "</td>";
                            echo "<td>" . $row["Kolicina"] . "</td>";
                            echo "<td>" . $row["BrojPotrebnihSipki"] . "</td>";
                            echo "<td><button class='dugme2' onclick='showDeleteConfirmation2(" . $row['PorudzbinaID'] . ")'>Obriši</button></td>";
                            echo "<td><button class='dugme2' onclick='prihvatiPorudzbinu(" . $row['PorudzbinaID'] . ")'>Gotovo</button></td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
                } else {
                    echo "Nema porudžbina.";
                }

                // Zatvaranje konekcije
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
        </div>
    </div>

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

    <h1> Firme </h1>

    <!-- Display firms -->
    <?php
    // Fetch firms from the database
    $sql_firms = "SELECT * FROM firm";
    $result_firms = $conn->query($sql_firms);

    if ($result_firms->num_rows > 0) {
        echo "<ul class='firm-list'>"; // Add a class to the ul element
        while ($row_firm = $result_firms->fetch_assoc()) {
            echo "<li><a href='#'>" . $row_firm["name"] . "</a> <button class='dugme2' onclick='showOrders(\"" . $row_firm["name"] . "\")'>Prikazi porudzbine</button></li>";
        }
        echo "</ul>";
    } else {
        echo "Nema firmi.";
    }

    ?>

    <div class="underlay">
        <div id="orders"></div>
    </div>

    <br>

    <!-- Button to delete firm -->
    <button onclick="openDeleteFirmModal()" class="dugme">Obrisi firmu</button>

    <!-- Modal for deleting a firm -->
    <div id="deleteFirmModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteFirmModal()">&times;</span>
            <h2>Obrisi firmu</h2>
            <p>Koju firmu želite da obrišete?</p>
            <input type="text" id="deleteFirmName" required>
            <button onclick="deleteFirm()">Potvrdi</button>
        </div>
    </div>



    <!-- Button to open the modal -->
    <button onclick="openModal()" class="dugme">Dodaj firmu</button>


    <!-- JavaScript for the modal -->
    <script>
        // Function to open the delete modal for firm
        function openDeleteFirmModal() {
            document.getElementById("deleteFirmModal").style.display = "block";
        }

        // Function to close the delete modal for firm
        function closeDeleteFirmModal() {
            document.getElementById("deleteFirmModal").style.display = "none";
        }

        // Function to delete a firm
        function deleteFirm() {
            var firmName = document.getElementById("deleteFirmName").value;

            // Send AJAX request to delete_firm.php
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // On successful deletion, close modal and reload page
                        closeDeleteFirmModal();
                        window.location.reload();
                    } else {
                        // If deletion fails, show error message
                        alert("Error deleting firm: " + xhr.responseText);
                    }
                }
            };
            xhr.open("POST", "delete_firm.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("firmName=" + encodeURIComponent(firmName));
        }


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

    <h1>Delovi</h1>
    <a href="add_new_part.php" class="dugme">Unos novog dela</a>

    <?php
    $sql = "SELECT * FROM delovi";
    $result = $conn->query($sql);
    ?>
    <div class="underlay">
        <div class="table-wrapper">
            <table class="custom-table">
                <tr>
                    <th> </th>
                    <th>Sifra</th>
                    <th>Naziv</th>
                    <th>Vrsta Materijala</th>
                    <th>Precnik Materijala</th>
                    <th>Zastita</th>
                    <th>Komadi Iz Sipke</th>
                    <th>Mera Proizvoda Grami</th>

                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><img class='darken-on-hover' src='" . $row["PicturePath"] . "' alt='Slika' onclick='openLightbox(\"" . $row["PicturePath"] . "\")'></td>";
                        echo "<td>" . $row["Sifra"] . "</td>";
                        echo "<td>" . $row["Naziv"] . "</td>";
                        echo "<td>" . $row["VrstaMaterijala"] . "</td>";
                        echo "<td>" . $row["Precnik"] . "</td>";
                        echo "<td>" . $row["Zastita"] . "</td>";
                        echo "<td>" . $row["KomadiIzSipke"] . "</td>";
                        echo "<td>" . $row["MeraProizvodaGrami"] . "</td>";
                        echo "<td><button class='dugme2' onclick='showDeleteConfirmation3(" . $row['Sifra'] . ")'>Obriši</button></td>";
                        echo "<td><button class='dugme2' onclick='editPart(" . $row['Sifra'] . ")'>Izmeni</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Nema podataka u tabeli.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        // Funkcija za otvaranje lightbox-a i postavljanje slike
        function openLightbox(imagePath) {
            var lightbox = document.getElementById('lightbox');
            var lightboxImg = document.getElementById('lightbox-img');
            var body = document.body;

            lightboxImg.src = imagePath;
            lightbox.style.display = 'flex'; // Postavljanje prikaza na flex
            body.style.overflow = 'hidden'; // Sprečavanje skrolovanja
        }

        // Funkcija za zatvaranje lightbox-a
        function closeLightbox() {
            var lightbox = document.getElementById('lightbox');
            var body = document.body;

            lightbox.style.display = 'none';
            body.style.overflow = 'auto'; // Vratite skrolovanje
        }

        function showDeleteConfirmation3(Sifra) {
            if (confirm("Are you sure you want to delete this part?")) {
                // If user confirms deletion, make an AJAX request to delete the order
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // If deletion is successful, reload the page to reflect changes
                        location.reload();
                    }
                };
                xhttp.open("GET", "delete_part.php?Sifra=" + Sifra, true);
                xhttp.send();
            }
        }

        function editPart(sifra) {
            window.location.href = 'edit_part.php?edit=' + sifra;
        }

    </script>

    <div id="lightbox" class="lightbox">
        <span class="close-btn" onclick="closeLightbox()">&times;</span>
        <div class="lightbox-content">
            <img id="lightbox-img" src="" alt="bigger image">
        </div>
    </div>



</body>
</html>