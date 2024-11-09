<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ver Detalles del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>UPC: <span id="upc"></span></p>
        <p>Descripción: <span id="description"></span></p>
        <p>Costo: <span id="cost"></span></p>
        <p>Precio: <span id="price"></span></p>
        <p>Existencia: <span id="inventory"></span></p>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    
  function viewModalDetail(idProduct){
        $('#modalDetails').modal('show');
        $.ajax({
            url: '/product/get',
            async: 'true',
            type: 'GET',
            dataType: 'json',
            data: {idProduct: idProduct},
            headers: {
                'contentType': 'application/json; charset=UTF-8',
                // 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("response: ", response);
                
                const productData = response.data; 
                $('#upc').text(productData.upc);
                $('#description').text(productData.descripcion);
                $('#cost').text(`$ ${productData.costo}`);
                $('#price').text(`$ ${productData.precio}`);
                $('#inventory').text(productData.existencia);

            },
            error: function(xhr, status, error) {
                // 
            }
        });
    }
        

</script>