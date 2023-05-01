<div class="form-group">
    <label for="permissionDesc" class="form-label">İcazə adı</label>
    <input type="text"
           class="form-control @error('title') is-invalid @enderror"
           name="title"
           value="{{ old("title", $item->title) }}"
           id="permissionDesc" placeholder="{{ __('Role title') }}" required>
    @error('title')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="form-group">
    <label for="permissionKey" class="form-label">{{ __('Role key') }}</label>
    <input type="text"
           class="form-control @error('key') is-invalid @enderror"
           name="key"
           value="{{ old("key", $item->name) }}"
           id="permissionKey" placeholder="{{ __('Role key') }}" readonly>
    @error('key')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="md-3">
    <div class="position-relative form-group pt-2">
        <div>
            <label for="exampleSelect" class="h4">İcazə seçin</label>
        </div>
        <div class="row">
            @foreach($permissions as $permission)
                <div class="col-md-3">
                    <label>
                        <input @if($item->hasPermissionTo($permission->name)) checked @endif  type="checkbox" name="permissions[]" value="{{ $permission->name }}"> {{ $permission->title }}
                    </label>
                </div>
            @endforeach
        </div>

    </div>
</div>
