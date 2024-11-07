<h1>Nuevo Rol</h1>

<?= $this->Form->create($rol) ?>

    <?= $this->Form->control('name', ['label' => 'Nombre']) ?>
    <?= $this->Form->control('description', ['label' => 'Descripción', 'type' => 'textArea']) ?>

    <?= $this->Form->button(__('Guardar Rol')) ?>

<?= $this->Form->end() ?>