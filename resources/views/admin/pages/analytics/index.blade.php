@extends('admin.layouts.main')

@section('heading_title', 'Analitika')

@section('content')
<div class="row">
    <!-- Summary Cards -->
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-soft-primary text-primary rounded-circle fs-2">
                            <i class="ri-service-line"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-uppercase fw-medium text-muted mb-3">Xidmətlər</p>
                        <h4 class="fs-4 mb-0"><span class="counter-value" data-target="{{ $counts['services'] }}">{{ $counts['services'] }}</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-soft-success text-success rounded-circle fs-2">
                            <i class="ri-gallery-line"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-uppercase fw-medium text-muted mb-3">Portfolio</p>
                        <h4 class="fs-4 mb-0"><span class="counter-value" data-target="{{ $counts['portfolios'] }}">{{ $counts['portfolios'] }}</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-soft-warning text-warning rounded-circle fs-2">
                            <i class="ri-article-line"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-uppercase fw-medium text-muted mb-3">Bloqlar</p>
                        <h4 class="fs-4 mb-0"><span class="counter-value" data-target="{{ $counts['blogs'] }}">{{ $counts['blogs'] }}</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar-md flex-shrink-0">
                        <span class="avatar-title bg-soft-info text-info rounded-circle fs-2">
                            <i class="ri-message-2-line"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="text-uppercase fw-medium text-muted mb-3">Mesajlar</p>
                        <h4 class="fs-4 mb-0"><span class="counter-value" data-target="{{ $counts['messages'] }}">{{ $counts['messages'] }}</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Content Distribution Chart -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Məzmun Paylanması</h4>
            </div>
            <div class="card-body">
                <div id="content_distribution_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>

    <!-- Message Volume Chart -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Gələn Mesajlar (Son 7 gün)</h4>
            </div>
            <div class="card-body">
                <div id="message_volume_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js_stack')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Content Distribution Chart
    var options = {
        series: @json($contentDistribution['data']),
        chart: {
            height: 350,
            type: 'donut',
        },
        labels: @json($contentDistribution['labels']),
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            dropShadow: {
                enabled: false,
            }
        },
        colors: ["#405189", "#0ab39c", "#f7b84b"]
    };
    var chart = new ApexCharts(document.querySelector("#content_distribution_chart"), options);
    chart.render();

    // Message Volume Chart
    var options2 = {
        series: [{
            name: 'Mesajlar',
            data: @json($messageChart['data'])
        }],
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        dataLabels: {
            enabled: true,
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        xaxis: {
            categories: @json($messageChart['labels']),
            position: 'top',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                show: false,
                formatter: function (val) {
                    return val + "";
                }
            }
        },
        colors: ["#299cdb"]
    };
    var chart2 = new ApexCharts(document.querySelector("#message_volume_chart"), options2);
    chart2.render();
</script>
@endpush
