<?php

include_once("init.php");

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

?>
<html>
<head>
    <title>Runbook Generator | Dashboard</title>
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
    <?php
    if ($_GET['status'] == 'error') {
        if ($_GET['message'] == 'invalid_id') {
            ?>
            <div class="alert alert-danger" role="alert">
                Invalid runbook id
            </div>
            <?php
        }
    }
    ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="logout.php">Logout</a></li>
        </ol>
    </nav>

    <div class="container">
        <h1>Runbooks</h1>
        <?php
        $sql = "SELECT * FROM runbooks WHERE user = '" . steralizeString($_SESSION['email']) . "'";
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
