<h1>Nueva Venta</h1>

<?= $this->Form->create($sale) ?>
    <?= $this->Form->control('id_empleado', [
        'type' => 'select',
        'empty' => 'Seleccione un empleado',
        'options' => $employees,
        'label' => '',
        'class' => 'form-select'
    ]) ?>

    <?= $this->Form->control('id_cliente', [
        'type' => 'select',
        'empty' => 'Seleccione un cliente',
        'options' => $customers,
        'label' => '',
        'class' => 'form-select'
    ]) ?>

    <?= $this->Form->control('id_producto', [
        'type' => 'select',
        'empty' => 'Seleccione un producto',
        'options' => $products,
        'label' => '',
        'class' => 'form-select'
    ]) ?>

    <?= $this->Form->control('idSale', [
        'type' => 'text',
        'label' => 'ID venta',
        'value' => $newSaleId ?? 0, // Colocar el ID en el campo
        'readonly' => true,
        'default' => 0
    ]); ?>
    <br>
    <?= $this->Form->button(__('Agregar Producto')) ?>

<?= $this->Form->end() ?>
<br>
<table id="sale-details-table" class="display">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Existencia</th>
            <th>Cantidad</th>
            <th></th>
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function onDecreaseProduct(idSale, idProduct, cantidad){
        if(cantidad > 0){
            $.ajax({
                url: '/api/saledetail/decrease',
                async: 'true',
                type: 'POST',
                dataType: 'json',
                data: {idSale: idSale, idProduct: idProduct},
                headers: {
                    'contentType': 'application/json; charset=UTF-8',
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log("response: ", response);

                    $('#sale-details-table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    // 
                }
            });
        }
        
    }

    function onIncreaseProduct(idSale, idProduct){
        $.ajax({
            url: '/api/saledetail/increase',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idSale: idSale, idProduct: idProduct},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#sale-details-table').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }
    $(document).ready( function () {
        let idSale = 16;
        $('#sale-details-table').DataTable({ 
            'ajax': {
                "datatype": "json",
                'url': '/sale/get',
                'dataSrc': 'data.data',
                'data': {'idSale': idSale}
            }, 
            "destroy": true,   
            "processing": false,   
            "serverSide": true,   
            "searching": true,   
            "oLanguage": {   
                "sEmptyTable": "No records found."    
            },      
            "order": [],
            "columns": [
                {// Producto
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    return `<span><b>${full[2]}<b></span><br><span>${full[6]}</span>`;
                    }
                },
                {// precio
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    return `<span>$ ${full[3]}</span>`;
                    }
                },
                {// existencia
                "render": function (data, type, full, meta) {
                    let color = "success";
                    let existencia = full[7];
                    if(existencia < 4 ){
                        color = "danger";
                    } else if(existencia > 3 && existencia < 10){
                        color = "warning";
                    }
                    return `<span class="badge bg-${color}">${full[7]}</span>`;
                    }
                },
                {// cantidad
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    return `${full[4]}`;
                    }
                },
                {
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    return `<a class="btn btn-danger" id="viewDetailsBtn" onclick="onDecreaseProduct(${full[1]}, '${full[2]}, ${full[4]}')" role="button"><i class="material-icons center">remove</i></a>&nbsp<span>${full[4]}</span>&nbsp<a class="btn btn-success" onclick="onIncreaseProduct(${full[1]}, '${full[2]}')" role="button"><i class="material-icons center">add</i></a>`;

                    }
                }
            ]
        });
    });

</script>


