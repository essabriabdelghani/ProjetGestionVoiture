<?php
session_start();
include 'connexion.php';

$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

$sql = "SELECT * FROM utilisateurs WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user'] = $user;
        header("Location: voitures.html");
        exit;
    } else {
        header("Location: index.html?erreur=motdepasse");
        exit;
    }
} else {
    header("Location: index.html?erreur=email");
    exit;
}
?>
