<?php
include_once APPPATH.'/functions/sosmed/Google/autoload.php'; // panggil autoload dari Facebook SDK
$log_g = explode(", ", api('login_google'));
$client_id = $log_g[0];
$secret_id = $log_g[1];

$client = new Google_Client();
//Make object of Google API Client for call Google API
$google_client = new Google_Client();
//Set the OAuth 2.0 Client ID
$google_client->setClientId($client_id);
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret($secret_id);
//Set the OAuth 2.0 Redirect URI
$url_re = siteURL();
if (superman()) { $url_re .= 'klinik_dokter/'; }
$google_client->setRedirectUri($url_re.'auth/login-google');

$google_client->addScope('email');
$google_client->addScope('profile');
?>
