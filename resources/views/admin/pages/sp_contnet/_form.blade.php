<div class="row">
    @if ($errors->has('name'))
    <div class="alert alert-danger">
        {{ $errors->first('name') }}
    </div>
@endif
    <div class="col-md-12">
        <div class="form-group">
          <label for="">Servis</label>
          <select name="service_id" id="" class="form-control">
              <option value="">Seуçin...</option>
            @foreach ($services as $service)
                 <option @if ($item->service_id == $service->id) selected @endif value="{{$service->id}}">{{$service->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
</div>
<div class="row mt-3">
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
                <input type="text"
                    name="name[{{ $lang->lang }}]" 
                    id="company" class="form-control"
                    placeholder="Kateqoriya adı "
                    value="{{old('name['.$lang->lang.']', $item->translate($lang->lang)?->title)}}"
                    @if($loop->first) required @endif >
            </div>
            <div class="form-group mt-3 ">
                <label for="name">Məzmun ({{ $lang->lang }}) </label>
                    <textarea class="form-control" name="description[{{ $lang->lang }}]"  id="" cols="30" rows="4"   @if($loop->first) required @endif >{{old('description['.$lang->lang.']', $item->translate($lang->lang)?->content)}}</textarea>
            </div>
            <hr>
          
        </div>
    @endforeach
</div>
<div class="col-12">
    <div class="contents row">
           
    </div>
    <button type="button" class="btn btn-primary mt-1 float-end " id="add-btn"><i class="fas fa-plus" title="Əlavə et"></i></button>
</div>
</div>

@push('js_stack')
   <script>
		$(document).ready(function() {
			$('#add-btn').click(function() {
			    $('.contents').append(`@include('admin.pages.sp_contnet.partials.content')`);
			});

			$(document).on('click', '.remove-btn', function() {
				$(this).parent().parent().remove();
			});
		});
	</script>
    <script>
        $('.trash').click(function (e) { 
            e.preventDefault();
            $(this).parent().remove()
        });
    </script>
@endpush