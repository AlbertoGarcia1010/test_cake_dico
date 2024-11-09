<h1>Nuevo Producto</h1>

<?= $this->Form->create($producto) ?>
    <?= $this->Form->control('upc', ['label' => 'UPC', 'type' => 'text']) ?>
    <?= $this->Form->control('descripcion', ['label' => 'Descripcion', 'type' => 'textArea']) ?>
    <?= $this->Form->control('costo', ['label' => 'Costo']) ?>
    <?= $this->Form->control('precio', ['label' => 'Precio']) ?>
    <?= $this->Form->control('existencia', ['label' => 'Existencias', 'type' => 'number']) ?>

    <?= $this->Form->button(__('Guardar Producto')) ?>

<?= $this->Form->end() ?>
