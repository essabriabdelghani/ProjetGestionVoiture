<?php
include("connexion2.php");

if (isset($_GET['immatriculation'])) {
    $immatriculation = $conn->real_escape_string($_GET['immatriculation']);
    $sql = "DELETE FROM voitures_marque WHERE immatriculation = '$immatriculation'";
    $conn->query($sql);
}

$conn->close();
?>

