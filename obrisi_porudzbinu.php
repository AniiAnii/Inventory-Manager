<?php
// Ukoliko nije prosleđen ID porudžbine, preusmeri na početnu stranicu
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Spajanje na bazu podataka
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "praksaa";

$conn = new mysqli($hostname, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Neuspješna konekcija: " . $conn->connect_error);
}

// Priprema SQL upita za brisanje porudžbine sa odgovarajućim ID-jem
$sql = "DELETE FROM Porudzbine WHERE PorudzbinaID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['id']);

// Izvršavanje SQL upita za brisanje porudžbine
if ($stmt->execute()) {
    echo "Porudžbina je uspešno obrisana.";
    // JavaScript kod za preusmeravanje nakon 2 sekunde
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 2000);</script>";
} else {
    echo "Greška prilikom brisanja porudžbine: " . $stmt->error;
}

// Zatvaranje konekcije i izlaz iz skripte
$stmt->close();
$conn->close();
