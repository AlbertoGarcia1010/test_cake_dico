<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="#" method="post">
          <input type="hidden" id="idProductDelete" name="idProductDelete">
          <p>¿Estas seguro de eliminar el registro <b><span id="upcDelete"></span></b>?</p>
          <p>Una vez eliminado ya no podrás recuperarlo.</p>

          <a class="btn btn-danger" role="button" type="submit" id="btnSaveDelete">Eliminar</a>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function viewModalDelete(idProduct){
        $('#modalDelete').modal('show');
        // clearFields();
        $.ajax({
            url: '/product/get',
            async: 'true',
            type: 'GET',
            dataType: 'json',
            data: {idProduct: idProduct},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                const productData = response.data; 
                $('#idProductDelete').val(productData.upc);
                $('#upcDelete').text(productData.upc);
            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }

    $('#btnSaveDelete').on("click",function() {
      console.log('save Delete');
      const idProduct = $('#idProductDelete').val();
      $.ajax({
            url: '/api/product/delete',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idProduct: idProduct},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#product-table').DataTable().ajax.reload();
                $('#modalDelete').modal('hide');


            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>