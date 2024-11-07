
<div id="modalEdit" class="modal bottom-sheet col s12">
  <div class="modal-content">
      <h4>Editar Cliente</h4>
      <form action="#" method="post">
          <input type="hidden" id="idClienteEdit" name="idClienteEdit">
          <label for="name">Nombre:</label>
          <input type="text" id="nameEdit" name="nameEdit" placeholder="Ingresa el nombre" required>

          <label for="usuario">Usuario:</label>
          <input id="usuarioEdit" name="usuarioEdit" rows="4" placeholder="Escribe el usuario" required></input>

          <label for="email">Email:</label>
          <input id="emailEdit" name="emailEdit" rows="4" placeholder="Escribe el email" required></input>

          <a type="submit" class="waves-effect waves-light btn" id="btnSaveEdit">Guardar</a>
      </form>
  </div>
</div>

<script type="text/javascript">
    function viewModalEdit(idRol){
        console.log('viewModalEdit');
        clearFields();
        $.ajax({
            url: '/api/customer/get',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idCliente: idCliente},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'App-Token': <?= h($appTokenEnv); ?>,
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                const rolData = response.data; 
                $('#idRolEdit').val(rolData.rol_id);
                $('#nameEdit').val(rolData.name);
                $('#descriptionEdit').val(rolData.description);
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }

    $('#btnSaveEdit').on("click",function() {
      console.log('save Edit');
      const idCliente = $('#idClienteEdit').val();
      const nameEdit = $('#nameEdit').val();
      const descriptionEdit = $('#descriptionEdit').val();
      $.ajax({
            url: '/api/customer/update',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idCliente: idCliente, nameEdit: nameEdit, usuarioEdit: usuarioEdit},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'App-Token': <?= h($appTokenEnv); ?>,
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#clientes-table').DataTable().ajax.reload();
                var modalEditI = M.Modal.getInstance(document.querySelector('#modalEdit'));
                modalEditI.close();

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>