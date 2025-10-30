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
    <link rel="stylesheet" href="{{ asset('adminlte/ionicons/2.0.1/css/ionicons.min.css') }}">
    <style>
        .info-box-icon {
            font-size: 1.5rem;
        }

        /* Quick Stats Summary */
        .quick-stats-summary {
            font-size: 0.95rem;
            color: #6c757d;
            padding: 0.5rem 0;
        }

        .quick-stat-item {
            display: inline-flex;
            align-items: center;
            margin-right: 1rem;
        }

        .quick-stat-item i {
            color: #007bff;
            font-size: 0.9rem;
        }

        .quick-stat-item strong {
            color: #495057;
            margin-right: 0.25rem;
        }

        .quick-stat-item .stat-value {
            color: #28a745;
            font-weight: 600;
            font-size: 1rem;
        }

        .quick-stat-divider {
            color: #dee2e6;
            margin: 0 1rem;
            font-weight: 300;
        }

        /* Dark mode for Quick Stats */
        .dark-mode .quick-stats-summary {
            color: #adb5bd;
        }

        .dark-mode .quick-stat-item strong {
            color: #e9ecef;
        }

        .dark-mode .quick-stat-item .stat-value {
            color: #20c997;
        }

        .dark-mode .quick-stat-item i {
            color: #17a2b8;
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

        /* Dark Mode Styles */
        .dark-mode .dashboard-card {
            background-color: #343a40;
            color: #c2c7d0;
        }

        .dark-mode .dashboard-card .card-header {
            background-color: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #c2c7d0;
        }

        .dark-mode .small-box {
            background-color: #454d55 !important;
            color: #fff;
        }

        .dark-mode .small-box .inner h3,
        .dark-mode .small-box .inner p {
            color: #fff;
        }

        .dark-mode .small-box .icon {
            color: rgba(255, 255, 255, 0.15);
        }

        .dark-mode .bg-gradient-info {
            background: linear-gradient(135deg, #1e3a5f 0%, #2c5282 100%) !important;
        }

        .dark-mode .back-to-top {
            background-color: rgba(23, 162, 184, 0.9);
        }

        .dark-mode .back-to-top:hover {
            background-color: rgba(23, 162, 184, 1);
        }

        .dark-mode .chart-legend li {
            color: #c2c7d0;
        }

        .dark-mode .table {
            color: #c2c7d0;
        }

        .dark-mode .table thead th {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .dark-mode .table td,
        .dark-mode .table th {
            border-color: rgba(255, 255, 255, 0.05);
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .dark-mode .badge {
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark-mode .info-box {
            background-color: #343a40;
            color: #c2c7d0;
        }

        .dark-mode .info-box-text,
        .dark-mode .info-box-number {
            color: #c2c7d0;
        }

        .dark-mode .card-title {
            color: #fff;
        }

        /* Stat Card Enhancements */
        .small-box .inner {
            position: relative;
        }

        .trend-indicator {
            font-size: 0.875rem;
            margin-top: 5px;
            font-weight: 600;
        }

        .trend-up {
            color: #28a745;
        }

        .trend-down {
            color: #dc3545;
        }

        .trend-neutral {
            color: #6c757d;
        }

        .small-box-footer {
            display: block;
            padding: 5px 0;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s;
        }

        .small-box-footer:hover {
            color: #fff;
            background: rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .dark-mode .small-box-footer {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Alert Badge Enhancements */
        .alert-badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .alert-badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .alert-badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .dark-mode .alert-badge-warning {
            background-color: #ff9800;
        }

        .dark-mode .alert-badge-danger {
            background-color: #f44336;
        }

        .expiry-action-btn {
            margin-top: 10px;
        }

        /* Health Score Gauge */
        .health-gauge {
            padding: 20px 0;
        }

        .health-score-circle {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .health-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: 5px solid #28a745;
        }

        .health-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: 5px solid #ffc107;
        }

        .health-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: 5px solid #dc3545;
        }

        .health-score-value {
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }

        .health-score-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 5px;
            font-weight: 600;
        }

        .dark-mode .health-score-circle {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Sticky Table Column */
        .sticky-table-wrapper {
            position: relative;
            overflow-x: auto;
        }

        .sticky-table th:first-child,
        .sticky-table td:first-child {
            position: sticky;
            left: 0;
            z-index: 10;
            background-color: #fff;
        }

        .dark-mode .sticky-table th:first-child,
        .dark-mode .sticky-table td:first-child {
            background-color: #343a40;
        }

        .table-collapse-btn {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .table-collapse-btn.collapsed {
            transform: rotate(-90deg);
        }

        /* Dashboard Header */
        .dashboard-header {
            font-weight: 300;
            color: #343a40;
            margin-bottom: 10px;
        }

        .dark-mode .dashboard-header {
            color: #fff;
        }

        /* Modern Stat Cards */
        .stat-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card .inner {
            color: #fff;
            padding: 15px;
        }

        .stat-card .inner h3 {
            color: #fff;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .stat-card .inner p {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 500;
        }

        .stat-card .icon {
            color: rgba(255, 255, 255, 0.3);
            font-size: 70px;
        }

        .stat-card .small-box-footer {
            background: rgba(0, 0, 0, 0.15);
            color: rgba(255, 255, 255, 0.95);
        }

        .stat-card .small-box-footer:hover {
            background: rgba(0, 0, 0, 0.25);
            color: #fff;
        }

        /* Color Variants */
        .stat-card-blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card-green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stat-card-orange {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        }

        .stat-card-teal {
            background: linear-gradient(135deg, #0cebeb 0%, #20e3b2 100%);
        }

        /* Dark Mode Adjustments for Stat Cards */
        .dark-mode .stat-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .dark-mode .stat-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        /* Trend Indicator Adjustments for Colored Cards */
        .stat-card .trend-indicator {
            color: rgba(255, 255, 255, 0.9);
        }

        .stat-card .trend-up,
        .stat-card .trend-down,
        .stat-card .trend-neutral {
            color: rgba(255, 255, 255, 0.9);
        }
    </style>
@endsection

@section('content')
    <!-- Dashboard Header -->
    <div class="row mb-2">
        <div class="col-12">
            <h2 class="dashboard-header">
                <i class="fas fa-tachometer-alt mr-2"></i>
                Fleet Overview
            </h2>
            <!-- Quick Stats Summary -->
            <div class="quick-stats-summary">
                <span class="quick-stat-item">
                    <i class="fas fa-chart-pie mr-1"></i>
                    <strong>Fleet Utilization:</strong> 
                    <span class="stat-value">{{ $quick_stats['fleet_utilization'] ?? 0 }}%</span>
                </span>
                <span class="quick-stat-divider">|</span>
                <span class="quick-stat-item">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    <strong>Average Age:</strong> 
                    <span class="stat-value">{{ $quick_stats['average_age'] ?? 0 }} months</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Fleet Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="small-box stat-card stat-card-blue">
                <div class="inner">
                    <h3 class="count-up" data-target="{{ $equipments->count() ?? 0 }}">0</h3>
                    <p>Total Fleet Units</p>
                    <canvas id="sparklineTotal" width="100" height="30" style="margin-top: 5px;"></canvas>
                    @if(isset($stats_trends['total_fleet_trend']))
                        <p class="trend-indicator {{ $stats_trends['total_fleet_trend'] > 0 ? 'trend-up' : ($stats_trends['total_fleet_trend'] < 0 ? 'trend-down' : 'trend-neutral') }}">
                            <i class="fas fa-arrow-{{ $stats_trends['total_fleet_trend'] > 0 ? 'up' : ($stats_trends['total_fleet_trend'] < 0 ? 'down' : 'right') }}"></i>
                            {{ abs($stats_trends['total_fleet_trend']) }}% vs last week
                        </p>
                    @endif
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="{{ route('equipments.index') }}" class="small-box-footer">
                    View All Equipment <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box stat-card stat-card-green">
                <div class="inner">
                    <h3 class="count-up" data-target="{{ $projects->count() ?? 0 }}">0</h3>
                    <p>Active Projects</p>
                    <canvas id="sparklineProjects" width="100" height="30" style="margin-top: 5px;"></canvas>
                    <p class="trend-indicator trend-neutral">
                        <i class="fas fa-building"></i>
                        {{ $projects_for_active_units->count() }} with equipment
                    </p>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="{{ route('projects.index') }}" class="small-box-footer">
                    View Projects <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box stat-card stat-card-orange">
                <div class="inner">
                    <h3 class="count-up" data-target="{{ $documents_expired['documents_will_expired'] ?? 0 }}">0</h3>
                    <p>Expiring Documents</p>
                    <canvas id="sparklineExpiring" width="100" height="30" style="margin-top: 5px;"></canvas>
                    @if(isset($stats_trends['expiring_trend']))
                        <p class="trend-indicator {{ $stats_trends['expiring_trend'] > 0 ? 'trend-down' : ($stats_trends['expiring_trend'] < 0 ? 'trend-up' : 'trend-neutral') }}">
                            <i class="fas fa-arrow-{{ $stats_trends['expiring_trend'] > 0 ? 'up' : ($stats_trends['expiring_trend'] < 0 ? 'down' : 'right') }}"></i>
                            {{ abs($stats_trends['expiring_trend']) }}% vs last week
                        </p>
                    @endif
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('documents.index') }}" class="small-box-footer">
                    Review Documents <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box stat-card stat-card-teal">
                <div class="inner">
                    <h3 class="count-up" data-target="{{ $equipments->where('unitstatus_id', 1)->count() ?? 0 }}">0</h3>
                    <p>Ready For Use</p>
                    <canvas id="sparklineRFU" width="100" height="30" style="margin-top: 5px;"></canvas>
                    @if(isset($stats_trends['rfu_trend']))
                        <p class="trend-indicator {{ $stats_trends['rfu_trend'] > 0 ? 'trend-up' : ($stats_trends['rfu_trend'] < 0 ? 'trend-down' : 'trend-neutral') }}">
                            <i class="fas fa-arrow-{{ $stats_trends['rfu_trend'] > 0 ? 'up' : ($stats_trends['rfu_trend'] < 0 ? 'down' : 'right') }}"></i>
                            {{ abs($stats_trends['rfu_trend']) }}% vs last week
                        </p>
                    @endif
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('equipments.index') }}" class="small-box-footer">
                    See RFU Details <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Equipment Health Score -->
    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-heartbeat mr-1"></i>
                        Fleet Health Score
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            @php
                                $totalActive = $equipments->count();
                                $rfuCount = $equipments->where('unitstatus_id', 1)->count();
                                $healthScore = $totalActive > 0 ? round(($rfuCount / $totalActive) * 100, 1) : 0;
                                
                                $healthClass = 'success';
                                $healthLabel = 'Excellent';
                                if ($healthScore < 60) {
                                    $healthClass = 'danger';
                                    $healthLabel = 'Needs Attention';
                                } elseif ($healthScore < 80) {
                                    $healthClass = 'warning';
                                    $healthLabel = 'Good';
                                }
                            @endphp
                            <div class="health-gauge">
                                <div class="health-score-circle health-{{ $healthClass }}">
                                    <span class="health-score-value">{{ $healthScore }}%</span>
                                    <span class="health-score-label">{{ $healthLabel }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h4 class="mb-3">Fleet Readiness Metrics</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-box bg-success">
                                        <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Ready For Use</span>
                                            <span class="info-box-number">{{ $rfuCount }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-warning">
                                        <span class="info-box-icon"><i class="fas fa-tools"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Under Maintenance</span>
                                            <span class="info-box-number">{{ $equipments->where('unitstatus_id', 2)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-danger">
                                        <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Inactive/Scrap</span>
                                            <span class="info-box-number">{{ $equipments->where('unitstatus_id', 3)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 25px;">
                                <div class="progress-bar bg-success" style="width: {{ $healthScore }}%">
                                    {{ $healthScore }}% Ready For Use
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
                        },
                        plugins: {
                            datalabels: {
                                formatter: function(value, context) {
                                    var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    var percentage = Math.floor(((value / total) * 100) + 0.5);
                                    return percentage > 5 ? percentage + '%' : '';
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                }
                            }
                        },
                        onClick: function(event, elements) {
                            if (elements.length > 0) {
                                var index = elements[0]._index;
                                var statusName = statusLabels[index];
                                filterTableByStatus(statusName);
                                highlightLegendItem(index);
                            }
                        },
                        onHover: function(event, elements) {
                            event.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                        }
                    }
                });

                // Update legend colors
                document.querySelectorAll('#unitStatusLegend li').forEach((item, index) => {
                    if (index < statusColors.length) {
                        item.querySelector('i').style.color = statusBorderColors[index];
                    }
                });

                // Filter table by status function
                function filterTableByStatus(statusName) {
                    const table = document.querySelector('#unitStatusTable');
                    if (!table) return;
                    
                    const rows = table.querySelectorAll('tbody tr:not(:last-child)');
                    
                    if (window.currentFilter === statusName) {
                        // Reset filter if clicking same status
                        rows.forEach(row => row.style.display = '');
                        window.currentFilter = null;
                        document.getElementById('filterStatus').textContent = '';
                    } else {
                        // Apply filter
                        rows.forEach(row => row.style.display = '');
                        window.currentFilter = statusName;
                        document.getElementById('filterStatus').innerHTML = 
                            '<i class="fas fa-filter"></i> Filtered by: <strong>' + statusName + '</strong> ' +
                            '<a href="#" onclick="resetStatusFilter(); return false;" class="text-danger ml-2">' +
                            '<i class="fas fa-times-circle"></i> Clear</a>';
                    }
                }

                // Highlight legend item
                function highlightLegendItem(index) {
                    document.querySelectorAll('#unitStatusLegend li').forEach((item, i) => {
                        if (i === index) {
                            item.style.fontWeight = 'bold';
                            item.style.backgroundColor = 'rgba(0, 123, 255, 0.1)';
                        } else {
                            item.style.fontWeight = 'normal';
                            item.style.backgroundColor = 'transparent';
                        }
                    });
                }

                // Reset filter function (global)
                window.resetStatusFilter = function() {
                    const table = document.querySelector('#unitStatusTable');
                    if (table) {
                        const rows = table.querySelectorAll('tbody tr');
                        rows.forEach(row => row.style.display = '');
                    }
                    window.currentFilter = null;
                    document.getElementById('filterStatus').textContent = '';
                    document.querySelectorAll('#unitStatusLegend li').forEach(item => {
                        item.style.fontWeight = 'normal';
                        item.style.backgroundColor = 'transparent';
                    });
                };

                // Make legend items clickable
                document.querySelectorAll('#unitStatusLegend li').forEach((item, index) => {
                    item.style.cursor = 'pointer';
                    item.style.padding = '5px';
                    item.style.borderRadius = '3px';
                    item.style.transition = 'all 0.2s';
                    
                    item.addEventListener('click', function() {
                        filterTableByStatus(statusLabels[index]);
                        highlightLegendItem(index);
                    });
                    
                    item.addEventListener('mouseenter', function() {
                        if (window.currentFilter !== statusLabels[index]) {
                            this.style.backgroundColor = 'rgba(0, 0, 0, 0.05)';
                        }
                    });
                    
                    item.addEventListener('mouseleave', function() {
                        if (window.currentFilter !== statusLabels[index]) {
                            this.style.backgroundColor = 'transparent';
                        }
                    });
                });
            }

            // Count-Up Animation
            function animateCountUp(element, target, duration = 2000) {
                const start = 0;
                const increment = target / (duration / 16);
                let current = start;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = Math.floor(target);
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current);
                    }
                }, 16);
            }

            // Initialize count-up for all stat cards
            document.querySelectorAll('.count-up').forEach(element => {
                const target = parseInt(element.getAttribute('data-target'));
                animateCountUp(element, target);
            });

            // Sparkline Charts Data (Last 7 days trend - mock data)
            const sparklineData = {
                total: [650, 655, 658, 660, 662, 665, 668],
                projects: [14, 14, 15, 15, 15, 15, 15],
                expiring: [5, 4, 4, 3, 3, 3, 3],
                rfu: [560, 562, 563, 565, 566, 567, 568]
            };

            // Create sparkline chart function
            function createSparkline(canvasId, data, color) {
                const canvas = document.getElementById(canvasId);
                if (!canvas) return;
                
                const ctx = canvas.getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['', '', '', '', '', '', ''],
                        datasets: [{
                            data: data,
                            borderColor: 'rgba(255, 255, 255, 0.8)',
                            backgroundColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: '#fff',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        legend: { display: false },
                        tooltips: {
                            enabled: true,
                            mode: 'index',
                            intersect: false,
                            displayColors: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            callbacks: {
                                title: function() { return ''; },
                                label: function(tooltipItem) {
                                    return 'Count: ' + tooltipItem.value;
                                }
                            }
                        },
                        scales: {
                            xAxes: [{ display: false }],
                            yAxes: [{ display: false }]
                        }
                    }
                });
            }

            // Create all sparklines
            createSparkline('sparklineTotal', sparklineData.total, 'rgba(255, 255, 255, 0.8)');
            createSparkline('sparklineProjects', sparklineData.projects, 'rgba(255, 255, 255, 0.8)');
            createSparkline('sparklineExpiring', sparklineData.expiring, 'rgba(255, 255, 255, 0.8)');
            createSparkline('sparklineRFU', sparklineData.rfu, 'rgba(255, 255, 255, 0.8)');

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
