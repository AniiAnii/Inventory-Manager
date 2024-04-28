<?php
include 'connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input and sanitize data
    $partId = $_POST['partId'];
    $sifra = $_POST['Sifra'];
    $naziv = $_POST['Naziv'];
    $vrstaMaterijala = $_POST['VrstaMaterijala']; 
    $zastita = $_POST['Zastita']; 
    $komadiIzSipke = $_POST['KomadiIzSipke']; 
    $meraProizvodaGrami = $_POST['MeraProizvodaGrami']; 

    // Prepare SQL statement to update part information
    $sql = "UPDATE delovi SET Sifra = ?, Naziv = ?, VrstaMaterijala = ?, Zastita = ?, KomadiIzSipke = ?, MeraProizvodaGrami = ? WHERE Sifra = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisi", $sifra, $naziv, $vrstaMaterijala, $zastita, $komadiIzSipke, $meraProizvodaGrami, $partId);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the page where part information was edited
        header("Location: index.php"); // Change index.php to the appropriate page
        exit();
    } else {
        echo "Error updating part: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
