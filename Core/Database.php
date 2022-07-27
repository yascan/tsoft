<?php

namespace Tsoft\Core;


class Database
{
    private static $instance;
    private \PDO $db;

    public function __construct()
    {
        try {
            $dsn= sprintf('mysql:host=%s;dbname=%s;charset=%s', getenv('DB_HOST'), getenv('DB_NAME'), getenv('DB_CHARSET'));
            $this->db = new \PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getInstance(){
        if (!self::$instance){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->db;
    }
}
