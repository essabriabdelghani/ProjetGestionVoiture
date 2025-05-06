<?php
// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "gestion_voitures");
if ($mysqli->connect_error) {
    file_put_contents("cron_error.log", date("[Y-m-d H:i:s]") . " - Erreur DB: " . $mysqli->connect_error . "\n", FILE_APPEND);
    exit;
} 

// Libérer les voitures dont la date de fin est dépassée
$query = "UPDATE voitures_marque 
          SET reserver = 0, date_fin_reservation = NULL 
          WHERE date_fin_reservation < NOW()";
$result = $mysqli->query($query);

// Journalisation
file_put_contents("cron.log", date("[Y-m-d H:i:s]") . " - Voitures libérées: " . $mysqli->affected_rows . "\n", FILE_APPEND);

$mysqli->close();
?>