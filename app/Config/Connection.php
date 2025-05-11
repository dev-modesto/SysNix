<?php

namespace App\Config;

// include_once 'config.php';

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Connection
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // carrega o .env só uma vez
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            $host = $_ENV['DB_HOST'];
            $db   = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USERNAME'];
            $pass = $_ENV['DB_PASSWORD'];

            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                die('ocorreu um erro ao conectar com o banco!!');
            }
        }

        return self::$instance;
    }

    private function __construct() {}
    private function __clone() {}
}