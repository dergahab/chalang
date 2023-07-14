<div class="col-md-12 pt-4" style="position: relative">
    <div class="row border border-success">
        @foreach ($langs as $l)
            <div class="col-md-12 pt-3">
                <div class="form-group">
                    <label for="">Basliq [{{$l->lang}}]</label>
                    <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="col-md-12 pt-1">
                <div class="form-group">
                    <label for="">Mezmun [{{$l->lang}}]</label>
                    <textarea name="" class="form-control" cols="30" rows="3"></textarea>
                </div>
            </div>
        @endforeach
        <div class="col-md-12 p-3">
            <div class="form-group">
            <label for="">Icon</label>
            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
    </div>
    <button class="btn btn-danger trash" type="button" style="position: absolute; top: 12px; right: 2px;"><i class="fas fa-trash"></i></button>
</div>