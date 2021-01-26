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

if ($_POST['submit']) {
    $email = steralizeString($_SESSION['email']);
    $runbookID = steralizeString($_POST['runbookID']);
    $revisionID = steralizeString($_POST['revisionID']);
    $data = steralizeString($_POST['data']);
    $changelog = steralizeString($_POST['changelog']);


    $sql = "INSERT INTO revisions (runbookID, revisionID, timestamp, data, changelog) VALUES ($runbookID, ($revisionID + 1), NOW(), '$data', '$changelog')";
    if ($conn->query($sql) === true) {
        header("Location: runbook.php?id=" . $runbookID);
        die();
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $conn->error; ?>
        </div>
        <?php
        die();
    }
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

$sql = "SELECT * FROM revisions WHERE runbookID = " . $id . " ORDER BY revisionID DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Invalid ID
    header("Location: dashboard.php");
    die();
}

?>
<html lang="en">
<head>
    <title>Runbook Generator | Edit Runbook</title>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="shortcut icon" href="favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="msapplication-config" content="favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
        </ol>
    </nav>

    <div class="container">
        <h1>Edit <?php echo $title; ?></h1>

        <form method="post">
            <div class="form-group">
                <label>Content<small> (Markdown Format)</small>:</label><textarea name="data" required class="form-control" style="height: 300px"><?php echo $row['data']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Change Log:</label><input type="text" name="changelog" required class="form-control">
            </div>
            <input type="hidden" value="<?php echo $row['revisionID']; ?>" name="revisionID">
            <input type="hidden" value="<?php echo $row['runbookID']; ?>" name="runbookID">
            <input type="hidden" name="submit" value="true">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <a href="https://guides.github.com/pdfs/markdown-cheatsheet-online.pdf" target="_blank">Markdown Cheat Sheet</a>
    </div>
</body>
</html>
