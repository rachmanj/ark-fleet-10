@extends('templates.main')

@section('title_page')
    Equipment Details
@endsection

@section('breadcrumb_title')
    <a href="{{ route('equipments.index') }}">equipments</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Top action bar -->
            <div class="d-flex justify-content-between align-items-center mb-3 animated fadeIn">
                <h3 class="text-dark">
                    <i class="fas fa-truck-monster mr-2"></i> Equipment Details
                </h3>
                <div>
                    <a href="{{ route('equipments.photos.index', $equipment->id) }}" class="btn btn-info btn-hover-effect">
                        <i class="fas fa-images"></i> Photos
                    </a>
                    <a href="{{ route('equipments.index') }}" class="btn btn-primary ml-2 btn-hover-effect">
                        <i class="fas fa-arrow-left"></i> Back to Equipment List
                    </a>
                </div>
            </div>

            <!-- Equipment info card -->
            <div class="card card-primary card-outline shadow-sm animated fadeIn delay-1">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>Equipment Information
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('equipments.show_info')
                        </div>
                        <div class="col-md-6">
                            <div class="equipment-status text-center p-4 rounded shadow-sm hover-zoom">
                                @if ($equipment->unitstatus_id == 1)
                                    @if ($equipment->is_rfu == 1)
                                        <div class="ribbon-wrapper ribbon-lg">
                                            <div class="ribbon bg-success pulse">
                                                RFU
                                            </div>
                                        </div>
                                    @else
                                        <div class="ribbon-wrapper ribbon-lg">
                                            <div class="ribbon bg-danger pulse">
                                                B/D
                                            </div>
                                        </div>
                                    @endif
                                @elseif ($equipment->unitstatus_id == 3)
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon bg-secondary">
                                            Scrap
                                        </div>
                                    </div>
                                @elseif ($equipment->unitstatus_id == 4)
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon bg-secondary">
                                            Sold
                                        </div>
                                    </div>
                                @else
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon bg-secondary">
                                            In-active
                                        </div>
                                    </div>
                                @endif

                                <div class="position-relative mt-4">
                                    <img src="{{ asset('images/equipment-placeholder.png') }}" alt="Equipment"
                                        class="img-fluid mb-3 equipment-image shadow-sm rounded"
                                        onerror="this.src='{{ asset('adminlte/dist/img/photo1.png') }}'">
                                    <h4 class="text-bold">{{ $equipment->unit_no }}</h4>
                                    <p class="text-muted">{{ $equipment->description }}</p>
                                    <div class="mt-3 button-container">
                                        <a href="{{ route('equipments.edit', $equipment->id) }}"
                                            class="btn btn-warning btn-sm btn-hover-effect">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('equipments.edit_detail', $equipment->id) }}"
                                            class="btn btn-info btn-sm btn-hover-effect">
                                            <i class="fas fa-cogs"></i> Edit Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Card -->
            <div class="card card-primary card-tabs shadow-sm animated fadeIn delay-2">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="equipment-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-movings" data-toggle="pill" href="#content-movings"
                                role="tab" aria-controls="content-movings" aria-selected="true">
                                <i class="fas fa-exchange-alt mr-1"></i> Movings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-acquisitions" data-toggle="pill" href="#content-acquisitions"
                                role="tab" aria-controls="content-acquisitions" aria-selected="false">
                                <i class="fas fa-shopping-cart mr-1"></i> Acquisitions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-legals" data-toggle="pill" href="#content-legals" role="tab"
                                aria-controls="content-legals" aria-selected="false">
                                <i class="fas fa-gavel mr-1"></i> Legal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-insurance" data-toggle="pill" href="#content-insurance"
                                role="tab" aria-controls="content-insurance" aria-selected="false">
                                <i class="fas fa-shield-alt mr-1"></i> Insurance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-others" data-toggle="pill" href="#content-others" role="tab"
                                aria-controls="content-others" aria-selected="false">
                                <i class="fas fa-file-alt mr-1"></i> Others
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-changes" data-toggle="pill" href="#content-changes"
                                role="tab" aria-controls="content-changes" aria-selected="false">
                                <i class="fas fa-history mr-1"></i> Changes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-payreq" data-toggle="pill" href="#content-payreq"
                                role="tab" aria-controls="content-payreq" aria-selected="false">
                                <i class="fas fa-money-check-alt mr-1"></i> Payreq
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="equipment-tabsContent">
                        <div class="tab-pane fade show active animated fadeIn" id="content-movings" role="tabpanel"
                            aria-labelledby="tab-movings">
                            <div class="overlay-wrapper">
                                @include('equipments.tabs.movings')
                                <div class="overlay dark d-none" id="movings-loading">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade animated fadeIn" id="content-acquisitions" role="tabpanel"
                            aria-labelledby="tab-acquisitions">
                            <div class="overlay-wrapper">
                                @include('equipments.tabs.acquisition')
                                <div class="overlay dark d-none" id="acquisitions-loading">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade animated fadeIn" id="content-legals" role="tabpanel"
                            aria-labelledby="tab-legals">
                            <div class="overlay-wrapper">
                                @include('equipments.tabs.legals')
                                <div class="overlay dark d-none" id="legals-loading">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade animated fadeIn" id="content-insurance" role="tabpanel"
                            aria-labelledby="tab-insurance">
                            <div class="overlay-wrapper">
                                @include('equipments.tabs.insurance')
                                <div class="overlay dark d-none" id="insurance-loading">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade animated fadeIn" id="content-others" role="tabpanel"
                            aria-labelledby="tab-others">
                            <div class="overlay-wrapper">
                                @include('equipments.tabs.others')
                                <div class="overlay dark d-none" id="others-loading">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade animated fadeIn" id="content-changes" role="tabpanel"
                            aria-labelledby="tab-changes">
                            <div class="overlay-wrapper">
                                @include('equipments.tabs.changes')
                                <div class="overlay dark d-none" id="changes-loading">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade animated fadeIn" id="content-payreq" role="tabpanel"
                            aria-labelledby="tab-payreq">
                            <div class="overlay-wrapper">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Payment Requisition Summary</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" id="refresh-payreq"
                                                data-toggle="tooltip" title="Refresh Data">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="payreq-table" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th class="text-right">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="payreq-data">
                                                    <!-- Data will be loaded via AJAX -->
                                                    <tr>
                                                        <td colspan="2" class="text-center">Loading data...</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th id="payreq-total" class="text-right">0.00</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="overlay dark d-none" id="payreq-loading">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}" />
    <!-- AdminLTE styles with animations -->
    <style>
        /* Animation classes based on AdminLTE */
        .fadeIn {
            animation: fadeIn 0.7s;
        }

        .fadeInDown {
            animation: fadeInDown 0.7s;
        }

        .fadeInUp {
            animation: fadeInUp 0.7s;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* Equipment status styling */
        .equipment-status {
            position: relative;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.125);
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .equipment-image {
            max-height: 180px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .hover-zoom:hover .equipment-image {
            transform: scale(1.05);
        }

        /* Button effects */
        .btn-hover-effect {
            transition: all 0.3s ease;
        }

        .btn-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Ribbon styling */
        .ribbon-wrapper.ribbon-lg {
            height: 120px;
            width: 120px;
            z-index: 10;
        }

        .ribbon-wrapper.ribbon-lg .ribbon {
            font-size: 1.2rem;
            line-height: 2.2;
            right: 0;
            top: 26px;
            width: 160px;
        }

        .pulse {
            animation: pulse-animation 2s infinite;
        }

        @keyframes pulse-animation {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 1;
            }
        }

        /* Card and tab styling */
        .card-primary.card-tabs .card-header {
            background-color: #007bff;
        }

        .card-tabs .nav-tabs .nav-link {
            color: rgba(255, 255, 255, .6);
            transition: all 0.3s ease;
        }

        .card-tabs .nav-tabs .nav-link:hover:not(.active) {
            color: rgba(255, 255, 255, 1);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .card-tabs .nav-tabs .nav-link.active {
            color: #343a40;
        }

        /* Table styling */
        .table-responsive {
            margin-top: 1rem;
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1.5rem;
        }

        #equipment-tabs .nav-item .nav-link {
            padding: 0.8rem 1.2rem;
        }

        .dataTables_wrapper .row {
            margin-right: 0;
            margin-left: 0;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        .table-striped tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Animation effects */
        .animated {
            animation-duration: 0.7s !important;
        }

        .button-container {
            transition: all 0.3s ease;
        }

        .button-container .btn {
            margin: 0 3px;
        }

        /* Loading indicator */
        .loading-indicator {
            background-color: rgba(255, 255, 255, 0.7);
        }

        /* DataTable pagination tweaks */
        .dataTables_paginate .paginate_button {
            transition: all 0.2s ease;
        }

        .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background: #007bff !important;
            border-color: #007bff !important;
            color: white !important;
        }

        .dataTables_paginate .paginate_button.current {
            background: #007bff !important;
            border-color: #007bff !important;
            color: white !important;
        }

        /* Enhanced equipment info */
        .equipment-info .form-group {
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }

        .equipment-info .form-group:hover {
            background-color: rgba(0, 123, 255, 0.03);
            border-radius: 4px;
        }

        /* Table head styling */
        .table thead th {
            background-color: #f4f6f9;
            border-bottom: 2px solid #dee2e6;
        }

        /* Responsive layout improvements */
        @media (max-width: 767.98px) {
            .card-tabs .nav-tabs .nav-link {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
            }

            .equipment-status {
                margin-top: 1rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>

    <script>
        $(function() {
            // Hide loading indicators when DataTable loads data
            const hideLoadingIndicator = (tableId) => {
                $(`#${tableId}_wrapper`).closest('.overlay-wrapper').find('.loading-indicator').addClass(
                    'd-none');
                $(`#${tableId}`).closest('.overlay-wrapper').find('.overlay').addClass('d-none');
            };

            // Initialize DataTables with loading indicators
            $("#movings").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('equipments.movings.data', $equipment->id) }}',
                    beforeSend: function() {
                        $('#movings-loading').removeClass('d-none');
                    },
                    complete: function() {
                        $('#movings-loading').addClass('d-none');
                        hideLoadingIndicator('movings');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ipa_no'
                    },
                    {
                        data: 'ipa_date'
                    },
                    {
                        data: 'from_project'
                    },
                    {
                        data: 'to_project'
                    },
                ],
                responsive: true,
                fixedHeader: true,
                autoWidth: false,
            });

            $("#legals").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('equipments.legals.data', $equipment->id) }}',
                    beforeSend: function() {
                        $('#legals-loading').removeClass('d-none');
                    },
                    complete: function() {
                        $('#legals-loading').addClass('d-none');
                        hideLoadingIndicator('legals');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'document_no'
                    },
                    {
                        data: 'doctype'
                    },
                    {
                        data: 'document_date'
                    },
                    {
                        data: 'due_date'
                    },
                    {
                        data: 'amount'
                    },
                ],
                responsive: true,
                fixedHeader: true,
                autoWidth: false,
                columnDefs: [{
                    "targets": 5,
                    "className": "text-right"
                }],
            });

            $("#acquisitions").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('equipments.acquisitions.data', $equipment->id) }}',
                    beforeSend: function() {
                        $('#acquisitions-loading').removeClass('d-none');
                    },
                    complete: function() {
                        $('#acquisitions-loading').addClass('d-none');
                        hideLoadingIndicator('acquisitions');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'document_no'
                    },
                    {
                        data: 'doctype'
                    },
                    {
                        data: 'document_date'
                    },
                    {
                        data: 'amount'
                    },
                ],
                responsive: true,
                fixedHeader: true,
                autoWidth: false,
                columnDefs: [{
                    "targets": 4,
                    "className": "text-right"
                }],
            });

            $("#insurance").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('equipments.insurance.data', $equipment->id) }}',
                    beforeSend: function() {
                        $('#insurance-loading').removeClass('d-none');
                    },
                    complete: function() {
                        $('#insurance-loading').addClass('d-none');
                        hideLoadingIndicator('insurance');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'document_no'
                    },
                    {
                        data: 'supplier'
                    },
                    {
                        data: 'document_date'
                    },
                    {
                        data: 'due_date'
                    },
                    {
                        data: 'premi'
                    },
                ],
                responsive: true,
                fixedHeader: true,
                autoWidth: false,
                columnDefs: [{
                    "targets": 5,
                    "className": "text-right"
                }],
            });

            $("#others").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('equipments.others.data', $equipment->id) }}',
                    beforeSend: function() {
                        $('#others-loading').removeClass('d-none');
                    },
                    complete: function() {
                        $('#others-loading').addClass('d-none');
                        hideLoadingIndicator('others');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'document_no'
                    },
                    {
                        data: 'doctype'
                    },
                    {
                        data: 'supplier'
                    },
                    {
                        data: 'document_date'
                    },
                    {
                        data: 'due_date'
                    },
                    {
                        data: 'amount'
                    },
                ],
                responsive: true,
                fixedHeader: true,
                autoWidth: false,
                columnDefs: [{
                    "targets": 6,
                    "className": "text-right"
                }],
            });

            $("#changes").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('equipments.changes.data', $equipment->id) }}',
                    beforeSend: function() {
                        $('#changes-loading').removeClass('d-none');
                    },
                    complete: function() {
                        $('#changes-loading').addClass('d-none');
                        hideLoadingIndicator('changes');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'old_unit_no'
                    },
                    {
                        data: 'new_unit_no'
                    },
                ],
                responsive: true,
                fixedHeader: true,
                autoWidth: false,
            });

            // Fetch and display Payreq data
            function loadPayreqData() {
                $('#payreq-loading').removeClass('d-none');

                $.ajax({
                    url: '{{ env('PAYREQ_API_URL', 'http://payreq.local') }}/api/realization-details/sum-by-unit',
                    method: 'GET',
                    data: {
                        unit_no: '{{ $equipment->unit_no }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            let html = '';

                            if (response.data.type_sums && response.data.type_sums.length > 0) {
                                // Sort expense types alphabetically
                                response.data.type_sums.sort((a, b) => a.type.localeCompare(b.type));

                                response.data.type_sums.forEach(function(item) {
                                    // Capitalize the first letter of each type
                                    const formattedType = item.type.charAt(0).toUpperCase() +
                                        item.type.slice(1);

                                    html += `<tr>
                                        <td>${formattedType}</td>
                                        <td class="text-right">${item.total_amount}</td>
                                    </tr>`;
                                });
                            } else {
                                html = `<tr>
                                    <td colspan="2" class="text-center">No payment requisition data found</td>
                                </tr>`;
                            }

                            $('#payreq-data').html(html);

                            // Use the grand_total from the API response if available
                            if (response.data.grand_total) {
                                $('#payreq-total').text(response.data.grand_total);
                            } else {
                                // Fallback to calculating total if grand_total is not provided
                                let totalAmount = 0;
                                if (response.data.type_sums && response.data.type_sums.length > 0) {
                                    response.data.type_sums.forEach(function(item) {
                                        const amountValue = parseFloat(item.total_amount
                                            .replace(/,/g, ''));
                                        totalAmount += amountValue;
                                    });
                                }
                                $('#payreq-total').text(new Intl.NumberFormat('id-ID').format(
                                    totalAmount));
                            }
                        } else {
                            $('#payreq-data').html(`<tr>
                                <td colspan="2" class="text-center text-danger">Error loading data</td>
                            </tr>`);
                            $('#payreq-total').text('0.00');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#payreq-data').html(`<tr>
                            <td colspan="2" class="text-center text-danger">Could not connect to Payreq service</td>
                        </tr>`);
                        $('#payreq-total').text('0.00');
                        console.error('Payreq API error:', error);
                    },
                    complete: function() {
                        $('#payreq-loading').addClass('d-none');
                    }
                });
            }

            // Load Payreq data when tab is shown
            $('a[href="#content-payreq"]').on('shown.bs.tab', function(e) {
                loadPayreqData();
            });

            // Refresh Payreq data when refresh button is clicked
            $('#refresh-payreq').on('click', function() {
                const $btn = $(this);

                // Show spinning animation on button
                $btn.addClass('fa-spin');
                $btn.prop('disabled', true);

                // Reload data
                loadPayreqData();

                // Stop spinning and re-enable button after a short delay
                setTimeout(function() {
                    $btn.removeClass('fa-spin');
                    $btn.prop('disabled', false);
                }, 1000);
            });

            // Handle tab switching with loading indicators
            $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
                // Adjust columns when switching tabs
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();

                // For smoother animations
                $($(this).attr('href')).find('.table-responsive').hide().fadeIn(300);
            });

            // Preload the next tab data when hovering on tab
            $('a[data-toggle="pill"]').on('mouseover', function() {
                // Preload the data for this tab if it hasn't been loaded yet
                var tabId = $(this).attr('id');
                var targetId = tabId.replace('tab-', '');

                // We could potentially preload the data here
                // but for now, just preparing the UI to feel more responsive
                $(this).css('transition', 'all 0.2s ease');
            });
        });
    </script>
@endsection
