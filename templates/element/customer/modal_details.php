<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ver Detalles del Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Nombre Completo: <span id="completeName"></span></p>
        <p>Dirección: <span id="address"></span></p>
        <p>Email: <span id="email"></span></p>
        <p>Usuario: <span id="user"></span></p>
        <p>Fecha de Nacimiento: <span id="bornDate"></span></p>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    
  function viewModalDetail(idCustomer){
        $('#modalDetails').modal('show');
        $.ajax({
            url: '/customer/get',
            async: 'true',
            type: 'GET',
            dataType: 'json',
            data: {idCustomer: idCustomer},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                // 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                
                const customerData = response.data; 
                $('#idRolEdit').val(customerData.id);
                $('#completeName').text(`${customerData.nombre} ${customerData.apellido}`);
                $('#address').text(customerData.direccion);
                $('#email').text(customerData.email);
                $('#user').text(customerData.usuario);
                $('#bornDate').text(customerData.fecha_nacimiento);

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }
        

</script>