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
                <input type="text" value="{{old('title',$item->translate($lang->lang)?->title)}}"
                    name="name[{{ $lang->lang }}]"
                    id="company" class="form-control"
                    placeholder="Kateqoriya adı "
                    @if($loop->first) required @endif >
            </div>
            <div class="form-group mt-3 ">
                <label for="name">Məzmun ({{ $lang->lang }}) </label>
                <textarea class="form-control"
                name="description[{{ $lang->lang }}]"
                id="" cols="30" rows="10"
                @if($loop->first) required @endif>{{ old('description.' . $lang->lang, $item->translate($lang->lang)?->description) }}</textarea>

            </div>
        </div>
        @endforeach
</div>

<div class="form-group mt-3 ">
    <label for="name">Kategoriya ({{ $lang->lang }}) </label>
   <select name="pcategory_id[]" id="" class="form-control select2" multiple>
    @foreach ($categories as $category)
        <option @if(in_array($category->id, $item->category_ids)) selected @endif value="{{$category->id}}">{{$category->name}}</option>
    @endforeach
   </select>
</div>
<div class="form-group mt-3 ">
    <label for="name">Şirkət  </label>
   <select name="company_id" id="" class="form-control select2" >
    @foreach ($companies as $company)
        <option @if($company->id = $company->id) selected @endif value="{{$company->id}}">{{$company->name}}</option>
    @endforeach
   </select>
</div>

    <div class="form-group mt-3">
        <div class="form-check">
            <input type="hidden" name="in_main" value="0">
            <input class="form-check-input" type="checkbox" name="in_main" id="in_main"
                   value="1" {{ (int)old('in_main', $item->in_main) === 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="in_main">
                Əsas səhifədə göstər
            </label>
        </div>
    </div>
<div class="col-md-12">
    <div class="row">
        <div class="@if($item->image) col-md-6 @else col-md-12 @endif">
            <div class="form-group">
                <label for="file" class="form-label ">Şəkil <span class="text-danger">1000x700</span></label>
                <input name="image" class="form-control filestyle file" type="file"
                    data-buttonname="btn-secondary">
            </div>
        </div>
        @if($item->image)

        <div class="col-md-6 pt-3">
                <img src="{{asset('storage/' . $item->image)}}" width="200px" height="200PX" srcset="">
        </div>
        @endif

    </div>
</div>

</div>
