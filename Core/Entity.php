<?php declare(strict_types= 1);

namespace Core;

/**
 * Base entity
 * 
 * PHP version 8.0
 */
abstract class Entity{

    // Common properties for all entities
    protected int $id;

    public function __construct(int $id){  
        $this->id = $id;
    }
    
    public function getId():int {
        return $this->id;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }
}