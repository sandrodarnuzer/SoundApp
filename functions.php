<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/connector.php';

function render(string $page) {
    $root = $_SERVER['DOCUMENT_ROOT'];
    include $root . '/' . BASE_PATH . 'components/' . 'header.php';
    include $root . '/' . BASE_PATH . 'pages/' . $page . '.php';
    include $root . '/' . BASE_PATH . 'components/' . 'footer.php';
}