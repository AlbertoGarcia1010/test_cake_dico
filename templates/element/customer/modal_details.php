<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ver Detalles del Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Nombre: <span id="name"></span></p>
        <p>Descripción: <span id="description"></span></p>
        <p>Status: <span id="status"></span></p>
        <p>Fecha de creación: <span id="dateCreate"></span></p>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    
  function viewModalDetail(idCliente){
        console.log('viewModalDetail');
        $('#modalDetails').modal('show');
        
    }
        

</script>