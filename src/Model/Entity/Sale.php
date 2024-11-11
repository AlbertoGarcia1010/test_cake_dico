<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Sale extends Entity
{
    // List of accessible fields
    protected $_accessible = [
        'id' => true,
        'idEmpleado' => true,
        'idCliente' => true,
        'total' => true,
        'idStatus' => true,
        'dateCreate' => true,
        'dateUpdate' => true
    ];
}
