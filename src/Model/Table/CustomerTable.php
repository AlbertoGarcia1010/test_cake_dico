<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class CustomerTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Table configuration
        $this->setTable('cliente'); // Ensure this is the correct table name
        $this->setPrimaryKey('id'); // Set the primary key if applicable
        $this->setDisplayField('nombre');
        $this->setDisplayField('apellido');
        $this->setDisplayField('direccion');
        $this->setDisplayField('email');
        $this->setDisplayField('usuario');
        $this->setDisplayField('fecha_nacimiento');


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
            ->notEmptyString('usuario', 'El usuario es requerido')
            ->notEmptyString('email', 'La email es requerida');

        return $validator;
    }
}
