<div class="row">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
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
                    <input type="text" value="{{old("title[$lang->lang ]",$item->translate($lang->lang)?->title)}}"
                        name="name[{{ $lang->lang }}]"
                        id="company" class="form-control"
                        placeholder="Kateqoriya adı " >
                </div>
                <div class="form-group mt-3 ">
                    <label for="name">Məzmun ({{ $lang->lang }}) </label>
                        <textarea class="form-control editor" name="content[{{ $lang->lang }}]"
                            id="" cols="30" rows="10"
                           novalidate>{{old("content[$lang]",$item->translate($lang->lang)?->content)}}</textarea>
                </div>
            </div>
            @endforeach
    </div>
    <div class="form-group ">
        <label for="name">Url </label>
        <input type="text" value="{{old("url",$item->url)}}"
            name="url"
            id="company" class="form-control"
            placeholder="Url ">
    </div>
    <div class="col-6">
        <label for="file" class="form-label ">Şəkil <span class="text-danger">940x666</span></label>
        <input name="image" class="form-control filestyle file" type="file"
            data-buttonname="btn-secondary">
            <img src="{{ asset('storage/'.$item->image) }}" width="300px" class="" alt="Banner">
    </div>
</div>
