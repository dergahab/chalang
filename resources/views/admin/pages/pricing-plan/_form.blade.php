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
                    <label>Plan Adı ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[name]" value="{{ old($lang->code.'.name', $item->translate($lang->code)?->name) }}" @if($loop->first) required @endif>
                </div>

                <div class="form-group mt-3">
                    <label>Xüsusiyyətlər ({{ $lang->code }}) - Hər sətirdə bir xüsusiyyət</label>
                    <textarea class="form-control" name="{{ $lang->code }}[features]" rows="5">{{ old($lang->code.'.features', $item->translate($lang->code)?->features ? implode("\n", $item->translate($lang->code)->features) : '') }}</textarea>
                </div>

                <div class="form-group mt-3">
                    <label>CTA Mətni ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[cta_text]" value="{{ old($lang->code.'.cta_text', $item->translate($lang->code)?->cta_text) }}">
                </div>

            </div>
        @endforeach
    </div>

    <div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Aylıq Qiymət</label>
                    <input type="number" step="0.01" name="price_monthly" class="form-control" value="{{ old('price_monthly', $item->price_monthly) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>İllik Qiymət</label>
                    <input type="number" step="0.01" name="price_yearly" class="form-control" value="{{ old('price_yearly', $item->price_yearly) }}">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>CTA Link</label>
                    <input type="text" name="cta_link" class="form-control" value="{{ old('cta_link', $item->cta_link) }}">
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
             <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch mt-4">
                        <input type="checkbox" class="custom-control-input" id="is_popular" name="is_popular" value="1" {{ old('is_popular', $item->is_popular) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_popular">Populyar</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
