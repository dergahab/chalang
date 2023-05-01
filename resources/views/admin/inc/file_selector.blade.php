<div class="form-group mt-3">
    <label for="category" class="form-label ">{{ isset($__FILE_SELECTOR_TITLE) ? $__FILE_SELECTOR_TITLE: '' }}</label>
    <input name="file" class="form-control filestyle file" type="file" data-buttonname="btn-secondary">
    @if(isset($__FILE_OBJ))
    <input type="hidden" class="hidden" name="{{ $__FILE_OBJ->id }}">
    @endif
    @if(isset($item->image) and $item->image->isImage())
        <div style="background-image: url('{{ $item->image}}');
        height: 150px; width: 150px;
        background-size: cover;background-position: center;
        background-repeat: no-repeat;"></div>
    @endif
</div>
