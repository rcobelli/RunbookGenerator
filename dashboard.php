<?php

include_once("init.php");

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

?>
<html lang="en">
<head>
    <title>Runbook Generator | Dashboard</title>
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
    <script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
    </script>
    <style>
    .clickable-row {
        cursor: pointer;
    }
    </style>
</head>
<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="logout.php">Logout</a></li>
        </ol>
    </nav>

    <div class="container">

        <?php
        if ($_GET['status'] == 'error') {
            if ($_GET['message'] == 'invalid_id') {
                ?>
                <div class="alert alert-danger" role="alert">
                    Invalid runbook id
                </div>
                <?php
            }
        } elseif ($_GET['status'] == 'success') {
            if ($_GET['message'] == 'create') {
                ?>
                <div class="alert alert-success" role="alert">
                    Successfully created runbook
                </div>
                <?php
            } elseif ($_GET['message'] == 'delete') {
                ?>
                <div class="alert alert-success" role="alert">
                    Successfully deleted runbook
                </div>
                <?php
            }
        }
        ?>

        <h1>Runbooks</h1>
        <?php
        $sql = "SELECT * FROM runbooks WHERE user = '" . steralizeString($_SESSION['email']) . "' ORDER BY title";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            ?>
            <table class="table table-hover">
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr class="clickable-row" data-href="runbook.php?id=' . $row['id'] . '"><td>' . $row['title'] . "</td></tr>";
                    } ?>
                </tbody>
            </table>
            <?php
        } else {
            echo 'No runbooks found';
        }
        ?>
        <a href="new.php"><button type="button" class="btn btn-primary">New Runbook</button></a>
    </div>
</body>
</html>
