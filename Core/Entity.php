<?php declare(strict_types= 1);

namespace Core;

use DateTime;

/**
 * Base entity
 * 
 * PHP version 8.0
 */
abstract class Entity{

    // Common properties for all entities
    protected int $id;
    protected DateTime $createdAt;
    protected DateTime $updatedAt;

    public function __construct(int $id){  
        $this->id = $id;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }
    
    public function getId():int {
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function getCreatedAt(): DateTime{
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void{
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime{
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void{
        $this->updatedAt = $updatedAt;
    }
}
