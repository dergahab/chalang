<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input is_featured" id="is_featured_{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->is_featured ? 'checked' : '' }}>
    <label class="custom-control-label" for="is_featured_{{ $item->id }}"></label>
</div>
