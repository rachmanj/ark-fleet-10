@extends('templates.main')

@section('title_page')
    Dashboard
@endsection

@section('breadcrumb_title')
    dashboard
@endsection

@section('styles')
    <!-- Chart.js -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/chart.js/Chart.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        .info-box-icon {
            font-size: 1.5rem;
        }

        .dashboard-card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            transition: all .3s;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
        }

        .dashboard-card .card-header {
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        /* Back to Top Button Styles */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 45px;
            height: 45px;
            background-color: rgba(23, 162, 184, 0.8);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .back-to-top:hover {
            background-color: rgba(23, 162, 184, 1);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
@endsection

@section('content')
    <!-- Dashboard Header Stats -->
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card bg-gradient-info">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-tachometer-alt mr-1"></i>
                        Fleet Overview
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-white">
                                <div class="inner">
                                    <h3>{{ $equipments->count() ?? 0 }}</h3>
                                    <p>Total Fleet Units</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-white">
                                <div class="inner">
                                    <h3>{{ $projects->count() ?? 0 }}</h3>
                                    <p>Active Projects</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-white">
                                <div class="inner">
                                    <h3>{{ $documents_expired['documents_will_expired'] ?? 0 }}</h3>
                                    <p>Expiring Documents</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="small-box bg-white">
                                <div class="inner">
                                    <h3>{{ $equipments->where('unitstatus_id', 1)->count() ?? 0 }}</h3>
                                    <p>Ready For Use</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents & Activity Logging -->
    <div class="row">
        <div class="col-md-6">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-1"></i>
                        Document Status
                    </h3>
                </div>
                <div class="card-body">
                    @include('dashboard.document_expired')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Recent Activity
                    </h3>
                </div>
                <div class="card-body">
                    @include('dashboard.logger')
                </div>
            </div>
        </div>
    </div>

    <!-- Status RFU Section -->
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-check-circle mr-1"></i>
                        Ready For Use Status
                    </h3>
                </div>
                <div class="card-body">
                    @include('dashboard.status_rfu')
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Analytics with Pie Chart -->
    <div class="row">
        <div class="col-md-6">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Equipment by Status
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-responsive">
                                <canvas id="unitStatusPieChart" height="200"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="chart-legend clearfix" id="unitStatusLegend">
                                @foreach ($unit_status as $status)
                                    <li>
                                        <i class="far fa-circle"
                                            style="color: #{{ dechex(crc32($status->name) & 0xffffff) }}"></i>
                                        {{ $status->name }}
                                        ({{ $equipments->where('unitstatus_id', $status->id)->count() }})
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-4">
                        @include('dashboard.by_status')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Equipment by Plant Type
                    </h3>
                </div>
                <div class="card-body">
                    @include('dashboard.by_plant_type')
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Performance Metrics -->
    <div class="row">
        <div class="col-md-8">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Fleet Utilization Trend
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="utilizationChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-list mr-1"></i>
                        Maintenance Schedule
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Type</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>EQP-001</td>
                                    <td><span class="badge bg-warning">Service</span></td>
                                    <td>{{ now()->addDays(5)->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td>EQP-015</td>
                                    <td><span class="badge bg-danger">Inspection</span></td>
                                    <td>{{ now()->addDays(2)->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td>EQP-022</td>
                                    <td><span class="badge bg-warning">Service</span></td>
                                    <td>{{ now()->addDays(7)->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td>EQP-037</td>
                                    <td><span class="badge bg-info">Calibration</span></td>
                                    <td>{{ now()->addDays(10)->format('M d, Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-right">View All</a>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Plant Group (Uncomment this if needed) -->
    {{-- <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-object-group mr-1"></i>
                        Equipment by Plant Group
                    </h3>
                </div>
                <div class="card-body">
                    @include('dashboard.by_plant_group')
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>
@endsection

@section('scripts')
    <!-- ChartJS -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            // Utilization Chart
            var utilizationCanvas = document.getElementById('utilizationChart');
            if (utilizationCanvas) {
                var utilizationCtx = utilizationCanvas.getContext('2d');
                var utilizationChart = new Chart(utilizationCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                            'Nov',
                            'Dec'
                        ],
                        datasets: [{
                                label: 'Fleet Utilization %',
                                data: [65, 70, 75, 72, 78, 82, 80, 79, 83, 85, 82, 87],
                                borderColor: '#17a2b8',
                                backgroundColor: 'rgba(23, 162, 184, 0.1)',
                                pointRadius: 4,
                                pointBackgroundColor: '#17a2b8',
                                borderWidth: 2,
                                fill: true
                            },
                            {
                                label: 'Target Utilization',
                                data: [75, 75, 75, 75, 75, 75, 75, 75, 75, 75, 75, 75],
                                borderColor: 'rgba(210, 214, 222, 1)',
                                borderDash: [5, 5],
                                pointRadius: 0,
                                borderWidth: 2,
                                fill: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: true,
                                },
                                ticks: {
                                    beginAtZero: true,
                                    max: 100,
                                    callback: function(value) {
                                        return value + '%'
                                    }
                                }
                            }]
                        }
                    }
                });
            }

            // Unit Status Pie Chart
            var unitStatusPieCanvas = document.getElementById('unitStatusPieChart');
            if (unitStatusPieCanvas) {
                var unitStatusCtx = unitStatusPieCanvas.getContext('2d');

                // Generate data from the existing unit status information
                var statusData = [];
                var statusLabels = [];
                var statusColors = [];
                var statusBorderColors = [];

                @foreach ($unit_status as $status)
                    // Generate a deterministic color based on the status name
                    var color = '#' + Math.floor(Math.abs(Math.sin('{{ $status->name }}'.charCodeAt(0)) *
                        16777215) % 16777215).toString(16).padStart(6, '0');
                    statusData.push({{ $equipments->where('unitstatus_id', $status->id)->count() }});
                    statusLabels.push('{{ $status->name }}');
                    statusColors.push(color + '99'); // Adding alpha for semi-transparency
                    statusBorderColors.push(color);
                @endforeach

                var unitStatusPieChart = new Chart(unitStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels,
                        datasets: [{
                            data: statusData,
                            backgroundColor: statusColors,
                            borderColor: statusBorderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var dataset = data.datasets[tooltipItem.datasetIndex];
                                    var total = dataset.data.reduce(function(previousValue,
                                        currentValue) {
                                        return previousValue + currentValue;
                                    });
                                    var currentValue = dataset.data[tooltipItem.index];
                                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                                    return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' +
                                        percentage + '%)';
                                }
                            }
                        }
                    }
                });

                // Update legend colors
                document.querySelectorAll('#unitStatusLegend li').forEach((item, index) => {
                    if (index < statusColors.length) {
                        item.querySelector('i').style.color = statusBorderColors[index];
                    }
                });
            }

            // Back to Top Button
            var backToTopButton = document.getElementById('backToTop');

            // Show button when user scrolls down 300px
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });

            // Smooth scroll to top when button is clicked
            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
