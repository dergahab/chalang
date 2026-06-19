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
                    <label>Başlıq ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[title]" value="{{ old($lang->code.'.title', $item->translate($lang->code)?->title) }}" @if($loop->first) required @endif>
                </div>

                <div class="form-group mt-3">
                    <label>Slug ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[slug]" value="{{ old($lang->code.'.slug', $item->translate($lang->code)?->slug) }}" @if($loop->first) required @endif>
                </div>

                <div class="form-group mt-3">
                    <label>Kateqoriya ({{ $lang->code }})</label>
                    <input type="text" class="form-control" name="{{ $lang->code }}[category]" value="{{ old($lang->code.'.category', $item->translate($lang->code)?->category) }}">
                </div>

                <div class="form-group mt-3">
                    <label>Problem ({{ $lang->code }})</label>
                    <textarea class="form-control" name="{{ $lang->code }}[problem]" rows="3">{{ old($lang->code.'.problem', $item->translate($lang->code)?->problem) }}</textarea>
                </div>

                <div class="form-group mt-3">
                    <label>Həll ({{ $lang->code }})</label>
                    <textarea class="form-control" name="{{ $lang->code }}[solution]" rows="3">{{ old($lang->code.'.solution', $item->translate($lang->code)?->solution) }}</textarea>
                </div>

                <div class="form-group mt-3">
                    <label>Nəticə ({{ $lang->code }})</label>
                    <textarea class="form-control" name="{{ $lang->code }}[result]" rows="3">{{ old($lang->code.'.result', $item->translate($lang->code)?->result) }}</textarea>
                </div>

            </div>
        @endforeach
    </div>

    <div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Cover Şəkli</label>
                    <input type="file" name="cover_image" class="form-control">
                    @if($item->cover_image)
                        <img src="{{ asset('storage/' . $item->cover_image) }}" width="100" class="mt-2">
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Qalereya Şəkilləri</label>
                    <input type="file" name="gallery_images[]" class="form-control" multiple>
                    @if($item->gallery_images)
                        <div class="mt-2">
                            @foreach($item->gallery_images as $img)
                                <img src="{{ asset('storage/' . $img) }}" width="50" class="mr-1">
                            @endforeach
                        </div>
                    @endif
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
                        <input type="checkbox" class="custom-control-input" id="in_main" name="in_main" value="1" {{ old('in_main', $item->in_main) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="in_main">Ana səhifədə göstər</label>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label>Əlaqəli Xidmətlər</label>
                    <select name="services[]" class="form-control select2" multiple>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ in_array($service->id, old('services', $item->services->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
