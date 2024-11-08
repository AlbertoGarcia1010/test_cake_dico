<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class EmployeeTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Table configuration
        $this->setTable('empleado'); // Ensure this is the correct table name
        $this->setPrimaryKey('id'); // Set the primary key if applicable
        $this->setDisplayField('nombre');
        $this->setDisplayField('apellido');
        $this->setDisplayField('telefono');

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
            ->notEmptyString('nombre', 'El nombre es requerido')
            ->notEmptyString('telefono', 'El telefono es requerido');

        return $validator;
    }
}
