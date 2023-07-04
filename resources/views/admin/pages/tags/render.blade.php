<ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach($langs as $lang)
        <li class="nav-item" role="presentation">
            <button class="nav-link @if($loop->first) active @endif" id="{{$lang->lang }}-tab" data-bs-toggle="tab"
                data-bs-target="#{{ $lang->country }}" type="button" role="tab"
                aria-controls="{{ $lang->country }}"
                aria-selected="true">{{ $lang->country }}</button>
        </li>
    @endforeach
</ul>
<div class="tab-content pt-3" id="myTabContent">
    <form action="{{route('admin.tag.store')}}" method="POST" id="saveForm">
        @csrf
    @foreach($langs as $lang)
        <div class="tab-pane  fade   @if($loop->first)show active @endif " id="{{ $lang->country }}"
            role="tabpanel" aria-labelledby="{{ $lang->country }}-tab">
            <div class="form-group ">
                <label for="name">Tag adı ({{ $lang->lang }}) </label>
                <input type="text" name="name[{{ $lang->lang }}]" id="company" class="form-control"
                    placeholder="Kateqoriya adı " aria-describedby="helpId" @if($loop->first) required
                @endif >
            </div>
        </div>
    @endforeach
</div>