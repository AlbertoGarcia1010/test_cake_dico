<?php

// src/Model/Entity/Rol.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Customer extends Entity
{
    // List of accessible fields
    protected $_accessible = [
        'id' => true,
        'nombre' => true,
        'apellido' => true,
        'direccion' => true,
        'email' => true,
        'usuario' => true,
        'fechaNacimiento' => true,
        'idStatus' => true,
        'dateCreate' => true,
        'dateUpdate' => true
    ];
}
