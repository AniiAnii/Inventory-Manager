<!DOCTYPE html>
<html>

<head>
    <title>Unos novog dela</title>
    <link rel="stylesheet" type="text/css" href="styles/add_order.css">

</head>

<body class=" body">



    <div class="container">
        <h2 class="heading">Unos novog dela</h2>

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
                $imageFileType != "jpg" && $imageFileType != "pdf" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Sorry, only PDF, JPG, JPEG, PNG & GIF files are allowed.";
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


            $sql = "INSERT INTO delovi (Sifra, Naziv, VrstaMaterijala, Precnik, Zastita, KomadiIzSipke, MeraProizvodaGrami, PicturePath)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss",  $_POST['sifra'], $_POST['naziv'], $_POST['vrsta_materijala'], $_POST['precnik'], $_POST['zastita'], $_POST['komadi_iz_sipke'], $_POST['mera_proizvoda_grami'], $picturePath);

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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" class="form">
            <div class="form-group">
                <label for="sifra" class="label">Sifra:</label>
                <input type="text" id="sifra" name="sifra" class="input">
            </div>

            <div class="form-group">
                <label for="naziv" class="label">Naziv:</label>
                <input type="text" id="naziv" name="naziv" class="input">
            </div>

            <div class="form-group">
                <label for="vrsta_materijala" class="label">Vrsta Materijala:</label>
                <input type="text" id="vrsta_materijala" name="vrsta_materijala" class="input">
            </div>

            <div class="form-group">
                <label for="precnik" class="label">Precnik Materijala:</label>
                <input type="text" id="precnik" name="precnik" class="input">
            </div>

            <div class="form-group">
                <label for="zastita" class="label">Mesto bavljenja povrsinske Zastita:</label>
                <input type="text" id="zastita" name="zastita" class="input">
            </div>

            <div class="form-group">
                <label for="komadi_iz_sipke" class="label">Komadi iz sipke:</label>
                <input type="text" id="komadi_iz_sipke" name="komadi_iz_sipke" class="input">
            </div>

            <div class="form-group">
                <label for="mera_proizvoda_grami" class="label">Mera proizvoda u gramima:</label>
                <input type="text" id="mera_proizvoda_grami" name="mera_proizvoda_grami" class="input">
            </div>

            <div class="form-group">
                <label for="picture" class="label">Picture:</label>
                <input type="file" id="picture" name="picture" accept="image/*" class="form-control-file">
            </div>

            <input type="submit" name="submit" value="Submit" class="btn">
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

    </div>

</body>

</html>