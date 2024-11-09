
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="#" method="post">
          <input type="hidden" id="idProductEdit" name="idProductEdit">
          <label for="name">UPC:</label>
          <input class="form-control"  id="upcEdit" name="upcEdit" placeholder="Ingresa el UPC" disabled>

          <label for="name">Descripción:</label>
          <textarea id="descriptionEdit" name="descriptionEdit" placeholder="Ingresa la descripción" required></textarea>

          <label for="name">Costo:</label>
          <input type="text" id="costEdit" name="costEdit" placeholder="Ingresa el costo" required>

          <label for="name">Precio:</label>
          <input type="text" id="priceEdit" name="priceEdit" placeholder="Ingresa el precio" required>

          <label for="name">Existencia:</label>
          <input type="text" id="inventoryEdit" name="inventoryEdit" placeholder="Ingresa las existencias" required>

          <a class="btn btn-primary" role="button" type="submit" id="btnSaveEdit">Guardar</a>

      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function viewModalEdit(idProduct){
        $('#modalEdit').modal('show');
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
                $('#idProductEdit').val(response.data.upc);
                $('#upcEdit').val(response.data.upc);
                $('#descriptionEdit').val(response.data.descripcion);
                $('#costEdit').val(response.data.costo);
                $('#priceEdit').val(response.data.precio);
                $('#inventoryEdit').val(response.data.existencia);

            },
            error: function(xhr, status, error) {
                // 
            }
        });
        
    }

    $('#btnSaveEdit').on("click",function() {
      const idProduct = $('#idProductEdit').val();
      const upcEdit = $('#upcEdit').val();
      const descriptionEdit = $('#descriptionEdit').val();
      const costEdit = $('#costEdit').val();
      const priceEdit = $('#priceEdit').val();
      const inventoryEdit = $('#inventoryEdit').val();

      $.ajax({
            url: '/api/product/update',
            async: 'true',
            type: 'POST',
            dataType: 'json',
            data: {idProduct: idProduct, upcEdit: upcEdit, descriptionEdit: descriptionEdit, costEdit:costEdit, priceEdit: priceEdit, inventoryEdit: inventoryEdit},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);

                $('#product-table').DataTable().ajax.reload();
                $('#modalEdit').modal('hide');

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    });
</script>