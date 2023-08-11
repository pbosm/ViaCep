<?php

class Database 
{
    protected static $db;
    private function __construct()
    {
        $db_host = 'localhost';
        $db_user = 'root';
        $db_password = '';
        $db_name = 'bdteste';
        $db_driver = "mysql";
        $options = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
        // $host     = getenv("host");railway
        // $username = "root";
        // $pass     = getenv("pass");
        // $port     = getenv("port");
        // $db       = "railway";

        // $connecthost = "mysql:host=$host;dbname=$db;port=$port";railway
        
        try
        {
            // self::$db = new \PDO($connecthost, $username, $pass);
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_name", $db_user, $db_password, $options);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // self::$db->exec('SET NAMES utf8');
            self::$db->exec('SET NAMES utf8mb4');
            // self::$db->exec("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");railway
        }
        catch (PDOException $e)
        {   
            die("Connection Error: " . $e->getMessage());
        }
    }
    public static function connectionPDO()
    {
        if (!self::$db)
        {
            new Database();
        }
        return self::$db;
    }
}

?>