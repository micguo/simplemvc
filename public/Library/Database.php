<?php
class Database
{
    private static $connection = null;

    /**
     * Get PDO connection
     * 
     * @return PDO connection
     */
    public static function getConnection()
    {
        if (empty(self::$connection)) {
            try {
                $dbh = new PDO("mysql:host=localhost;dbname=Spoonity", "root", "root");
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

            self::$connection = $dbh;
        }

        return self::$connection;
    }
}