<div class="row"><ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach($langs as $lang)
        <li class="nav-item" role="presentation">
            <button class="nav-link @if($loop->first) active @endif" id="{{ $lang->country }}-tab" data-bs-toggle="tab"
                data-bs-target="#{{ $lang->country }}-edit" type="button" role="tab"
                aria-controls="{{ $lang->country }}"
                aria-selected="true">{{ $lang->country }}</button>
        </li>
    @endforeach
</ul>
<div class="tab-content mt-3 " id="myTabContent">
    @foreach($langs as $lang)
        <div class="tab-pane  fade @if($loop->first) show active @endif " 
            id="{{ $lang->country }}-edit"
            role="tabpanel" 
            aria-labelledby="{{ $lang->country }}-tab">
            <div class="form-group ">
                <label for="name">Kateqoriya adı ({{ $lang->lang }}) </label>
                <input type="text" value="{{$item->translate($lang->lang)?->name}}" 
                    name="name[{{ $lang->lang }}]" 
                    id="company" class="form-control"
                    placeholder="Kateqoriya adı "
                    @if($loop->first) required @endif >
            </div>
        </div>
        @endforeach
</div>

</div>