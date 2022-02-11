<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/router.php';

Database::connect();
Router::get('/', 'album/index');

// New Album
Router::get('/new', 'album/new');
Router::post('/create', 'album/create');

Router::get('/show', 'album/show');