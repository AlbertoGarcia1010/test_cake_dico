<h1>Nuevo Cliente</h1>

<?= $this->Form->create($cliente) ?>

    <?= $this->Form->control('nombre', ['label' => 'Nombre']) ?>
    <?= $this->Form->control('apellido', ['label' => 'Apellido']) ?>
    <?= $this->Form->control('direccion', ['label' => 'Direccion']) ?>
    <?= $this->Form->control('email', ['label' => 'Email']) ?>
    <?= $this->Form->control('usuario', ['label' => 'Usuario']) ?>
    <?= $this->Form->control('fecha_nacimiento', ['label' => 'Fecha Nacimiento', 'type' => 'date']) ?>

    <?= $this->Form->button(__('Guardar Cliente')) ?>

<?= $this->Form->end() ?>
