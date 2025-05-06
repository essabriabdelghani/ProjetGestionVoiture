<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Connexion à la base de données
$mysqli = new mysqli("localhost", "root", "", "gestion_voitures");
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données']);
    exit;
}

// Fonction pour valider les données
function validateInput($data) {
    $errors = [];
    if (empty($data['immatriculation'])) $errors[] = "Immatriculation manquante";
    if (empty($data['nom'])) $errors[] = "Nom manquant";
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (empty($data['cin'])) $errors[] = "CIN manquant";
    if (empty($data['date_debut'])) $errors[] = "Date de début manquante";
    if (!is_numeric($data['duree']) || $data['duree'] < 1) $errors[] = "Durée invalide";
    return $errors;
}

try {
    // Récupération des données
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        throw new Exception("Données JSON invalides");
    }

    // Validation
    $errors = validateInput($input);
    if (!empty($errors)) {
        throw new Exception(implode(", ", $errors));
    }

    // Vérifier disponibilité voiture
    $stmt = $mysqli->prepare("SELECT prix_jour FROM voitures_marque WHERE immatriculation = ? AND reserver = 0");
    $stmt->bind_param('s', $input['immatriculation']);
    $stmt->execute();
    $result = $stmt->get_result();
    $voiture = $result->fetch_assoc();

    if (!$voiture) {
        throw new Exception("Voiture non disponible");
    }

    // Calculs
    $dateFin = date('Y-m-d', strtotime($input['date_debut'] . " + {$input['duree']} days"));
    $prixTotal = $voiture['prix_jour'] * $input['duree'];

    // Transaction
    $mysqli->begin_transaction();

    // Insertion réservation
    $stmt = $mysqli->prepare("INSERT INTO reservationVoitures (immatriculation, nom, email, cin, date_debut, date_fin, duree, prix_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssid', 
        $input['immatriculation'],
        $input['nom'],
        $input['email'],
        $input['cin'],
        $input['date_debut'],
        $dateFin,
        $input['duree'],
        $prixTotal
    );
    $stmt->execute();

    // Mise à jour voiture
    $stmt = $mysqli->prepare("UPDATE voitures_marque SET reserver = 1 WHERE immatriculation = ?");
    $stmt->bind_param('s', $input['immatriculation']);
    $stmt->execute();

    $mysqli->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Réservation confirmée',
        'data' => [
            'reservation_id' => $mysqli->insert_id,
            'prix_total' => $prixTotal,
            'date_fin' => $dateFin
        ]
    ]);

} catch (Exception $e) {
    $mysqli->rollback();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    $mysqli->close();
}
?>