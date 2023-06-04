<div class="row">
    <div class="form-group mt-3 ">
        <label for="name">Üst servislər </label>
       <select name="parent_id" id="" class="form-control select2" >
        <option  value="0">Üst servis seçin</option>
        @foreach ($services as $service)
            <option @if($item->parent_id == $service->id) selected @endif value="{{$service->id}}">{{$service->name}}</option>
        @endforeach
       </select>
    </div>

    <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
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
                <label for="name">Başlıq ({{ $lang->lang }}) </label>
                <input type="text" value="{{old('name',$item->translate($lang->lang)?->name)}}"
                    name="name[{{ $lang->lang }}]" 
                    id="company" class="form-control"
                    placeholder="Kateqoriya adı "
                    @if($loop->first) required @endif >
            </div>
            <div class="form-group">
                <label for="content-{{$lang->lang}}">Məzmun (Kicik)</label>
                <textarea name="description[{{$lang->lang}}]" id="" cols="5" class="form-control" rows="4">{{old('description',$item->translate($lang->lang)?->description)}}</textarea>
            </div>
            <div class="form-group">
                <label for="content-{{$lang->lang}}">Məzmun</label>
                <textarea name="content[{{$lang->lang}}]" id="" cols="5" class="form-control" rows="4">{{old('content',$item->translate($lang->lang)?->content)}}</textarea>
            </div>
        </div>
        @endforeach
</div>


<div class="col-md-6 mt-2">
<div class="form-group">
    <label for="file" class="form-label ">Icon <span class="text-danger" required>100x90</span></label>
    <input name="icon" class="form-control filestyle file" type="file"
        data-buttonname="btn-secondary" @if(request()->routeIs('admin.service.create')) required @endif>
</div>
<img src="{{asset(Storage::url($item->icon))}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
</div>

<div class="col-md-6 mt-2">
    <div class="form-group">
        <label for="file" class="form-label ">Şəkil <span class="text-danger">610x460</span></label>
        <input name="image" class="form-control filestyle file" type="file"
        data-buttonname="btn-secondary">
    </div>
    <img src="{{asset(Storage::url($item->image))}}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
</div>

</div>
