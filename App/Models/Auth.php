<?php declare(strict_types=1);

namespace App\Models;

use App\Entity\User;
use PDO;
use PDOException;

/**
 * Authenfication model
 *
 * PHP version 8.0
 */
class Auth extends \Core\Model{

    /**
     * Check if password and username is correct and give back the right user_ID
     * 
     * @param string $username
     * @param string $password
     *
     * @return mixed
     */
    public static function getUser(string $username, string $password):mixed {
        try {
            $db = static::getDB();

            $stmt = $db->prepare('SELECT `user_ID`, `name`, `surname`, `username` FROM `user` WHERE `username` = ? AND `password` = ?;');
            $stmt->execute([$username, $password]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            return new User($results['user_ID'], $results['name'], $results['surname'], $results['username']);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * Set the cookie hash in the table
     * 
     * @param string $hash
     *
     * @return mixed
     */
    public static function addCookie(string $hash):mixed {
        try {
            $db = static::getDB();

            $stmt = $db->prepare('INSERT INTO `login_cache` (`hash`, `user_ID`) VALUES (?, ?);');
            $stmt->execute([$hash, $_SESSION['user_ID']]);
            $results = $stmt->rowCount();
            
            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * Check if the cookie is in the table
     * 
     * @param string $hash
     *
     * @return mixed
     */
    public static function testCookie(string $hash):mixed {
        try {
            $db = static::getDB();

            $stmt = $db->prepare('SELECT COUNT(*) AS "count" ,`user_ID` FROM login_cache WHERE hash = ?;');
            $stmt->execute([$hash]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
           
            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * Delete the cookie hash in the table
     * 
     * @param int $user_ID
     *
     * @return mixed
     */
    public static function deleteCookie(int $user_ID):mixed {
        try {
            $db = static::getDB();

            $stmt = $db->prepare('DELETE FROM login_cache WHERE user_ID = ?;');
            $stmt->execute([$user_ID]);
            $results = $stmt->rowCount();
            
            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }


    /**
     * Look for login attempts
     * 
     * @param string $ip
     *
     * @return mixed
     */
    public static function checkLoginAttempts(string $ip):mixed {
        try {
            $db = static::getDB();

            $stmt = $db->prepare('SELECT COUNT(`ip`) AS `attempts` FROM `password_attempts` WHERE `ip` = ? AND `attempt_time` >= (NOW() - INTERVAL 1 DAY) GROUP BY `ip`;');
            $stmt->execute([$ip]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * Look for login attempts
     * 
     * @param string $ip
     *
     * @return mixed
     */
    public static function registerLoginAttempt(string $ip):mixed {
        try {
            $db = static::getDB();

            $stmt = $db->prepare('INSERT INTO `password_attempts` (`ip`) VALUES (?);');
            $stmt->execute([$ip]);
            $results = $stmt->rowCount();
            
            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}