<div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Müştəri</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form id="create-form">
            @csrf
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="form-group">
                    <label for="name">Ad soyad</label>
                    <input type="text" name="fullname"  id="fullname" class="form-control" placeholder="Ad soyad" aria-describedby="helpId" required>
                  </div>
                </div>
                <div class="col-md-12 mt-2">
                  <div class="form-group">
                    <label for="name">VÖEN</label>
                    <input type="text" name="voen" id="voen" class="form-control" placeholder="VÖEN" aria-describedby="helpId" required>
                  </div>
                </div>
                <div class="col-md-12 mt-2">
                  <div class="form-group">
                    <label for="name">Email</label>
                    <input type="text" name="email"  id="email" class="form-control" placeholder="Email" aria-describedby="helpId" required>
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label for="name">Müçtəri Növü</label>
                      <select name="type_id" id="type_id" class="form-control">
                        <option value="">Müçtəri növü seçin</option>
                        @foreach ($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
             
                <div class="col-md-6 mt-2">
                  <div class="form-group">
                    <label for="name">Telfon</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefon" aria-describedby="helpId" required>
                  </div>
                </div>
              
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
          <h5 class="modal-title" id="exampleModalLabel">Müştəri düzəliş</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form id="edit-form">
            @csrf
            @method("PUT")
            <div id="inputs"></div>
             
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
          <button type="button" class="btn btn-success " id="edit-customer-type">Düzəliş et</button>
        </div>
      </div>
    </div>
  </div>