<?php declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

/**
 * Authenfication model
 *
 * PHP version 8.0
 */
class User extends \Core\Model{

    /**
     * Look for login attempts
     * 
     * @param string $ip
     *
     * @return mixed
     */
    public static function getUsers(array $criteria = []):mixed {
        try {
            $db = static::getDB();

            $query = 'SELECT `user_ID`, `name`, `surname`, `username` FROM `user`';
            $conditions = [];
            $parameters = [];

            if (!empty($criteria)) {
                foreach ($criteria as $key => $value) {
                    $conditions[] = "`$key` = :$key";
                    $parameters[":$key"] = $value;
                }
                $query .= ' WHERE ' . implode(' AND ', $conditions);
            }

            $stmt = $db->prepare($query);
            $stmt->execute($parameters);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}