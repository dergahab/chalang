<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input is_active" id="is_active_{{ $item->id }}" data-id="{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
    <label class="custom-control-label" for="is_active_{{ $item->id }}"></label>
</div>
