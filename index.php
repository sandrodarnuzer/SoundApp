<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/router.php';

Database::connect();
Router::get('/', 'album/album_index');

// New Album
Router::get('/new', 'album/album_new');
Router::post('/create', 'album/album_create');

Router::get('/show', 'album/album_show');