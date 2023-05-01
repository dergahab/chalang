<div class="row">
    <div class="col-md-4">
        <div class="form-group ">
            <label for="name">Adı</label>
            <input type="text" value="{{old('name',$item->name)}}" 
                name="name" 
                id="name" class="form-control"
                placeholder="Adı" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group ">
            <label for="name">Link</label>
            <input type="text" value="{{old('link',$item->link)}}" 
                name="link" 
                id="name" class="form-control"
                placeholder="Link" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group ">
            <label for="name">İkon kodu</label>
            <input type="text" value="{{old('icon',$item->icon)}}" 
                name="icon" 
                id="icon" class="form-control"
                placeholder="İkon kodu" required>
        </div>
    </div>
</div>