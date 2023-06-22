<div class="row">
    
        <div class="col-md-12">
            <div class="form-group">
                <label > Açar söz </label>
              
                <input class="form-control"
                    value="{{ old('key' ,$item->key) }}"
                    name="key" 
                    
                    @if(Route::currentRouteName() !== 'admin.content-text.create')
                         disabled
                    @endif  
>
            </div>
        </div>
  
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            @foreach(config('app.locales') as $lang)
            <li class="nav-item">
                <a class="nav-link @if($loop->first) active @endif" data-toggle="tab" href="#home-tab-{{ $lang }}"
                    role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">{{ $lang }}</span>
                </a>
            </li>
            @endforeach
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            @foreach(config('app.locales') as $lang)
            
            <div class="tab-pane @if($loop->first) active @endif p-3" id="home-tab-{{ $lang }}" role="tabpanel">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="form-group">
                            <label for="title-{{ $lang }}">Başlıq - {{ $lang }}</label>
                            <input class="form-control"
                                value="{{old('title',$item->translate('az')?->title)}}"
                                name="title[{{ $lang }}]" @if($loop->first) required @endif>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <label for="">Məzmun - {{ $lang }}</label>
                        <textarea name="content[{{ $lang }}]" class="form-control " cols="30" rows="10">{{old('conent',$item->translate($lang)?->content)}}</textarea>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>