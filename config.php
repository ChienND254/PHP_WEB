<?php
require('./vendor/autoload.php');

# Add your client ID and Secret
$client_id = "600376554093-4pcctds6t51jrr7vmfb33uvs2dk4q9hd.apps.googleusercontent.com";
$client_secret = "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";

$client = new Google\Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);

# redirection location is the path to login.php
$redirect_uri = 'http://admin.tuyensinhhus.com/login.php';
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
$login_url = $client->createAuthUrl();
?>