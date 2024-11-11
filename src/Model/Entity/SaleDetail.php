<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class SaleDetail extends Entity
{
    // List of accessible fields
    protected $_accessible = [
        'id' => true,
        'id_venta' => true,
        'id_producto' => true,
        'precio' => true,
        'cantidad' => true,
        'utilidad' => true,
        'idStatus' => true,
        'dateCreate' => true,
        'dateUpdate' => true
    ];
}
