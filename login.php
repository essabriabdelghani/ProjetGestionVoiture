<?php
session_start();
include 'connexion.php';

$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

// Requête pour récupérer l'utilisateur
$sql = "SELECT * FROM utilisateurs WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Connexion réussie : stocker l'utilisateur en session
        $_SESSION['user'] = $user;
        $_SESSION['email_utilisateur'] = $user['email']; // stocker email

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
