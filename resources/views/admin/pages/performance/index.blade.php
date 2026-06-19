@extends('admin.layouts.main')

@section('heading_title', 'Performans Monitorinqi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Performance Monitoring Dashboard</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-warning" onclick="clearPerformanceCache()">
                            <i class="fas fa-trash"></i> Clear Cache
                        </button>
                        <button type="button" class="btn btn-sm btn-info" onclick="refreshData()">
                            <i class="fas fa-sync"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Performance Insights -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="total-requests">{{ number_format($todayMetrics['total_requests']) }}</h3>
                                    <p>Total Requests Today</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                @if(isset($insights['requests']))
                                <div class="small-box-footer">
                                    <span class="text-{{ $insights['requests']['trend'] === 'up' ? 'success' : 'danger' }}">
                                        {{ $insights['requests']['change'] }}% from yesterday
                                        <i class="fas fa-arrow-{{ $insights['requests']['trend'] === 'up' ? 'up' : 'down' }}"></i>
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 id="avg-duration">{{ number_format($todayMetrics['avg_duration'], 1) }}<sup style="font-size: 20px">ms</sup></h3>
                                    <p>Avg Response Time</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                @if(isset($insights['duration']))
                                <div class="small-box-footer">
                                    <span class="text-{{ $insights['duration']['trend'] === 'better' ? 'success' : 'danger' }}">
                                        {{ abs($insights['duration']['change']) }}% {{ $insights['duration']['trend'] === 'better' ? 'faster' : 'slower' }}
                                        <i class="fas fa-arrow-{{ $insights['duration']['trend'] === 'better' ? 'down' : 'up' }}"></i>
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 id="error-rate">{{ $insights['error_rate'] }}<sup style="font-size: 20px">%</sup></h3>
                                    <p>Error Rate</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 id="slow-requests">{{ $insights['slow_percentage'] }}<sup style="font-size: 20px">%</sup></h3>
                                    <p>Slow Requests (>500ms)</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Response Time Trends</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="responseTimeChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Status Codes</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="statusCodeChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slow Routes Table -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Slow Routes (>500ms avg)</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Route</th>
                                                <th>Avg Duration</th>
                                                <th>Max Duration</th>
                                                <th>Request Count</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="slow-routes-table">
                                            @foreach($slowRoutes as $route)
                                            <tr>
                                                <td>{{ $route['route'] }}</td>
                                                <td>{{ $route['avg_duration'] }}ms</td>
                                                <td>{{ $route['max_duration'] }}ms</td>
                                                <td>{{ $route['count'] }}</td>
                                                <td>
                                                    @if($route['avg_duration'] > 1000)
                                                        <span class="badge badge-danger">Critical</span>
                                                    @elseif($route['avg_duration'] > 500)
                                                        <span class="badge badge-warning">Slow</span>
                                                    @else
                                                        <span class="badge badge-success">OK</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Real-time Requests -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Recent Requests (Last Hour)</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Method</th>
                                                <th>Route</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                                <th>Memory</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recent-requests-table">
                                            @foreach(array_slice($hourlyMetrics, -20) as $metric)
                                            <tr>
                                                <td>{{ date('H:i:s', $metric['timestamp']) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $metric['method'] === 'GET' ? 'primary' : ($metric['method'] === 'POST' ? 'success' : 'warning') }}">
                                                        {{ $metric['method'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $metric['route'] }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $metric['duration'] > 1000 ? 'danger' : ($metric['duration'] > 500 ? 'warning' : 'success') }}">
                                                        {{ number_format($metric['duration'], 1) }}ms
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $metric['status_code'] >= 400 ? 'danger' : 'success' }}">
                                                        {{ $metric['status_code'] }}
                                                    </span>
                                                </td>
                                                <td>{{ number_format($metric['memory_usage'] / 1024 / 1024, 2) }} MB</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let responseTimeChart;
let statusCodeChart;

$(document).ready(function() {
    initializeCharts();
    startRealTimeUpdates();
});

function initializeCharts() {
    // Response Time Chart
    const ctx1 = document.getElementById('responseTimeChart').getContext('2d');
    responseTimeChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
            datasets: [{
                label: 'Avg Response Time (ms)',
                data: [120, 150, 180, 200, 160, 140],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Status Code Chart
    const ctx2 = document.getElementById('statusCodeChart').getContext('2d');
    const statusData = @json($statusCodes);
    statusCodeChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(code => `HTTP ${code}`),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    'rgb(40, 167, 69)',   // 200
                    'rgb(255, 193, 7)',    // 300
                    'rgb(220, 53, 69)',    // 400
                    'rgb(108, 117, 125)'   // 500
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function startRealTimeUpdates() {
    setInterval(function() {
        $.get('{{ route("admin.performance.realtime") }}')
            .done(function(data) {
                updateRecentRequests(data.recent_requests);
                $('#total-requests').text(data.total_this_hour.toLocaleString());
            })
            .fail(function() {
                console.log('Failed to fetch real-time data');
            });
    }, 5000); // Update every 5 seconds
}

function updateRecentRequests(requests) {
    const tbody = $('#recent-requests-table');
    tbody.empty();

    requests.forEach(function(request) {
        const time = new Date(request.timestamp * 1000).toLocaleTimeString();
        const durationClass = request.duration > 1000 ? 'danger' : (request.duration > 500 ? 'warning' : 'success');
        const statusClass = request.status_code >= 400 ? 'danger' : 'success';
        const methodClass = request.method === 'GET' ? 'primary' : (request.method === 'POST' ? 'success' : 'warning');

        const row = `
            <tr>
                <td>${time}</td>
                <td><span class="badge badge-${methodClass}">${request.method}</span></td>
                <td>${request.route}</td>
                <td><span class="badge badge-${durationClass}">${request.duration.toFixed(1)}ms</span></td>
                <td><span class="badge badge-${statusClass}">${request.status_code}</span></td>
                <td>${(request.memory_usage / 1024 / 1024).toFixed(2)} MB</td>
            </tr>
        `;
        tbody.append(row);
    });
}

function refreshData() {
    location.reload();
}

function clearPerformanceCache() {
    if (confirm('Are you sure you want to clear the performance cache? This will reset all metrics.')) {
        $.post('{{ route("admin.performance.clear-cache") }}')
            .done(function() {
                toastr.success('Performance cache cleared successfully');
                setTimeout(() => location.reload(), 1000);
            })
            .fail(function() {
                toastr.error('Failed to clear performance cache');
            });
    }
}
</script>
@endsection