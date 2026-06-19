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
                    <label>Rəy ({{ $lang->code }})</label>
                    <textarea class="form-control" name="{{ $lang->code }}[content]" rows="3">{{ old($lang->code.'.content', $item->translate($lang->code)?->content) }}</textarea>
                </div>

            </div>
        @endforeach
    </div>

    <div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Platforma</label>
                    <input type="text" name="platform" class="form-control" value="{{ old('platform', $item->platform ?? 'custom') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Reytinq (1-5)</label>
                    <input type="number" name="rating" class="form-control" min="1" max="5" value="{{ old('rating', $item->rating ?? 5) }}">
                </div>
            </div>
        </div>

        <div class="row mt-3">
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
                    <label>Sıra</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Layihə Növü (Məs: B2B E-commerce)</label>
                    <input type="text" name="project_type" class="form-control" value="{{ old('project_type', $item->project_type) }}">
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label>Nəticə (Məs: +120% Conversion)</label>
                    <input type="text" name="outcome" class="form-control" value="{{ old('outcome', $item->outcome) }}">
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
                <div class="form-group mt-3">
                    <label>Əlaqəli Xidmət</label>
                    <select name="service_id" class="form-control select2">
                        <option value="">Seçin...</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $item->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
