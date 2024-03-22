<!DOCTYPE html>
<html>

<head>
    <title>Unos novog dela</title>
</head>

<body>

    <div style="text-align: right;">
        <a href="unos_novog_dela.php">Unos novog dela</a>
    </div>

    <h2>Unos novog dela</h2>

    <?php
    // Initialize an empty array to store errors
    $errors = array();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'connection.php';

        // Handle file upload
        $targetDirectory = "uploads/"; // Directory where uploaded files will be stored
        $targetFile = $targetDirectory . basename($_FILES["picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["picture"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["picture"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFile)) {
                echo "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // After successfully uploading the file, store the file path or name in the database
        $picturePath = $targetFile;


        $sql = "INSERT INTO delovi (RedniBroj, Sifra, Naziv, VrstaMaterijala, Zastita, KomadiIzSipke, MeraProizvodaGrami, PicturePath)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $_POST['redni_broj'], $_POST['sifra'], $_POST['naziv'], $_POST['vrsta_materijala'], $_POST['zastita'], $_POST['komadi_iz_sipke'], $_POST['mera_proizvoda_grami'], $picturePath);

        // Execute prepared SQL statement
        if ($stmt->execute() === TRUE) {
            echo "Novi zapis je uspješno dodan.";
        } else {
            $errors[] = "Greška prilikom dodavanja zapisa: " . $conn->error;
        }

        // Close statement
        $stmt->close();
        // Close connection
        $conn->close();
    }
    ?>

    <!-- Form for adding a new part -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="sifra">Sifra:</label>
        <input type="text" id="sifra" name="sifra"><br><br>

        <label for="naziv">Naziv:</label>
        <input type="text" id="naziv" name="naziv"><br><br>

        <label for="vrsta_materijala">Vrsta Materijala:</label>
        <input type="text" id="vrsta_materijala" name="vrsta_materijala"><br><br>

        <label for="redni_broj">Precnik Materijala:</label>
        <input type="text" id="redni_broj" name="redni_broj"><br><br>

        <label for="zastita">Mesto bavljenja povrsinske Zastita:</label>
        <input type="text" id="zastita" name="zastita"><br><br>

        <label for="komadi_iz_sipke">Komadi iz sipke:</label>
        <input type="text" id="komadi_iz_sipke" name="komadi_iz_sipke"><br><br>

        <label for="mera_proizvoda_grami">Mera proizvoda u gramima:</label>
        <input type="text" id="mera_proizvoda_grami" name="mera_proizvoda_grami"><br><br>

        <label for="picture">Picture:</label>
        <input type="file" id="picture" name="picture" accept="image/*">


        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    // Display errors, if any
    if (!empty($errors)) {
        echo "<h3>Errors:</h3>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
    ?>

</body>

</html>