<h1>Ventas</h1>
<a class="btn btn-primary" href="/sale/create" role="button">Generar Nueva Venta</a>
<table id="employee-table" class="display">
    <thead>
        <tr>
            <th># Venta</th>
            <th>Total</th>
            <th>Estatus</th>
            <th>Fecha Creacion</th>
            <th>Fecha Ultima Actualizacion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    
</table>

<script type="text/javascript">


    $(document).ready( function () {
        $('#employee-table').DataTable({ 
            'ajax': {
                "datatype": "json",
                'url': '/sale/getall',
                'dataSrc': 'data.data'
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
                { "data": 0 },  // ID
                { "data": 3 },  // Total
                { "data": 5 },  // Fecha Creacion
                { "data": 6 },  // Fecha Actualizacion
                { // estatus
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    let txtStatus = "Abierto";
                    let colorStatus = "primary";
                    if(full[4] == 1){
                        txtStatus = "Pagado";
                        colorStatus = "success";
                    } else if(full[4] == 2){
                        txtStatus = "Cancelado";
                        colorStatus = "danger";
                    }
                    return `<span class="badge bg-${colorStatus}">${txtStatus}</span>`;
                    }
                },
                {
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    
                    return `<a class="btn btn-primary" id="viewDetailsBtn" href="/sale/create?newSaleId=${full[0]}" role="button"><i class="material-icons center">visibility</i></a>`;

                    }
                }
            ]
        })
    } );

    $('#employee-table').on('keyup', function() {
        table.search(this.value).draw(); // Aplica la búsqueda
    });

</script>