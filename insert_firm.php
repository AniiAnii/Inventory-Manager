<?php
include 'connection.php'; 

// Generate a random firmId
$firmId = rand(1, 92233720368547758); // Example: Generates a random number between 1000 and 9999

// Get the firm name from the form
$firmName = $_POST['firm_name'];

// Insert the data into the database
$sql = "INSERT INTO firm (firmId, name) VALUES ('$firmId', '$firmName')";

if ($conn->query($sql) === TRUE) {
    echo "New firm registered successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
