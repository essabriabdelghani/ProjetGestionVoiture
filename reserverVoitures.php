<?php
$conn = new mysqli("localhost", "root", "", "gestion_voitures");

$data = json_decode(file_get_contents("php://input"), true);
$immatriculation = $conn->real_escape_string($data["immatriculation"]);

$conn->query("UPDATE voitures_marque SET reserver = 1 WHERE immatriculation = '$immatriculation'");
echo "Réservation réussie";
?>
