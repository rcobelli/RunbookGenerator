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

$sql = "SELECT * FROM revisions WHERE runbookID = " . $id . " ORDER BY revisionID DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Invalid ID
    header("Location: runbook.php");
    die();
}


echo 'Revision: ' . $row['revisionID'] . " (" . $row['timestamp'] . " - " . $row['changelog'] . ")</br>";
echo '<a href="dashboard.php">Back to Dashboard</a> | <a href="edit.php?id=' . $id . '">New Revision</a> | <a href="download.php?id=' . $id . '">Download PDF</a> | Revert</br><hr/>';

$Parsedown = new Parsedown();
echo $Parsedown->text($row['data']);
