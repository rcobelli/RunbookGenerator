<?php

include_once("init.php");

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

if ($_POST['submit']) {
    $email = steralizeString($_SESSION['email']);
    $title = steralizeString($_POST['title']);
    $data = steralizeString($_POST['data']);


    $sql = "INSERT INTO runbooks (user, title) VALUES ('$email', '$title')";
    if ($conn->query($sql) === true) {
        $last_id = $conn->insert_id;
        $sql = "INSERT INTO revisions (runbookID, revisionID, timestamp, data, changelog) VALUES ($last_id, 1, NOW(), '$data', 'Initial entry')";
        if ($conn->query($sql) === true) {
            header("Location: dashboard.php?status=success");
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $conn->error; ?>
            </div>
            <?php
            die();
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $conn->error; ?>
        </div>
        <?php
        die();
    }
}

?>
<html>
<head>
    <title>Runbook Generator | New Runbook</title>
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
            <li class="breadcrumb-item active" aria-current="page">Create New</li>
        </ol>
    </nav>

    <div class="container">
        <h1>Create New Runbook</h1>

        <form method="post">
            <div class="form-group">
                <label>Title:</label><input name="title" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Content<small> (Markdown Format)</small>:</label><textarea name="data" class="form-control" style="height: 300px" required></textarea>
            </div>
            <input type="hidden" name="submit" value="true">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <a href="https://guides.github.com/pdfs/markdown-cheatsheet-online.pdf" target="_blank">Markdown Cheatsheet</a>
    </div>
</body>
</html>
