<?php

class Router {
    public static function get(string $path, string $page) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') self::route($path, $page);
    }
    
    public static function post(string $path, string $page) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') self::route($path, $page);
    }
    
    private static function route(string $path, string $page) {
        $uri = $_SERVER['REQUEST_URI'];
    
        $uri = strpos($uri, "?") ? substr($uri, 0, strpos($uri, "?")) : $uri;
        $uri = rtrim($uri, '/');
        $path = rtrim($path, '/');

        if ($uri === rtrim(Config::BASE_PATH, '/') . $path) {
            render($page);
        }
    }
}
