<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // Utilisateur connecté → rediriger vers la page des voitures
    header("Location: voitures.html");
    exit();
} else {
    // Non connecté → rediriger vers login
    echo "<script>
        alert('Veuillez vous connecter pour accéder à la réservation.');
        window.location.href = 'register.html';
    </script>";
    exit();
}
?>
