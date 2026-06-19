@if($history->count() > 0)
    <div class="timeline">
        @foreach($history as $item)
            <div class="timeline-item pb-4 ps-4 border-start border-secondary position-relative">
                <!-- Dot -->
                <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-dark border border-{{ $item->event == 'created' ? 'success' : ($item->event == 'deleted' ? 'danger' : 'primary') }}" 
                     style="width: 12px; height: 12px; margin-top: 5px;"></div>
                
                <div class="card glass-card mb-0">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 text-white fs-14">
                                    <span class="badge bg-soft-{{ $item->event == 'created' ? 'success' : ($item->event == 'deleted' ? 'danger' : 'primary') }} me-2">
                                        {{ ucfirst($item->description) }}
                                    </span>
                                    {{ $item->created_at->format('d.m.Y H:i') }}
                                </h6>
                                <p class="text-muted mb-0 fs-12">
                                    <i class="ri-user-line me-1"></i> {{ $item->causer->name ?? 'Sistem' }}
                                </p>
                            </div>
                            
                            @if($item->event == 'updated' || $item->event == 'deleted')
                                <form action="{{ route('admin.activity-log.revert', $item->id) }}" method="POST" class="revert-form d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-soft-warning" title="Bu versiyaya qaytar">
                                        <i class="ri-history-line"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        @if(isset($item->properties['attributes']) && count($item->properties['attributes']) > 0)
                            <div class="mt-2 pt-2 border-top border-secondary border-opacity-25">
                                <small class="text-muted d-block mb-1">Dəyişdirilən sahələr:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($item->properties['attributes'] as $key => $val)
                                        @if(!in_array($key, ['updated_at', 'created_at']))
                                            <span class="badge bg-soft-secondary text-light border border-secondary border-opacity-25">
                                                {{ $key }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-4 text-muted">
        <i class="ri-history-line fs-24 mb-2 d-block"></i>
        Heç bir tarixçə tapılmadı.
    </div>
@endif
