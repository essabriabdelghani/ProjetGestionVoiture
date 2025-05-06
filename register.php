<?php
include 'connexion.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

$sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe)
        VALUES ('$nom', '$prenom', '$email', '$mot_de_passe')";

if ($conn->query($sql)) {
    header("Location: index.html?inscription=ok");
} else {
    echo "Erreur : " . $conn->error;
}
?>
