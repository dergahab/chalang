<div class="col-12 m-3">
    @foreach($langs as $lang)
        <div class="input-container row">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="name">Başlıq ({{ $lang->lang }}) </label>
                        <input type="text" value="{{ old('title') }}"
                            name="subname[{{ $lang->lang }}][]" id="company" class="form-control"
                            placeholder="Kateqoriya adı " @if($loop->first) required @endif>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="name">Icon </label>
                        <input type="text" name="subimage" id="company" class="form-control"
                            placeholder="Kateqoriya adı " @if($loop->first) required @endif>
                    </div>
                </div>

                <div class="form-group mt-3 ">
                    <label for="name">Məzmun ({{ $lang->lang }}) </label>
                    <textarea class="form-control" name="subdescription[{{ $lang->lang }}][]" id="" cols="30" rows="/"
                        @if($loop->first) required @endif >{{ old("description") }}</textarea>

                </div>
            </div>
        </div>
    @endforeach
    <div class="col-12 mt-2">
        <button class="btn btn-danger float-end remove-btn" type="button">Sil</button>
    </div>
</div>