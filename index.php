<!DOCTYPE html>
<html>

<head>
    <title>Unos novog dela</title>
    <style>
        /* Stilizacija linka kao dugmeta */
        .dugme {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ccc;
            /* Siva boja */
            color: #fff;
            /* Bijela boja teksta */
            text-decoration: none;
            /* Uklanja podvučen link */
            border-radius: 5px;
            /* Zaobljeni rubovi */
            transition: background-color 0.3s;
            /* Glatka promjena boje */
        }

        .dugme:hover {
            background-color: #999;
            /* Siva boja na hover */
        }

        /* CSS za stilizaciju modalnog dijaloga */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 2px solid #333;
            border-radius: 10px;
            width: 80%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: darkred;
        }
    </style>
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

    <h2>Unos novog dela</h2>

    <h2>Porudžbine</h2>

    <form method="get" action="dodaj_porudzbinu.php">
        <input type="submit" value="Dodaj porudžbinu" class="dugme">
    </form>

    <div style="height: 20px;"></div>

    <?php
    // Spajanje na bazu podataka
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "praksaa"; // Proverite da li je ovo ispravno ime baze podataka

    // Provjera konekcije
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Neuspješna konekcija: " . $conn->connect_error);
    }

    // Dohvatanje porudžbina iz baze podataka
    $sql = "SELECT * FROM Porudzbine";
    $result = $conn->query($sql);

    // Prikazivanje porudžbina u obliku tabele
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                    <th>Datum Za Termičku</th>
                    <th>Vrsta Termičke Obrade</th>
                    <th>Datum Isporuke Delova</th>
                    <th>Količina</th>
                    <th>Gr Potrebnih Sipki</th>
                    <th>Akcija</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["DatumZaTermicku"] . "</td>";
            echo "<td>" . $row["VrstaTermickeObrade"] . "</td>";
            echo "<td>" . $row["DatumIsporukeDelova"] . "</td>";
            echo "<td>" . $row["Kolicina"] . "</td>";
            echo "<td>" . $row["GrPotrebnihSipki"] . "</td>";
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
