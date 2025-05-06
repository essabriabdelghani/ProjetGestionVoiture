<?php
header('Content-Type: application/json');

$mysqli = new mysqli("localhost", "root", "", "gestion_voitures");
if ($mysqli->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $mysqli->connect_error]));
}

// Mettre à jour les voitures dont la réservation est expirée
$mysqli->query("UPDATE voitures_marque SET reserver = 0 WHERE date_fin_reservation < NOW()");

$result = $mysqli->query("SELECT * FROM voitures_marque");
$voitures = [];

while ($row = $result->fetch_assoc()) {
    $voitures[] = $row;
}

echo json_encode($voitures);
$mysqli->close();
?>