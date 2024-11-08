<h1>Nuevo Empleado</h1>

<?= $this->Form->create($empleado) ?>

    <?= $this->Form->control('nombre', ['label' => 'Nombre']) ?>
    <?= $this->Form->control('apellido', ['label' => 'Apellido']) ?>
    <?= $this->Form->control('telefono', ['label' => 'Telefono']) ?>

    <?= $this->Form->button(__('Guardar Empleado')) ?>

<?= $this->Form->end() ?>
