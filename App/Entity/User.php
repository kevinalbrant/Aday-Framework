<?php declare(strict_types= 1);

namespace App\Entity;

/**
 * User Entity
 * 
 * PHP version 8.0
 */
class User extends \Core\Entity{

    private string $name;
    private string $surname;
    private string $username;
    private string $password;

    public function __construct(int $id, string $name, string $surname, string $username, string $password) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->password = $password;
    }

    public function getSurname():string {
        return $this->surname;
    }

    public function setSurname(string $surname):void {
        $this->surname = $surname;
    }

    public function getName():string {
        return $this->name;
    }

    public function setName(string $name):void {
        $this->name = $name;
    }

    public function getUsername():string {
        return $this->username;
    }

    public function setUsername(string $username):void {
        $this->username = $username;
    }

    public function getPassword():string {
        return $this->password;
    }
}