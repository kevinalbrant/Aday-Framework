<?php declare(strict_types= 1);

namespace Core;

use PDO;
use App\Config;
use PDOException;

/**
 * Base model
 * 
 * PHP version 8.0
 */
abstract class Model{

    /**
     * Get the PDO database connection
     * 
     * @return PDO|null
     */
    protected static function getDB():PDO|null {
        static $db = null;

        if ($db === null) {
    
            try {
                $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
                $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return $db;
    }
}