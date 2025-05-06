<?php
session_start();

if (!isset($_SESSION['reservationComplet'])) {
    header("Location: index.html");
    exit;
}

$data = $_SESSION['reservationComplet'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Reçu de Réservation</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f4f4f4; }
    .recu { background: white; padding: 20px; border-radius: 10px; width: 500px; margin: auto; }
    .recu h2 { text-align: center; }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover { background: #0056b3; }
  </style>
</head>
<body>
  <div class="recu" id="recu">
    <h2>Reçu de Réservation</h2>
    <p><strong>Nom complet :</strong> <?= $data['nom']  ?></p>
    <p><strong>Email :</strong> <?= $data['email'] ?></p>
    <p><strong>Immatriculation :</strong> <?= $data['immatriculation'] ?></p>
    <p><strong>Date début :</strong> <?= $data['date_debut'] ?></p>
    <p><strong>Date fin :</strong> <?= $data['date_fin'] ?></p>
    <p><strong>Prix total :</strong> <?= $data['prix_total'] ?> MAD</p>

    <button onclick="telechargerRecu()">📥 Télécharger le reçu</button>
  </div>

  <script>
    function telechargerRecu() {
      const contenu = document.getElementById("recu").innerHTML;
      const fenetre = window.open("", "", "width=800,height=600");
      fenetre.document.write("<html><head><title>Reçu</title></head><body>");
      fenetre.document.write(contenu);
      fenetre.document.write("</body></html>");
      fenetre.document.close();
      fenetre.print(); // Lance la boîte de dialogue d'impression
    }
  </script>
</body>
</html>
