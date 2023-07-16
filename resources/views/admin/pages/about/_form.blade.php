<div class="row">
>
    <div class="tab-content mt-3 " id="myTabContent">
        @foreach($langs as $lang)
            <div class="tab-pane  fade @if($loop->first) show active @endif " 
                id="{{ $lang->country }}-edit"
                role="tabpanel" 
                aria-labelledby="{{ $lang->country }}-tab">
                <div class="form-group ">
                    <label for="name">Başlıq ({{ $lang->lang }}) </label>
                    <input type="text" value="{{old('title',$item->translate($lang->lang)?->title)}}"
                        name="name[{{ $lang->lang }}]" 
                        id="company" class="form-control"
                        placeholder="Kateqoriya adı "
                        @if($loop->first) required @endif >
                </div>
                <div class="form-group mt-3 ">
                    <label for="name">Məzmun ({{ $lang->lang }}) </label>
                        <textarea class="form-control editor" name="description[{{ $lang->lang }}]"  
                            id="" cols="30" rows="10"  
                           novalidate>{{old("description",$item->translate($lang->lang)?->description)}}</textarea>
                </div>
            </div>
            @endforeach
    </div>

  

    <div class="col-6">
        <label for="file" class="form-label ">Şəkil <span class="text-danger">680x780</span></label>
        <input name="image" class="form-control filestyle file" type="file"
            data-buttonname="btn-secondary">
            <img src="{{asset(Storage::url($item->image))}}" width="300px" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
    </div>
    
    <div class="col-6">
        <label for="file" class="form-label ">video </label>
        <input name="video" class="form-control filestyle file" type="file"
            data-buttonname="btn-secondary">
            <video src="{{asset(Storage::url($item->video))}}" width="300px" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">
    </div>
</div>