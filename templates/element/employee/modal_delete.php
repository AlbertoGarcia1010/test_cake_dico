<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="#" method="post">
          <input type="hidden" id="idEmployeeDelete" name="idEmployeeDelete">
          <p>¿Estas seguro de eliminar el registro <b><span id="nameDelete"></span></b>?</p>
          <p>Una vez eliminado ya no podrás recuperarlo.</p>

          <a class="btn btn-danger" role="button" type="submit" id="btnSaveDelete">Eliminar</a>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function viewModalDelete(idEmployee){
        $('#modalDelete').modal('show');
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
                const employeeData = response.data; 
                $('#idEmployeeDelete').val(employeeData.id);
                $('#nameDelete').text(employeeData.nombre);
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }

    $('#btnSaveDelete').on("click",function() {
      console.log('save Delete');
      const idEmployee = $('#idEmployeeDelete').val();
      $.ajax({
            url: '/api/employee/delete',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idEmployee: idEmployee},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#employee-table').DataTable().ajax.reload();
                $('#modalDelete').modal('hide');


            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>