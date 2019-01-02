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

$sql = "DELETE FROM runbooks WHERE id = $id";
$sql2 = "DELETE FROM revisions WHERE runbookID = $id";
if ($conn->query($sql) === true && $conn->query($sql2) === true) {
    header("Location: dashboard.php?status=success&message=delete");
    die();
} else {
    ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $conn->error; ?>
    </div>
    <?php
    die();
}
