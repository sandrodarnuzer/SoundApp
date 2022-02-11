<?php
require_once __DIR__ . '/../config/config.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($db->connect_error) {
    die("Failed to connect to database: " . $db->connect_error);
}
