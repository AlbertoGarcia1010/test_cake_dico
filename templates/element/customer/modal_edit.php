
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="#" method="post">
          <input type="hidden" id="idCustomerEdit" name="idCustomerEdit">
          <label for="name">Nombre:</label>
          <input type="text" id="nameEdit" name="nameEdit" placeholder="Ingresa el nombre" required>

          <label for="message">Apellido:</label>
          <input type="text" id="lastNameEdit" name="lastNameEdit" placeholder="Ingresa el apellido" required>

          <label for="message">Dirección:</label>
          <input type="text" id="addressEdit" name="addressEdit" placeholder="Ingresa la dirección" required>

          <label for="message">Email:</label>
          <input type="text" id="emailEdit" name="emailEdit" placeholder="Ingresa el email" required>

          <label for="message">Usuario:</label>
          <input type="text" id="userEdit" name="userEdit" placeholder="Ingresa el usuario" required>

          <label for="message">Fecha de Nacimiento:</label>
          <input id="bornDateEdit" name="bornDateEdit" placeholder="Ingresa la fecha de nacimiento" required type="date">

          <a class="btn btn-primary" role="button" type="submit" id="btnSaveEdit">Guardar</a>

      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function viewModalEdit(idCustomer){
        $('#modalEdit').modal('show');
        // clearFields();

        $.ajax({
            url: '/customer/get',
            async: 'true',
            type: 'GET',
            dataType: 'json',
            data: {idCustomer: idCustomer},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                $('#idCustomerEdit').val(response.data.id);
                $('#nameEdit').val(response.data.nombre);
                $('#lastNameEdit').val(response.data.apellido);
                $('#addressEdit').val(response.data.direccion);
                $('#emailEdit').val(response.data.email);
                $('#userEdit').val(response.data.usuario);
                $('#bornDateEdit').val(response.data.fecha_nacimiento);


            },
            error: function(xhr, status, error) {
                // 
            }
        });
        
    }

    $('#btnSaveEdit').on("click",function() {
      const idCustomer = $('#idCustomerEdit').val();
      const nameEdit = $('#nameEdit').val();
      const lastNameEdit = $('#lastNameEdit').val();
      const addressEdit = $('#addressEdit').val();
      const emailEdit = $('#emailEdit').val();
      const userEdit = $('#userEdit').val();
      const bornDateEdit = $('#bornDateEdit').val();


      $.ajax({
            url: '/api/customer/update',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idCustomer: idCustomer, nameEdit: nameEdit, lastNameEdit: lastNameEdit, addressEdit:addressEdit, emailEdit: emailEdit, userEdit: userEdit, bornDateEdit: bornDateEdit},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#customer-table').DataTable().ajax.reload();
                $('#modalEdit').modal('hide');

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>