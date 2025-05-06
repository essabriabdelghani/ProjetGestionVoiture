<?php
$conn = new mysqli("localhost", "root", "", "gestion_voitures");
$result = $conn->query("SELECT * FROM voitures_marque");

$voitures_marque = [];

while ($row = $result->fetch_assoc()) {
  $voitures_marque[] = $row;
}

echo json_encode($voitures_marque);
?>


