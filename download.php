<?php

include_once("init.php");

// if (empty($_SESSION['email'])) {
//     header("Location: index.php");
//     die();
// }

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

$parser = new \cebe\markdown\GithubMarkdown();


echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';
echo '<h1 class="text-center">' . $title . ' Runbook</h1>';
echo $parser->parse($row['data']);
echo '<br clear="all"/>';
echo '<i><span style="float: right;">Revision ' . $row['revisionID'] . '</span>';
echo 'Created with Runbook Generator</i>';
echo '<script>alert ("Select \'Print to PDF\' from the printer dialog");window.print();</script>';
