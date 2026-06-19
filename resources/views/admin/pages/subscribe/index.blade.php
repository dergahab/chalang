@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Audit Requests (Subscribers)</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Audit Requests</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Website</th>
                                <th>Date</th>
                                <th style="width: 200px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribes as $subscribe)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subscribe->mail }}</td>
                                <td>
                                    @if($subscribe->website)
                                        <span class="badge badge-primary">Audit Request</span>
                                    @else
                                        <span class="badge badge-secondary">Newsletter</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subscribe->website)
                                        <a href="{{ $subscribe->website }}" target="_blank">{{ $subscribe->website }}</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $subscribe->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <!-- Analyze Button (Only for Audits) -->
                                    @if($subscribe->website)
                                    <a href="https://pagespeed.web.dev/analysis?url={{ urlencode($subscribe->website) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-chart-line"></i> Analyze
                                    </a>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.subscribe.destroy', $subscribe->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No requests found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="card-footer clearfix">
                    {{ $subscribes->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
