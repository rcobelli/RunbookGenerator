<?php

include_once("init.php");

// echo 'http://' . $_SERVER['HTTP_HOST'] . '~ryan/rb/rb_backend/login.php';

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->setAccessType("offline");        // offline access
$client->setIncludeGrantedScopes(true);
$client->addScope("email profile");
$client->setRedirectUri('http://localhost/~ryan/rb/rb_backend/login.php');
$auth_url = $client->createAuthUrl();

echo '<a href="' . filter_var($auth_url, FILTER_SANITIZE_URL) . '">Click Here to Login</a>';
