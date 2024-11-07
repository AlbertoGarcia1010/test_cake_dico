<h1>Clientes</h1>
<button type="button" class="btn btn-primary">Nuevo Cliente</button>
<table id="customer-table" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Direccion</th>
            <th>Email</th>
            <th>Usuario</th>
        </tr>
    </thead>
    
</table>

<script type="text/javascript">
    $(document).ready( function () {
        $('#customer-table').DataTable({ 
            'ajax': {
                'url': '/customer',
                'dataSrc': 'staff'
            }, 
            "destroy": true,   
            "processing": false,   
            "serverSide": true,   
            "searching": true,   
            "oLanguage": {   
                "sEmptyTable": "No client available."    
            },    
            "lengthMenu": [    
                [10, 20, 50, -1],    
                [10, 20, 50, "All"]   
            ],   
            "order": [],   
        })
    } );

</script>