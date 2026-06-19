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
                    <label>Sual ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[question]" value="{{ old($lang->code.'.question', $item->translate($lang->code)?->question) }}" @if($loop->first) required @endif>
                </div>

                <div class="form-group mt-3">
                    <label>Cavab ({{ $lang->code }})</label>
                    <textarea class="form-control" name="{{ $lang->code }}[answer]" rows="3" @if($loop->first) required @endif>{{ old($lang->code.'.answer', $item->translate($lang->code)?->answer) }}</textarea>
                </div>

            </div>
        @endforeach
    </div>

    <div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kateqoriya</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $item->category ?? 'general') }}">
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
                    <label>Xidmət (Opsional)</label>
                    <select name="service_id" class="form-control">
                        <option value="">Ümumi (Heç biri)</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $item->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} ({{ $service->is_active ? 'Active' : 'Inactive' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
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
