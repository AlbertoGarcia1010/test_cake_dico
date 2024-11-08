<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ver Detalles del Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Nombre Completo: <span id="completeName"></span></p>
        <p>Telefono: <span id="phone"></span></p>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    
  function viewModalDetail(idEmployee){
        $('#modalDetails').modal('show');
        $.ajax({
            url: '/employee/get',
            async: 'true',
            type: 'GET',
            dataType: 'json',
            data: {idEmployee: idEmployee},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                // 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                
                const employeeData = response.data; 
                $('#idEmployeeEdit').val(employeeData.id);
                $('#completeName').text(`${employeeData.nombre} ${employeeData.apellido}`);
                $('#phone').text(employeeData.telefono);

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }
        

</script>