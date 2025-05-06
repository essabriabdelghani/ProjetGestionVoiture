<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Chargement de Composer (chemin absolu)
require __DIR__ . '/vendor/autoload.php';

// 2. Validation des données
$nom = htmlspecialchars($_POST['nom'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
if (empty($nom) || empty($email)) {
    die("Nom et email sont obligatoires !");
}

// 3. Connexion MySQL (avec gestion d'erreur)
$conn = new mysqli('localhost', 'root', '', 'gestion_voitures');
if ($conn->connect_error) {
    die("Erreur DB: " . $conn->connect_error);
}

// 4. Insertion en base
$stmt = $conn->prepare("INSERT INTO messages (...) VALUES (?, ?, ?, ?, ?)");
// ... (votre code existant)

// 5. Envoi du mail
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'essabriabdelghani28@gmail.com';
    $mail->Password = 'votre_app_password'; // 🔒 Mot de passe d'application
    // ... (votre code existant)
} catch (Exception $e) {
    error_log("Erreur mail: " . $e->getMessage()); // Log technique
    die("Désolé, l'envoi a échoué. Contactez l'administrateur.");
}

$conn->close();
echo "Message envoyé avec succès !";
?>