<?php


namespace app\Core;


use PDO;

class DB
{

    private static $instance;

    private $pdo = false;

    private function __construct() {

    }

    private function __clone() {

    }

    private function __wakeup() {

    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $dsn
     * @param $dbuser
     * @param $dbpassword
     * @param $opt
     */
    public function connect($dsn, $dbuser, $dbpassword, $opt) {
        try {
            $this->pdo = new PDO($dsn, $dbuser, $dbpassword, $opt);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getConnect() {
        if ($this->pdo instanceof PDO) {
            return $this->pdo;
        }
        return false;
    }

    public function close() {
        $this->pdo = null;
    }
}