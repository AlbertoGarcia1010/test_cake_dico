<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="#" method="post">
          <input type="hidden" id="idCustomerDelete" name="idCustomerDelete">
          <p>¿Estas seguro de eliminar el registro <b><span id="nameDelete"></span></b>?</p>
          <p>Una vez eliminado ya no podrás recuperarlo.</p>

          <a class="btn btn-danger" role="button" type="submit" id="btnSaveDelete">Eliminar</a>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function viewModalDelete(idCustomer){
        $('#modalDelete').modal('show');
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
                const customerData = response.data; 
                $('#idCustomerDelete').val(customerData.id);
                $('#nameDelete').text(customerData.nombre);
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }

    $('#btnSaveDelete').on("click",function() {
      console.log('save Delete');
      const idCustomer = $('#idCustomerDelete').val();
      $.ajax({
            url: '/api/customer/delete',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idCustomer: idCustomer},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#customer-table').DataTable().ajax.reload();
                $('#modalDelete').modal('hide');


            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>