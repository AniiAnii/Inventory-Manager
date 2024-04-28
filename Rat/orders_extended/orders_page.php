<?php
include '../connection.php';
?>

<script>
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
                xhttp.open("GET", "../delete_order.php?orderId=" + orderId, true);
                xhttp.send();
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
    
    function toggleTable1() {
        var table1 = document.getElementById("table1");

        if (table1.style.display === "none") {
            table1.style.display = "block";
        } else {
            table1.style.display = "none";
        }
    }


    function toggleTable2() {
        var table2 = document.getElementById("table2");

        if (table2.style.display === "none") {
            table2.style.display = "block";
        } else {
            table2.style.display = "none";
        }
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Porudzbine</h1>

    <div class="button-container">
        <form method="get" action="dodaj_porudzbinu.php">
            <input type="submit" value="Dodaj porudžbinu" class="dugme">
        </form>
        <button class="dugme" onclick="toggleTable2()">Prikaži poslate narudzbine</button>
        <button class="dugme" onclick="toggleTable1()">Prikaži porucene narudzbine</button>
    </div>

    <div style="height: 20px;"></div>
        <div class="underlay">
            <div class="table-wrapper" id="table1">
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
                    <th>Izmeni</th>
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
                                echo "<td>" . $row["status"] . "</td>";
                                echo "<td><button class='dugme2' onclick='showDeleteConfirmation2(" . $row['PorudzbinaID'] . ")'>Obriši</button></td>";
                                echo "<td><button class='dugme2' onclick='prihvatiPorudzbinu(" . $row['PorudzbinaID'] . ")'>Gotovo</button></td>";
                                echo "<td><button class='dugme2' onclick='editOrder(" . $row['PorudzbinaID'] . ")'>Izmeni</button></td>";
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
            </div>
        </div>

        <div style="height: 20px;"></div>
        <div class="underlay">
            <div class="table-wrapper" id="table2" style="display: none;">
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
                    <th>Izmeni</th>
                </tr>";

                        while ($row = $result->fetch_assoc()) {
                            if ($row["status"] == "poslat") {
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
                                echo "<td><button class='dugme2' onclick='showDeleteConfirmation2(" . $row['PorudzbinaID'] . ")'>Obriši</button></td>";
                                echo "<td><button class='dugme2' onclick='prihvatiPorudzbinu(" . $row['PorudzbinaID'] . ")'>Gotovo</button></td>";
                                echo "<td><button class='dugme2' onclick='editOrder(" . $row['PorudzbinaID'] . ")'>Izmeni</button></td>";
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
            </div>
        </div>

    <script>
        // Function to edit a specific order
        function editOrder(PorudzbinaID) {
            // You can implement the logic to redirect to the edit page with the order ID
            // For example:
            window.location.href = "edit_order.php?PorudzbinaID=" + PorudzbinaID;
        }
    </script>
</body>
</html>
