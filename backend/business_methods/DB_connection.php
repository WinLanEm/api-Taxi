<?php


class PostgreSQLConnection {

    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = 'localhost';
        $dbname = 'apidatabase';
        $username = 'myuser';
        $password = 'Brukva373';

        try {

            $dsn = "pgsql:host=$host;dbname=$dbname";
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            http_response_code(500);
            $res = [
                'status' => false,
                'message' => 'Internal Server Error'
            ];
            die(json_encode($res));
//            die("Ошибка подключения к базе данных: " . $e->getMessage());

        }
    }


    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new PostgreSQLConnection();
        }
        return self::$instance;
    }


    public function getConnection() {
        return $this->connection;
    }


    private function __clone() {}
}
