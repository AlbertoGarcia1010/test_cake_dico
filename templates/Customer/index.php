<h1>Clientes</h1>
<a class="btn btn-primary" href="/customer/create" role="button">Nuevo Cliente</a>
<table id="customer-table" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Direccion</th>
            <th>Email</th>
            <th>Usuario</th>
            <th>Fecha Nacimiento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    
</table>

<?= $this->element('Customer/modal_details') ?>

<script type="text/javascript">


    $(document).ready( function () {
        $('#customer-table').DataTable({ 
            'ajax': {
                "datatype": "json",
                'url': '/customer/getall',
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
                { "data": 1 },  // nombre
                { "data": 2 },  // apellido
                { "data": 3 },  // direccion
                { "data": 4 },  // email
                { "data": 5 },  // usuario
                { "data": 6 },  // fecha_nacimiento
                {
                "render": function (data, type, full, meta) {
                    return `<a class="btn btn-primary" href="#modalDetails" onclick="viewModalDetail(${full[0]})" role="button"><i class="material-icons center">visibility</i></a>`;

                }
            }
            ]
        })
    } );

</script>