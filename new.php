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
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $sql = "INSERT INTO revisions (runbookID, revisionID, timestamp, data, changelog) VALUES ($last_id, 1, NOW(), '$data', 'Initial entry')";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php");
        } else {
            exit($conn->error);
        }
    } else {
        exit($conn->error);
    }
}

?>
<form method="post">
    Title: <input name="title" type="text"></br>
    Content: <textarea name="data"></textarea></br>
    <input type="submit" value="Submit" name="submit">
</form>
