<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'gestion_voitures';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo 
    die("Erreur de connexion : " . $conn->connect_error);
}
?>
