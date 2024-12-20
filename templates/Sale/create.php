<h1>Nueva Venta</h1>
<h1>Tota: $ <span id="totalSale"></span></h1>

<div id="divForm" style="display:block;">
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
            'type' => 'hidden',
            'label' => 'ID venta',
            'value' => $newSaleId ?? 0, // Colocar el ID en el campo
            'readonly' => true,
            'default' => 0
        ]); ?>
        <br>
        <?= $this->Form->button(__('Agregar Producto')) ?>
    <?= $this->Form->end() ?>
</div>


<br>
<div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      No es posible agregar más productos
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
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
<br>
<a class="btn btn-warning" onclick="onCancelSale()" role="button" id="btnCancelSale" style="display:none;">Cancelar Venta</a>
<a class="btn btn-success" onclick="onChargeSale()" role="button" id="btnChargeSale" style="display:none;">Cobrar Venta</a>


<script type="text/javascript">
    let idSale = <?=  $newSaleId ?>;
    let estatus = 0;
    function onDecreaseProduct(idSale, idProduct, cantidad){
        console.log('cantidad: ', cantidad)
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

    function onIncreaseProduct(idSale, idProduct, cantidad, existencia){
        if(cantidad < existencia){
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
        }else{
            var myToast = document.querySelector('.toast');
            var toast = new bootstrap.Toast(myToast);
            toast.show();
        }
        
    }
    
    function onChargeSale(){
        $.ajax({
            url: '/api/sale/charge',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {'idSale': idSale},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                $('#btnChargeSale').hide();
                $('#btnCancelSale').show();
                estatus = 1;
                $('#sale-details-table').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }

    function onCancelSale(){
        $.ajax({
            url: '/api/sale/cancel',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {'idSale': idSale},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                $('#btnCancelSale').hide();
                estatus = 2;
                $('#sale-details-table').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }
    
    $(document).ready( function () {
        $.ajax({
            url: '/sale/get',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {'idSale': idSale},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                const sale = response.data;
                estatus = sale.estatus;
                $('#totalSale').text(sale.total);
                if(sale.estatus == 0){
                    $('#btnChargeSale').show();
                } else if(sale.estatus == 1){
                    $('#btnCancelSale').show();
                }
                if(estatus > 0){
                    $('#divForm').hide();
                }

            },
            error: function(xhr, status, error) {
                // 
            }
        });
        $('#sale-details-table').DataTable({ 
            'ajax': {
                "datatype": "json",
                'url': '/saledetail/get',
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
                    return `${estatus == 0 ? `<a class="btn btn-danger" id="viewDetailsBtn" onclick="onDecreaseProduct(${full[1]}, '${full[2]}', ${full[4]})" role="button"><i class="material-icons center">remove</i></a>&nbsp<span>${full[4]}</span>&nbsp<a class="btn btn-success" onclick="onIncreaseProduct(${full[1]}, '${full[2]}', ${full[4]}, ${full[7]})" role="button"><i class="material-icons center">add</i></a>`:''}`;                        
                    }
                }
            ]
        });

    });

</script>


