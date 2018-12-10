<?php

include_once("init.php");
require('PDF.php');

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

if (empty($_GET['id'])) {
    header("Location: dashboard.php");
    die();
}

$id = steralizeString($_GET['id']);

$sql = "SELECT * FROM revisions WHERE runbookID = " . $id . " ORDER BY revisionID DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Invalid ID
    header("Location: dashboard.php");
    die();
}

$Parsedown = new Parsedown();

// Instanciation of inherited class
$pdf = new PDF_HTML();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->WriteHTML($Parsedown->text($row['data']));
$pdf->Output();
