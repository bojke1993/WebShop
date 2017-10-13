<?php
/**
 * Created by PhpStorm.
 * User: ivanbojovic
 * Date: 9.10.17.
 * Time: 10.02
 */

require_once 'DBinfo.php';

//Singleton
class DB
{
    //params for connection string
    private static $_instance = null;
    private $server = SERVER_NAME;
    private $dbName = DB_NAME;
    private $usernameDB = USERNAME;
    private $passwordDB = PASSWORD;
    private $connection;

    private function __construct()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                'mysql:host=' . $this->server . ';dbname=' . $this->dbName,
                $this->usernameDB,
                $this->passwordDB);
            $this->connection->exec('set names utf8');
        } catch (PDOException $exception) {
            $exception->getMessage();
        }
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new DB();
        }

        return self::$_instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}