<div class="row">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach($langs as $lang)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if($loop->first) active @endif" id="{{ $lang->code }}-tab" data-bs-toggle="tab"
                    data-bs-target="#{{ $lang->code }}-edit" type="button" role="tab"
                    aria-controls="{{ $lang->code }}"
                    aria-selected="true">{{ $lang->code }}</button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-3 " id="myTabContent">
        @foreach($langs as $lang)
            <div class="tab-pane fade @if($loop->first) show active @endif " 
                id="{{ $lang->code }}-edit"
                role="tabpanel" 
                aria-labelledby="{{ $lang->code }}-tab">
                
                <div class="form-group">
                    <label>Təsvir ({{ $lang->code }})</label>
                    <textarea class="form-control" name="{{ $lang->code }}[description]" rows="3">{{ old($lang->code.'.description', $item->translate($lang->code)?->description) }}</textarea>
                </div>

            </div>
        @endforeach
    </div>

    <div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ad</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Link</label>
                    <input type="text" name="link" class="form-control" value="{{ old('link', $item->link) }}">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @if($item->logo)
                        <img src="{{ asset('storage/' . $item->logo) }}" width="100" class="mt-2">
                    @endif
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label>Sıra</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch mt-4">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Aktiv</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
