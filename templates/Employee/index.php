<h1>Empleados</h1>
<a class="btn btn-primary" href="/employee/create" role="button">Nuevo Empleado</a>
<table id="employee-table" class="display">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    
</table>

<?= $this->element('Employee/modal_details') ?>
<?= $this->element('Employee/modal_edit') ?>
<?= $this->element('Employee/modal_delete') ?>


<script type="text/javascript">


    $(document).ready( function () {
        $('#employee-table').DataTable({ 
            'ajax': {
                "datatype": "json",
                'url': '/employee/getall',
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
                { "data": 1 },  // nombre
                { "data": 2 },  // apellido
                { "data": 3 },  // telefono
                {
                "render": function (data, type, full, meta) {
                    console.log("full", full)
                    return `<a class="btn btn-primary" id="viewDetailsBtn" onclick="viewModalDetail(${full[0]})" role="button"><i class="material-icons center">visibility</i></a>&nbsp<a class="btn btn-warning" href="#modalEdit" onclick="viewModalEdit(${full[0]})" role="button"><i class="material-icons center">edit</i></a>&nbsp<a class="btn btn-danger" onclick="viewModalDelete(${full[0]})" role="button"><i class="material-icons center">delete</i></a>`;

                }
            }
            ]
        })
    } );

    $('#employee-table').on('keyup', function() {
        table.search(this.value).draw(); // Aplica la búsqueda
    });

</script>