
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="#" method="post">
          <input type="hidden" id="idEmployeeEdit" name="idEmployeeEdit">
          <label for="name">Nombre:</label>
          <input type="text" id="nameEdit" name="nameEdit" placeholder="Ingresa el nombre" required>

          <label for="message">Apellido:</label>
          <input type="text" id="lastNameEdit" name="lastNameEdit" placeholder="Ingresa el apellido" required>

          <label for="message">Telefono:</label>
          <input type="text" id="phoneEdit" name="phoneEdit" placeholder="Ingresa el Telefono" required>

          <a class="btn btn-primary" role="button" type="submit" id="btnSaveEdit">Guardar</a>

      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function viewModalEdit(idEmployee){
        $('#modalEdit').modal('show');
        // clearFields();

        $.ajax({
            url: '/employee/get',
            async: 'true',
            type: 'GET',
            dataType: 'json',
            data: {idEmployee: idEmployee},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                $('#idEmployeeEdit').val(response.data.id);
                $('#nameEdit').val(response.data.nombre);
                $('#lastNameEdit').val(response.data.apellido);
                $('#phoneEdit').val(response.data.telefono);

            },
            error: function(xhr, status, error) {
                // 
            }
        });
        
    }

    $('#btnSaveEdit').on("click",function() {
      const idEmployee = $('#idEmployeeEdit').val();
      const nameEdit = $('#nameEdit').val();
      const lastNameEdit = $('#lastNameEdit').val();
      const phoneEdit = $('#phoneEdit').val();

      $.ajax({
            url: '/api/employee/update',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idEmployee: idEmployee, nameEdit: nameEdit, lastNameEdit: lastNameEdit, phoneEdit:phoneEdit},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#employee-table').DataTable().ajax.reload();
                $('#modalEdit').modal('hide');

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>