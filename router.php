<?php


function get(string $path, string $page) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') route($path, $page);
}

function post(string $path, string $page) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') route($path, $page);
}

function route(string $path, string $page) {
    $root = $_SERVER['DOCUMENT_ROOT'];
    $uri = $_SERVER['REQUEST_URI'];

    $uri = strpos($uri, "?") ? substr($uri, 0, strpos($uri, "?")) : $uri;
    $uri = rtrim($uri, '/');
    $path = rtrim($path, '/');

    if ($uri === '/' . rtrim(BASE_PATH, '/') . $path) {
        render($page);
    }
}