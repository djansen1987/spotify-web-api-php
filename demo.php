<?php
error_reporting(-1);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

Dotenv::load(__DIR__);

$session = new SpotifyWebAPI\Session(
    getenv('SPOTIFY_CLIENT_ID'),
    getenv('SPOTIFY_CLIENT_SECRET'),
    getenv('SPOTIFY_REDIRECT_URI')
);

$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $api->setAccessToken($session->getAccessToken());

    print_r($api->getUserPlaylist('mcgurk', '0jF78Hb6Np1eFaan46EyBl', array(
        'fields' => array('id', 'name'),
    )));
} else {
    $scopes = array(
        'scope' => array(
            'user-read-email',
            'user-library-modify',
        ),
    );

    header('Location: ' . $session->getAuthorizeUrl($scopes));
}
