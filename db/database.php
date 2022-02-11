<?php
class Database {
    private static mysqli $connection;
    public static int $insert_id;

    public static function connect() {
        self::$connection = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
        if (self::$connection->connect_error) {
            die("Failed to connect");
        }
    }

    public static function query(string $query, string $types = null, ...$values): mysqli_result|bool {
        $stmt = self::$connection->prepare($query);
        if ($types && $values) {
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
        self::$insert_id = self::$connection->insert_id;
        return $stmt->get_result();
    }
}