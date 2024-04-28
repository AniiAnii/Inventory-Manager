<?php
include '../connection.php';

// Initialize success message variable
$successMessage = "";

// Check if the form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if PorudzbinaID is set in the POST data
    if(isset($_POST['PorudzbinaID'])) {
        // Get the PorudzbinaID from the POST data
        $porudzbinaID = $_POST['PorudzbinaID'];

        // Collect updated order details from the form
        $nazivDela = $_POST['nazivDela'];
        $sifraDela = $_POST['sifraDela'];
        $DatumZaPovrsinskuZastitu = $_POST['DatumZaPovrsinskuZastitu'];
        $DatumZaTermickuObradu = $_POST['DatumZaTermickuObradu'];
        $DatumIsporukeDelova = $_POST['DatumIsporukeDelova'];
        $Kolicina = $_POST['Kolicina'];

        
        $sql = "UPDATE porudzbine SET 
                NazivDela = '$nazivDela', 
                SifraDela = '$sifraDela', 
                DatumZaPovrsinskuZastitu = '$DatumZaPovrsinskuZastitu', 
                DatumZaTermickuObradu = '$DatumZaTermickuObradu', 
                DatumIsporukeDelova = '$DatumIsporukeDelova', 
                Kolicina = '$Kolicina' 
                WHERE PorudzbinaID = $porudzbinaID";

        if ($conn->query($sql) === TRUE) {
            // Set success message
            $successMessage = "Uspesno izmenjeno";
        } else {
            // Error message
            echo "Error updating order details: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "PorudzbinaID is not set in the form data.";
    }
} else {
    header("Location: edit_order.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Porudzbina</title>
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
</head>
<body>
    <h3 style="margin-left: 20px;">Izmene Porudzbina</h3>

    <!-- Display success message if set -->
    <?php if (!empty($successMessage)): ?>
    <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 10px;">
        <?php echo $successMessage; ?>
    </div>
    <?php endif; ?>

</body>
</html>
