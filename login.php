<?php

// Client ID: 783133595992-tamindmcr54h7qspsk2u2oh3h9nrg7nd.apps.googleusercontent.com
// Client Secret: 9ORYCla-XLnHP4P3oI80tb8k

include_once("init.php");

if (isset($_GET['error'])) {
    exit($_GET);
}

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->authenticate($_GET['code']);
$access_token = $client->getAccessToken();
$_SESSION['access_token'] = $access_token;

$plus = new Google_Service_Plus($client);
$person = $plus->people->get('me');
$_SESSION['email'] = $person['emails'][0]['value'];

header("Location: dashboard.php");
