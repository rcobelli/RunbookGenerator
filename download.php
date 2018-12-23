<?php

include_once("init.php");

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

if (empty($_GET['id'])) {
    header("Location: dashboard.php");
    die();
}

$id = steralizeString($_GET['id']);

$sql = "SELECT * FROM runbooks WHERE id = " . $id . " LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
} else {
    // Invalid ID
    header("Location: dashboard.php?status=error&message=invalid_id");
    die();
}

if (isset($_GET['rev'])) {
    $rev = steralizeString($_GET['rev']);

    $sql = "SELECT * FROM revisions WHERE runbookID = " . $id . " AND revisionID = " . $rev;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Invalid ID
        header("Location: dashboard.php?status=error&message=invalid_id");
        die();
    }
} else {
    $sql = "SELECT * FROM revisions WHERE runbookID = " . $id . " ORDER BY revisionID DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_GET['rev'] = $row['revisionID'];
        $rev = $row['revisionID'];
    } else {
        // Invalid ID
        header("Location: dashboard.php?status=error&message=invalid_id");
        die();
    }
}

$Parsedown = new Parsedown();

// Instanciation of inherited class
$pdf = new PDF_HTML('P', 'mm', 'Letter', $row['revisionID'], $title);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->WriteHTML($Parsedown->text($row['data']));
$pdf->Output();
