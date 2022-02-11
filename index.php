<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/connector.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/router.php';



get('/', 'test1');
get('/test', 'test2');