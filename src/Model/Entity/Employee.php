<?php

// src/Model/Entity/Rol.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Employee extends Entity
{
    // List of accessible fields
    protected $_accessible = [
        'id' => true,
        'nombre' => true,
        'apellido' => true,
        'telefono' => true,
        'idStatus' => true,
        'dateCreate' => true,
        'dateUpdate' => true
    ];
}
