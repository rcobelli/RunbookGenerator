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
    if ($conn->query($sql) === TRUE) {
        header("Location: runbook.php?id=" . $runbookID);
    } else {
        exit($conn->error);
    }
}

$id = steralizeString($_GET['id']);

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
<form method="post">
    Content: <textarea name="data"><?php echo $row['data']; ?></textarea></br>
    Change log: <input type="text" name="changelog"></br>
    <input type="hidden" value="<?php echo $row['revisionID']; ?>" name="revisionID">
    <input type="hidden" value="<?php echo $row['runbookID']; ?>" name="runbookID">
    <input type="submit" value="Submit" name="submit">
</form>
