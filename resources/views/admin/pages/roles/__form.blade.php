<div class="mb-4">
    <label for="title" class="form-label text-white-50">Rol Adı</label>
    <input type="text" class="form-control glass-input @error('title') is-invalid @enderror" 
           name="title" id="title" 
           value="{{ old('title', $item->title) }}" 
           placeholder="Məsələn: Moderator" required
           style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff;">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label h5 mb-3">İcazələr</label>
    <div class="row">
        @foreach($permissions as $groupName => $perms)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.05);">
                    <div class="card-header py-3 border-bottom border-secondary" style="background: rgba(255, 255, 255, 0.02); border-color: rgba(255, 255, 255, 0.05) !important;">
                        <h6 class="mb-0 text-capitalize text-white"><i class="ri-shield-keyhole-line me-2 text-primary"></i>{{ $groupName }}</h6>
                    </div>
                    <div class="card-body p-3">
                        @foreach($perms as $permission)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" 
                                       name="permissions[]" 
                                       value="{{ $permission->name }}" 
                                       id="perm_{{ $permission->id }}"
                                       @if($item->hasPermissionTo($permission->name)) checked @endif
                                       style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);">
                                <label class="form-check-label text-white-50" for="perm_{{ $permission->id }}">
                                    {{ $permission->title ?? $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
