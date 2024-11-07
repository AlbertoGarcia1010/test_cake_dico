<h1>Nuevo Cliente</h1>

<?= $this->Form->create($cliente) ?>

    <?= $this->Form->control('nombre', ['label' => 'Nombre']) ?>
    <?= $this->Form->control('usuario', ['label' => 'Usuario']) ?>
    <?= $this->Form->control('email', ['label' => 'Email']) ?>

    <?= $this->Form->button(__('Guardar Cliente')) ?>

<?= $this->Form->end() ?>
