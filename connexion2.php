<?php
$conn = new mysqli("localhost", "root", "", "gestion_voitures");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}


?>
