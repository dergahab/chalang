@extends('admin.layouts.main')

@section('heading_title', 'A/B Testlər')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">A/B Testing Experiments</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.experiments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Experiment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($experiments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Traffic %</th>
                                        <th>Participants</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($experiments as $experiment)
                                    <tr>
                                        <td>
                                            <strong>{{ $experiment->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $experiment->key }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($experiment->type) }}</span>
                                        </td>
                                        <td>
                                            @switch($experiment->status)
                                                @case('draft')
                                                    <span class="badge badge-secondary">Draft</span>
                                                    @break
                                                @case('active')
                                                    <span class="badge badge-success">Active</span>
                                                    @break
                                                @case('paused')
                                                    <span class="badge badge-warning">Paused</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge badge-primary">Completed</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $experiment->traffic_percentage }}%</td>
                                        <td>{{ number_format($experiment->results_count) }}</td>
                                        <td>{{ $experiment->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.experiments.show', $experiment) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.experiments.edit', $experiment) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($experiment->status === 'draft')
                                                    <form action="{{ route('admin.experiments.start', $experiment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Start this experiment?')">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                    </form>
                                                @elseif($experiment->status === 'active')
                                                    <form action="{{ route('admin.experiments.pause', $experiment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Pause this experiment?')">
                                                            <i class="fas fa-pause"></i>
                                                        </button>
                                                    </form>
                                                @elseif($experiment->status === 'paused')
                                                    <form action="{{ route('admin.experiments.resume', $experiment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Resume this experiment?')">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.experiments.destroy', $experiment) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this experiment?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $experiments->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                            <h4>No Experiments Yet</h4>
                            <p>Create your first A/B test to start optimizing your content.</p>
                            <a href="{{ route('admin.experiments.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create First Experiment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-refresh experiment stats every 30 seconds
    setInterval(function() {
        $('.experiment-stats').each(function() {
            var experimentId = $(this).data('experiment-id');
            // Could add AJAX call here to refresh stats
        });
    }, 30000);
});
</script>
@endsection