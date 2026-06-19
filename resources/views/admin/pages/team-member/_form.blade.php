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
                    <label>Ad ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[name]" value="{{ old($lang->code.'.name', $item->translate($lang->code)?->name) }}" @if($loop->first) required @endif>
                </div>

                <div class="form-group mt-3">
                    <label>Vəzifə ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[position]" value="{{ old($lang->code.'.position', $item->translate($lang->code)?->position) }}">
                </div>

                <div class="form-group mt-3">
                    <label>Bio ({{ $lang->code }})</label>
                    <textarea class="form-control" name="{{ $lang->code }}[bio]" rows="3">{{ old($lang->code.'.bio', $item->translate($lang->code)?->bio) }}</textarea>
                </div>

                <div class="form-group mt-3">
                    <label>İxtisaslar ({{ $lang->code }}) - Hər sətirdə bir</label>
                    <textarea class="form-control" name="{{ $lang->code }}[specialties]" rows="3">{{ old($lang->code.'.specialties', $item->translate($lang->code)?->specialties ? implode("\n", $item->translate($lang->code)->specialties) : '') }}</textarea>
                </div>

            </div>
        @endforeach
    </div>

    <div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Şəkil</label>
                    <input type="file" name="image" class="form-control">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" width="100" class="mt-2">
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sosial Linklər (Format: platform:link - Hər sətirdə bir)</label>
                    @php
                        $socialLinksString = '';
                        if($item->social_links) {
                            foreach($item->social_links as $key => $value) {
                                $socialLinksString .= $key . ':' . $value . "\n";
                            }
                        }
                    @endphp
                    <textarea class="form-control" name="social_links" rows="5">{{ old('social_links', trim($socialLinksString)) }}</textarea>
                </div>
            </div>
        </div>

        <div class="row mt-3">
             <div class="col-md-6">
                <div class="form-group">
                    <label>Sıra</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-control custom-switch mt-4">
                        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_featured">Seçilmiş</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
