<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/router.php';

if (Config::AUTH) {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
    } else {
        if (!($_SERVER['PHP_AUTH_USER'] === Config::AUTH_USER && $_SERVER['PHP_AUTH_PW'] === Config::AUTH_PASSWORD)) exit;
    }
}

Database::connect();

// Album
Router::get('/', 'album/album_index');
Router::get('/new', 'album/album_new');
Router::post('/create', 'album/album_create');
Router::get('/delete', 'album/album_delete');
Router::get('/show', 'album/album_show');

// Song
Router::get('/song/delete', 'song/song_delete');
Router::get('/song/new', 'song/song_new');
Router::post('/song/create', 'song/song_create');