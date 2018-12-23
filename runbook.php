<?php

include_once("init.php");

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

if (empty($_GET['id'])) {
    header("Location: dashboard.php?status=error&message=invalid_id");
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

?>
<html>
<head>
    <title>Runbook Generator | <?php echo $title; ?></title>
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
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
        </ol>
    </nav>

    <div class="container">
        <div class="float-right">
            <h4 title="<?php echo $row['changelog']; ?>" class="text-right">Revision <?php echo $row['revisionID']; ?></h4>

            <a href="download.php?id=<?php echo $id; ?>&rev=<?php echo $rev; ?>"><button type="button" class="btn btn-primary">Download PDF</button></a>
            <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#manageRevisions" aria-expanded="false" aria-controls="collapseExample">
                Manage Revisions
            </button>
        </div>
        <h1><?php echo $title; ?></h1>
        <?php
        if (isset($_GET['rev'])) {
            echo $row['changelog'];
        }
        ?>
        <br clear="all"/>
        <div class="collapse mt-2" id="manageRevisions">
            <div class="card card-body">
                <?php
                    $sql = "SELECT * FROM revisions WHERE runbookID = " . $id . " ORDER BY revisionID";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        ?>
                        <h5>Prior Revisions</h5>
                        <table class="table table-hover">
                            <tbody>
                                <?php
                                while ($row2 = $result->fetch_assoc()) {
                                    if ($row2['revisionID'] == $rev) {
                                        echo '<tr class="table-primary"';
                                    } else {
                                        echo '<tr class="clickable-row"';
                                    }
                                    echo ' data-href="runbook.php?id=' . $row2['runbookID'] . '&rev=' . $row2['revisionID'] . '"><td>' . $row2['timestamp'] . " - " . $row2['changelog'] . "</td></tr>";
                                } ?>
                            </tbody>
                        </table>
                        <a href="edit.php?id=<?php echo $id; ?>"><button type="button" class="btn btn-primary">New Revision</button></a>
                        <?php
                    }
                ?>


            </div>
        </div>
        <hr/>
        <div class="bg-light p-3">
            <?php
            $Parsedown = new Parsedown();
            echo $Parsedown->text($row['data']);
            ?>
        </div>
    </div>
</body>
</html>
