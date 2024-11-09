<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Product extends Entity
{
    // List of accessible fields
    protected $_accessible = [
        'upc' => true,
        'descripcion' => true,
        'costo' => true,
        'precio' => true,
        'existencia' => true,
        'idStatus' => true,
        'dateCreate' => true,
        'dateUpdate' => true
    ];
}
