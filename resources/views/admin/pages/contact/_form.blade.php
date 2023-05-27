<div class="row">
    <div class="form-group">
        <label for="">Telefon</label>
        <input type="text" name="phone" value="{{old('phone', $item->phone)}}" id="" class="form-control" placeholder="" aria-describedby="helpId">
    </div>
    <div class="form-group pt-2">
        <label for="">Email</label>
        <input type="text" name="email" value="{{old('mail', $item->mail)}}" id="" class="form-control" placeholder="" aria-describedby="helpId">
    </div>
    <div class="form-group pt-1">
        <label for="">Ünvan</label>
        <input type="text" name="address" value="{{old('address', $item->address)}}" id="" class="form-control" placeholder="" aria-describedby="helpId">
    </div>
</div>