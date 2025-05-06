<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "root", "", "gestion_voitures");
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erreur DB']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    echo json_encode(['success' => false, 'message' => 'JSON invalide']);
    exit;
}

// Validations
$errors = [];
if (empty($input['nom'])) $errors[] = 'Nom requis';
if (empty($input['email']) || !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide';
if (empty($input['cin'])) $errors[] = 'CIN requis';
if (empty($input['date_debut'])) $errors[] = 'Date requise';
if (!is_numeric($input['duree']) || $input['duree'] < 1) $errors[] = 'Durée invalide';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// Vérif voiture
$stmt = $mysqli->prepare("SELECT prix_jour FROM voitures_marque WHERE immatriculation = ? AND (reserver = 0 OR date_fin_reservation < NOW())");
$stmt->bind_param('s', $input['immatriculation']);
$stmt->execute();
$res = $stmt->get_result();
$voiture = $res->fetch_assoc();

if (!$voiture) {
    echo json_encode(['success' => false, 'message' => 'Voiture non dispo']);
    exit;
}

$dateFin = date('Y-m-d', strtotime($input['date_debut'] . " + {$input['duree']} days"));
$prixTotal = $voiture['prix_jour'] * $input['duree'];

$mysqli->begin_transaction();

// Insertion réservation
$stmt = $mysqli->prepare("INSERT INTO reservationVoitures (immatriculation, nom, email, cin, date_debut, date_fin, duree, prix_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssd", $input['immatriculation'], $input['nom'], $input['email'], $input['cin'], $input['date_debut'], $dateFin, $input['duree'], $prixTotal);
$stmt->execute();

// Mise à jour voiture
$stmt = $mysqli->prepare("UPDATE voitures_marque SET reserver = 1, date_fin_reservation = ? WHERE immatriculation = ?");
$stmt->bind_param('ss', $dateFin, $input['immatriculation']);
$stmt->execute();

$mysqli->commit();

// Stocker en session pour recu.php
$_SESSION['reservationComplet'] = [
    'nom' => $input['nom'],
    'email' => $input['email'],
    'cin' => $input['cin'],
    'immatriculation' => $input['immatriculation'],
    'date_debut' => $input['date_debut'],
    'date_fin' => $dateFin,
    'prix_total' => $prixTotal
];

echo json_encode(['success' => true]);
?>
