<?php
require('fpdf.php');
session_start();

$res = $_SESSION['reservation'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Recu de Reservation');
$pdf->Ln(20);
$pdf->SetFont('Arial','',12);

$pdf->Cell(0,10,'Nom complet : ' . $res['nom'] . ' ' . $res['prenom'],0,1);
$pdf->Cell(0,10,'Email : ' . $res['email'],0,1);
$pdf->Cell(0,10,'Immatriculation : ' . $res['immatriculation'],0,1);
$pdf->Cell(0,10,'Date debut : ' . $res['date_debut'],0,1);
$pdf->Cell(0,10,'Date fin : ' . $res['date_fin'],0,1);
$pdf->Cell(0,10,'Prix : ' . $res['prix'] . ' DH',0,1);

$pdf->Output('D', 'recu_reservation.pdf'); // 'D' = téléchargement direct
exit;
?>
