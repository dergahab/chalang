<input type="hidden" name="user_id" value="{{auth()->user()->id}}">
<input type="hidden" name="id" id="edit-id" value="{{$item->id}}">
<div class="row">
  <div class="col-md-12 mt-2">
    <div class="form-group">
      <label for="name">Ad soyad</label>
      <input type="text" name="fullname"  id="fullname" value="{{$item->fullname}}" class="form-control" placeholder="Ad soyad" aria-describedby="helpId" required>
    </div>
  </div>
  <div class="col-md-12 mt-2">
    <div class="form-group">
      <label for="name">VÖEN</label>
      <input type="text" name="voen" id="voen" value="{{$item->voen}}" class="form-control" placeholder="VÖEN" aria-describedby="helpId" required>
    </div>
  </div>
  <div class="col-md-6 mt-2">
    <div class="form-group">
      <label for="name">Müçtəri Növü</label>
        <select name="type_id" id="type_id" class="form-control">
          <option value="">Müçtəri növü seçin</option>
          @foreach ($types as $type)
          <option @if($type->id == $item->type_id) selected @endif value="{{$type->id}}">{{$type->name}}</option>
          @endforeach
        </select>
    </div>
  </div>

  <div class="col-md-6 mt-2">
    <div class="form-group">
      <label for="name">Telfon</label>
      <input type="text" name="phone" id="phone" value="{{$item->phone}}" class="form-control" placeholder="Telefon" aria-describedby="helpId" required>
    </div>
  </div>
  <div class="col-md-12 mt-2">
    <div class="form-group">
      <label for="name">Email</label>
      <input type="text" name="email"  id="email" value="{{$item->email}}" class="form-control" placeholder="Email" aria-describedby="helpId" required>
    </div>
  </div>
</div>