<?php

include_once("init.php");

if (!empty($_SESSION['email'])) {
    header("Location: dashboard.php");
    die();
}

if (isset($_GET['code'])) {
    include_once("login.php");
} elseif (isset($_COOKIE['runbook'])) {
    $data = json_decode($_COOKIE['runbook']);
    $_SESSION['name'] = $data->name;
    $_SESSION['email'] = $data->email;

    header("Location: dashboard.php");
    die();
} else {
    $client = new Google_Client();
    $client->setAuthConfig('../rb-client_secret.json');
    $client->setAccessType("offline");        // offline access
    $client->setIncludeGrantedScopes(true);
    $client->addScope("profile");
    if (isset($_GET['email'])) {
        $client->setLoginHint(urldecode($_GET['email']));
    }
    if (devEnv()) {
        $client->setRedirectUri('http://localhost/~ryan/rb/rb_backend/index.php');
    } else {
        $client->setRedirectUri('https://dev.rybel-llc.com/runbook/index.php');
    }
    $auth_url = $client->createAuthUrl();
}

?>
<html lang="en">
<head>
    <title>Runbook Generator</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#24273a">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#24273a">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <style>
    body, html {
        background-color: white;
        color: #24273A;
        /* 43f8d4 */
    }
    </style>
</head>
<body class="text-center">
    <div class="container d-flex h-100 p-3 mx-auto flex-column">
        <header class="mb-3">
            <div class="inner">
                <img src="assets/icon.png" height="100px" style="float: left;" class="mr-5">
                <h1 style="line-height: 100px; text-align: left;">Runbook Generator</h1>
            </div>
        </header>

        <main role="main" class="inner">
            <h1 class="cover-heading">Easily Organize All Your <a href="https://en.wikipedia.org/wiki/Markdown" target="_blank">Markdown</a> <a href="https://en.wikipedia.org/wiki/Runbook" target="_blank">Runbooks</a> 📕</h1>
            <p class="lead">This utility allows you to easily create, revise and download copies of your runbooks. Get started by logging in with Google now!</p>
            <p class="lead">
                <a href="<?php echo filter_var($auth_url, FILTER_SANITIZE_URL); ?>"><button type="button" class="btn btn-danger">Login With Google</button></a>
            </p>
        </main>
        <hr />
        <main role="main" class="inner mt-5">
            <h3 class="cover-heading">Example</h3>
            <p class="lead">You can download any revision of your runbook as a PDF. Below is an example</p>
            <img src="assets/example.png" height="1000px;" class="mb-3 border border-secondary">
        </main>
    </div>
</body>
</html>
