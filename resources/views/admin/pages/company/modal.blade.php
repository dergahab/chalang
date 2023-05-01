<div class="modal fade" id="company-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yeni sirket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form" action="{{ route('admin.company.store') }}" method="Post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Şirkət adı</label>
                        <input type="text" name="company" id="company" class="form-control"
                            placeholder="Departamnet adı" aria-describedby="helpId" required>
                    </div>
                    <div class="form-group">
                        <label for="category" class="form-label ">Logo <span class="text-danger">230x133</span></label>
                        <input name="file" class="form-control filestyle file" type="file"
                            data-buttonname="btn-secondary">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
                <button type="submit" class="btn btn-success " id="save-departament">Əlavə et</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="company-modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Şirkət düzəliş</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="edit-body">
         
            </div>
        </div>
    </div>
</div>