<?php
include("connexion2.php");

$input = json_decode(file_get_contents("php://input"), true);

if ($input) {
    $immat = $conn->real_escape_string($input["immatriculation"]);
    $marque = $conn->real_escape_string($input["marque"]);
    $couleur = $conn->real_escape_string($input["couleur"]);
    $carburant = $conn->real_escape_string($input["carburant"]);
    $prix = intval($input["prix_jour"]);

    $sql = "INSERT INTO voitures_marque (immatriculation, marque, couleur, carburant, prix_jour)
            VALUES ('$immat', '$marque', '$couleur', '$carburant', $prix)";

    if ($conn->query($sql) === TRUE) {
        echo "Voiture ajoutée avec succès.";
    } else {
        echo "Erreur : " . $conn->error;
    }
} else {
    echo "Données invalides.";
}

$conn->close();
?>
