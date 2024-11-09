<h1>Productos</h1>
<a class="btn btn-primary" href="/product/create" role="button">Nuevo Producto</a>
<table id="product-table" class="display">
    <thead>
        <tr>
            <th>UPC</th>
            <th>Descripción</th>
            <th>Costo</th>
            <th>Precio</th>
            <th>Existencia</th>
            <th>Acciones</th>
        </tr>
    </thead>
    
</table>

<?= $this->element('Product/modal_details') ?>
<?= $this->element('Product/modal_edit') ?>
<?= $this->element('Product/modal_delete') ?>


<script type="text/javascript">


    $(document).ready( function () {
        $('#product-table').DataTable({ 
            'ajax': {
                "datatype": "json",
                'url': '/product/getall',
                'dataSrc': 'data.data'
            }, 
            "destroy": true,   
            "processing": false,   
            "serverSide": true,   
            "searching": true,   
            "oLanguage": {   
                "sEmptyTable": "No client available."    
            },      
            "order": [],
            "columns": [
                { "data": 0 },  // upc
                { "data": 1 },  // descripcion
                { "data": 2 },  // costo
                { "data": 3 },  // precio
                { "data": 4 },  // existencia
                {
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    return `<a class="btn btn-primary" id="viewDetailsBtn" onclick="viewModalDetail('${full[0]}')" role="button"><i class="material-icons center">visibility</i></a>&nbsp<a class="btn btn-warning" href="#modalEdit" onclick="viewModalEdit('${full[0]}')" role="button"><i class="material-icons center">edit</i></a>&nbsp<a class="btn btn-danger" onclick="viewModalDelete('${full[0]}')" role="button"><i class="material-icons center">delete</i></a>`;

                }
            }
            ]
        })
    } );

    $('#customer-table').on('keyup', function() {
        table.search(this.value).draw(); // Aplica la búsqueda
    });

</script>