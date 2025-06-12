<!-- Add Category Modal -->
<div class="modal fade" id="company-modal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="saveForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Yeni Portfolio Kateqoriya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Language Tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach($langs as $lang)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($loop->first) active @endif"
                                        id="{{ $lang->country }}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#{{ $lang->country }}"
                                        type="button"
                                        role="tab"
                                        aria-controls="{{ $lang->country }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $lang->country }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content pt-3" id="myTabContent" style="min-height: 150px;">
                        @foreach($langs as $lang)
                            <div class="tab-pane fade @if($loop->first) show active @endif"
                                 id="{{ $lang->country }}"
                                 role="tabpanel"
                                 aria-labelledby="{{ $lang->country }}-tab">
                                <div class="form-group mb-3">
                                    <label for="name">Kateqoriya adı ({{ $lang->lang }})</label>
                                    <input type="text"
                                           name="name[{{ $lang->lang }}]"
                                           class="form-control"
                                           placeholder="Kateqoriya adı"
                                           @if($loop->first) required @endif>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
                    <button type="submit" class="btn btn-success" id="save">Əlavə et</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="editForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Kateqoriya Düzəliş</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="edit-body">
                    <!-- Dynamic content loaded via JS/AJAX -->
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">İmtina et</button>
                    <button type="submit" class="btn btn-success" id="update">Düzənlə</button>
                </div>
            </form>
        </div>
    </div>
</div>
