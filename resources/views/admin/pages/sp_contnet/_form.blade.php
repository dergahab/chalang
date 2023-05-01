<div class="row">
    <div class="col-md-5">
        <div class="form-group">
          <label for="">Servis</label>
          <select name="service" id="" class="form-control">
              <option value="">Seуçin...</option>
            @foreach ($services as $service)
                 <option value="{{$service->id}}">{{$service->name}}</option>
            @endforeach
          </select>
        </div>
    </div>
    <div class="col-md-2 d-flex justify-content-center">
        <label for="">VƏYA</label>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="">Portfolio</label>
            <select name="portfolio" id="" class="form-control">
                <option value="">Seуçin...</option>
              @foreach ($portfolios as $portfolio)
                  <option value="{{$portfolio->id}}">{{$portfolio->title}}</option>
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
                <input type="text" value="{{old('title')}}"
                    name="name[{{ $lang->lang }}]" 
                    id="company" class="form-control"
                    placeholder="Kateqoriya adı "
                    @if($loop->first) required @endif >
            </div>
            <div class="form-group mt-3 ">
                <label for="name">Məzmun ({{ $lang->lang }}) </label>
                    <textarea class="form-control" name="description[{{ $lang->lang }}]"  id="" cols="30" rows="4"   @if($loop->first) required @endif >{{old("description")}}</textarea>
            </div>
            <hr>
          
        </div>
    @endforeach
</div>
<div class="col-12">
    <div class="contents row border border-danger">
           
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
@endpush