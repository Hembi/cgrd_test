<?php

class Database
{
    private static $dbInstance = null;
    private $connection = null;

    function __construct()
    {
        try {
            $dsn = "mysql:host=" . Config::DB_HOST . ";port=". Config::DB_PORT .";dbname=" . Config::DB_NAME;
            $this->connection = new PDO($dsn, Config::DB_USERNAME, Config::DB_PASSWORD);
            $this->connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            /* echo "Database connection successfully!"; */
        }
        catch(PDOException $e)
        {
            echo "Database connection error: " . $e->getMessage();
            exit;
        }
    }

    public static function getInstance(): Database
    {
        if (self::$dbInstance == null)
        {
            self::$dbInstance = new Database();
        }
    
        return self::$dbInstance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}

?>