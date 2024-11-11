<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class SaleDetailTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Product', [
            'foreignKey' => 'id_producto',
            'joinType' => 'LEFT'
        ]);

        // Table configuration
        $this->setTable('venta_detalle'); // Ensure this is the correct table name
        $this->setPrimaryKey('id'); // Set the primary key if applicable
        $this->setDisplayField('id_venta');
        $this->setDisplayField('id_producto');

        // $this->setDisplayField('total');
        // $this->setDisplayField('estatus');
    
        

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new', // 'created' solo para nuevas entradas
                    'updated_at' => 'always' // 'modified' para nuevas y actualizaciones
                ]
            ]
        ]);

    }

    /*
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('nombre', 'El nombre es requerido')
            ->notEmptyString('usuario', 'El usuario es requerido')
            ->notEmptyString('email', 'La email es requerida');

        return $validator;
    }
    */
}
