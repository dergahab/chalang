<div class="modal fade" id="company-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yeni Protfolio kateqoriya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach($langs as $lang)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($loop->first) active @endif" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#{{ $lang->country }}" type="button" role="tab"
                                aria-controls="{{ $lang->country }}"
                                aria-selected="true">{{ $lang->country }}</button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content pt-3" id="myTabContent">
                    <form action="" id="saveForm">
                        @csrf
                    @foreach($langs as $lang)
                        <div class="tab-pane  fade @if($loop->first) show active @endif " id="{{ $lang->country }}"
                            role="tabpanel" aria-labelledby="{{ $lang->country }}-tab">
                            <div class="form-group ">
                                <label for="name">Kateqoriya adı ({{ $lang->lang }}) </label>
                                <input type="text" name="name[{{ $lang->lang }}]" id="company" class="form-control"
                                    placeholder="Kateqoriya adı " aria-describedby="helpId" @if($loop->first) required
                                @endif >
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
                <button type="submit" class="btn btn-success " id="save">Əlavə et</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kateqori düzəliş</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="edit-body"></div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
                <button type="submit" class="btn btn-success " id="update">Düzənlə</button>
                </form>
            </div>
        </div>
    </div>
</div>