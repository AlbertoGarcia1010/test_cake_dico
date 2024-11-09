<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class ProductTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Table configuration
        $this->setTable('producto'); // Ensure this is the correct table name
        $this->setPrimaryKey('upc'); // Set the primary key if applicable
        $this->setDisplayField('descripcion');
        $this->setDisplayField('costo');
        $this->setDisplayField('precio');
        $this->setDisplayField('existencia');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new', // 'created' solo para nuevas entradas
                    'updated_at' => 'always' // 'modified' para nuevas y actualizaciones
                ]
            ]
        ]);

    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('upc', 'El upc es requerido')
            ->notEmptyString('costo', 'El costo es requerido')
            ->notEmptyString('precio', 'El precio es requerido');

        return $validator;
    }
}
