<?php

include_once("init.php");

if (empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

echo '<a href="new.php">New Runbook</a></br></br>';

$sql = "SELECT * FROM runbooks WHERE user = '" . steralizeString($_SESSION['email']) . "'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo '<ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li><a href="runbook.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
    }
    echo '</ul>';
} else {
    echo 'No runbooks found';
}
