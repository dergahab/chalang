@extends('admin.layouts.main')
@section('heading_title', 'Bildirişlər')

@section('content')
<div class="card glass-card">
    <div class="card-header border-0 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div>
            <h4 class="mb-0">Bildirişlər</h4>
            <p class="text-muted mb-0">Son bildirişlərin siyahısı</p>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <form class="d-flex gap-2" method="GET" action="{{ route('admin.notifications.index') }}">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>Hamısı</option>
                    <option value="unread" {{ ($status ?? 'all') === 'unread' ? 'selected' : '' }}>Oxunmamış</option>
                    <option value="read" {{ ($status ?? 'all') === 'read' ? 'selected' : '' }}>Oxunmuş</option>
                </select>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm">
                <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm">
                <button class="btn btn-sm btn-primary" type="submit">Filtr</button>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.notifications.index') }}">Təmizlə</a>
            </form>
            <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm">Hamısını oxunmuş et</button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Başlıq</th>
                    <th>Status</th>
                    <th>Tarix</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    <tr class="{{ $notification->read_at ? 'text-muted' : '' }}">
                        <td>
                            <div class="fw-semibold {{ $notification->read_at ? '' : 'text-white' }}">
                                {{ $notification->data['title'] ?? 'Bildiriş' }}
                            </div>
                            <div class="small text-muted">
                                {{ $notification->data['message'] ?? '' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $notification->read_at ? 'bg-secondary' : 'bg-primary' }}">
                                {{ $notification->read_at ? 'Oxunmuş' : 'Oxunmamış' }}
                            </span>
                        </td>
                        <td>{{ $notification->created_at->format('d.m.Y H:i') }}</td>
                        <td class="text-end">
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('admin.notifications.read', $notification->id) }}">
                                    @csrf
                                    <button class="btn btn-link p-0 btn-sm" type="submit">Oxunmuş et</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Bildiriş yoxdur</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer border-0">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
