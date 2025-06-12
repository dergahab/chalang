<div class="row">
    <!-- Language Tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach($langs as $lang)
            <li class="nav-item" role="presentation">
                <a
                        class="nav-link @if($loop->first) active @endif"
                        id="{{ $lang->country }}-tab"
                        data-bs-toggle="tab"
                        href="#{{ $lang->country }}-edit"
                        role="tab"
                        aria-controls="{{ $lang->country }}-edit"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $lang->lang }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content mt-3" id="myTabContent">
        @foreach($langs as $lang)
            <div
                    class="tab-pane fade @if($loop->first) show active @endif"
                    id="{{ $lang->country }}-edit"
                    role="tabpanel"
                    aria-labelledby="{{ $lang->country }}-tab">

                <div class="form-group">
                    <label for="name">Başlıq ({{ $lang->lang }})</label>
                    <input type="text"
                           value="{{ old('title', $item?->translate($lang->lang)?->title) }}"
                           name="name[{{ $lang->lang }}]"
                           id="company"
                           class="form-control"
                           placeholder="Başlıq"
                           @if($loop->first) required @endif>
                </div>

                <div class="form-group mt-3">
                    <label for="description">Məzmun ({{ $lang->lang }})</label>
                    <textarea class="form-control editor"
                              name="description[{{ $lang->lang }}]"
                              cols="30" rows="10"
                              novalidate>{{ old('description', $item?->translate($lang->lang)?->description) }}</textarea>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Image Upload -->
    <div class="col-6 mt-4">
        <label for="file" class="form-label">Şəkil <span class="text-danger">680x780</span></label>
        <input name="image" class="form-control filestyle file" type="file" data-buttonname="btn-secondary">
        @if($item?->image)
            <img src="{{ asset(Storage::url($item->image)) }}" width="300px" class="img-fluid mt-2" alt="">
        @endif
    </div>

    <!-- Video Upload -->
    <div class="col-6 mt-4">
        <label for="file" class="form-label">Video</label>
        <input name="video" class="form-control filestyle file" type="file" data-buttonname="btn-secondary">
        @if($item?->video)
            <video controls src="{{ asset(Storage::url($item->video)) }}" width="300px" class="img-fluid mt-2"></video>
        @endif
    </div>
</div>
