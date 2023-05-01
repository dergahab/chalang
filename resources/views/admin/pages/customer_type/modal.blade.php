<div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yeni Müştəri növü</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form id="create-form">
            <div class="form-group">
              <label for="name">Növ adı</label>
              <input type="text"  id="name" class="form-control" placeholder="Növ adı" aria-describedby="helpId" required>
            </div>
           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
          <button type="button" class="btn btn-success " id="save-customer-type">Əlavə et</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="customer-type-modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Vəzifə düzəliş</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form id="edit-form">
            @csrf
            @method("PUT")
            <div class="form-group">
              <label for="name">Vəzifə adı</label>
              <input type="text" name="name" id="edit-name" class="form-control" placeholder="Departamnet adı" aria-describedby="helpId" required>
            </div>
            <input type="hidden" name="id" id="edit-id">
           </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
          <button type="button" class="btn btn-success " id="edit-customer-type">Düzəliş et</button>
        </div>
      </div>
    </div>
  </div>