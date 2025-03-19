@extends('templates.main')

@section('title_page')
    IPA List
@endsection

@section('breadcrumb_title')
    ipa
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm animated fadeIn">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="action-buttons">
                        <a href="{{ route('movings.create') }}" class="btn btn-sm btn-primary btn-hover-effect">
                            <i class="fas fa-plus"></i> IPA
                        </a>
                    </div>
                </div> {{-- card-header --}}

                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary shadow-sm animated fadeIn delay-1">
                                <div class="card-header bg-light">
                                    <h3 class="card-title">
                                        <i class="fas fa-search mr-2"></i> Search IPA
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="search-form">
                                        <!-- Quick Search -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="quick_search"
                                                        placeholder="Quick search: Type IPA number, origin, destination...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button"
                                                            id="btn-quick-search">
                                                            <i class="fas fa-search"></i> Search
                                                        </button>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">
                                                    Quick search will look across all fields. For more specific searches,
                                                    use the filters below.
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Advanced Search Toggle -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-toggle="collapse" data-target="#advancedSearch">
                                                    <i class="fas fa-filter"></i> Advanced Filters
                                                    <i class="fas fa-chevron-down ml-1"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Advanced Search Filters -->
                                        <div class="collapse" id="advancedSearch">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="ipa_no">IPA No</label>
                                                        <input type="text" class="form-control" id="ipa_no"
                                                            name="ipa_no" placeholder="Enter IPA number">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date_from">Date From</label>
                                                        <input type="date" class="form-control" id="date_from"
                                                            name="date_from">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="date_to">Date To</label>
                                                        <input type="date" class="form-control" id="date_to"
                                                            name="date_to">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="from_project_id">Origin</label>
                                                        <select class="form-control" id="from_project_id"
                                                            name="from_project_id">
                                                            <option value="">-- Select Origin --</option>
                                                            @foreach ($projects as $project)
                                                                <option value="{{ $project->id }}">
                                                                    {{ $project->project_code }} - {{ $project->location }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="to_project_id">Destination</label>
                                                        <select class="form-control" id="to_project_id"
                                                            name="to_project_id">
                                                            <option value="">-- Select Destination --</option>
                                                            @foreach ($projects as $project)
                                                                <option value="{{ $project->id }}">
                                                                    {{ $project->project_code }} - {{ $project->location }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-12 text-right">
                                                <button type="button" id="btn-reset"
                                                    class="btn btn-secondary btn-hover-effect">
                                                    <i class="fas fa-undo"></i> Reset
                                                </button>
                                                <button type="button" id="btn-search"
                                                    class="btn btn-primary btn-hover-effect ml-2">
                                                    <i class="fas fa-search"></i> Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results info banner -->
                    <div class="results-info alert alert-info d-none animated fadeInDown" role="alert">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span id="results-count">0</span> IPA(s) found
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible animated fadeInDown">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    <div class="table-responsive animated fadeIn delay-2">
                        <table id="movings" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Reg No</th>
                                    <th>Date</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div>
    </div>

    {{-- Loading overlay --}}
    <div class="loading-overlay d-none">
        <div class="overlay-content">
            <div class="spinner-grow text-primary" role="status"></div>
            <div class="spinner-grow text-primary" role="status" style="animation-delay: 0.2s"></div>
            <div class="spinner-grow text-primary" role="status" style="animation-delay: 0.4s"></div>
            <p class="mt-2 text-white">Loading IPA data...</p>
        </div>
    </div>
@endsection

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .overlay-content {
            text-align: center;
        }

        /* Animation delays */
        .delay-1 {
            animation-delay: 0.15s;
        }

        .delay-2 {
            animation-delay: 0.3s;
        }

        /* Button hover effect */
        .btn-hover-effect {
            transition: all 0.3s ease;
        }

        .btn-hover-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Table hover effect */
        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        /* Results info */
        .results-info {
            animation-duration: 0.5s;
        }

        /* Responsive fixes */
        @media (max-width: 767.98px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .action-buttons .btn {
                margin-bottom: 5px;
            }
        }
    </style>
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/datatables.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <script>
        $(function() {
            let searchTimeout = null;
            const loadingOverlay = $('.loading-overlay');
            const resultsInfo = $('.results-info');

            // Initialize Select2 Elements
            $('#from_project_id').select2({
                theme: 'bootstrap4',
                placeholder: "Select origin"
            });

            $('#to_project_id').select2({
                theme: 'bootstrap4',
                placeholder: "Select destination"
            });

            // Show loading overlay
            loadingOverlay.removeClass('d-none');

            // Function to update results count
            function updateResultsCount(count) {
                $('#results-count').text(count);
                resultsInfo.removeClass('d-none');

                // Animate count increase
                const countElement = document.getElementById('results-count');
                const finalCount = count;
                let currentCount = 0;
                const duration = 1000; // 1 second
                const interval = 50; // update every 50ms
                const increment = Math.ceil(finalCount / (duration / interval));

                const timer = setInterval(() => {
                    currentCount = Math.min(currentCount + increment, finalCount);
                    countElement.textContent = currentCount;
                    if (currentCount >= finalCount) {
                        clearInterval(timer);
                    }
                }, interval);
            }

            // Initialize DataTable
            const movingsTable = $("#movings").DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                retrieve: true,
                searching: false,
                ajax: {
                    url: '{{ route('movings.index.data') }}',
                    data: function(d) {
                        // Quick search parameter
                        d.quick_search = $('#quick_search').val();

                        // Advanced search parameters
                        d.ipa_no = $('#ipa_no').val();
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                        d.from_project_id = $('#from_project_id').val();
                        d.to_project_id = $('#to_project_id').val();
                        return d;
                    },
                    dataSrc: function(json) {
                        // Hide loading overlay when data is loaded
                        loadingOverlay.addClass('d-none');

                        // Update results count
                        updateResultsCount(json.recordsFiltered);

                        return json.data;
                    },
                    error: function() {
                        loadingOverlay.addClass('d-none');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error loading IPA data. Please refresh the page and try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
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
                    {
                        data: 'created_by'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                orderCellsTop: true,
                order: [
                    [2, 'desc']
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
                    emptyTable: '<div class="text-center py-4"><i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i><br>No IPA records found</div>'
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>rtip',
                drawCallback: function() {
                    // Add custom classes to table rows for animation
                    $('#movings tbody tr').each(function(index) {
                        $(this).addClass('animated fadeIn');
                        $(this).css('animation-delay', (index * 0.05) + 's');
                    });
                }
            });

            // Quick search input event (debounced)
            $('#quick_search').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    loadingOverlay.removeClass('d-none');
                    movingsTable.ajax.reload();
                }, 500);
            });

            // Quick search button click event
            $('#btn-quick-search').on('click', function() {
                loadingOverlay.removeClass('d-none');
                movingsTable.ajax.reload();
            });

            // Search button click event
            $('#btn-search').on('click', function() {
                loadingOverlay.removeClass('d-none');
                movingsTable.ajax.reload();
            });

            // Reset button click event
            $('#btn-reset').on('click', function() {
                $('#search-form')[0].reset();
                $('#quick_search').val('');
                $('#from_project_id').val('').trigger('change');
                $('#to_project_id').val('').trigger('change');
                loadingOverlay.removeClass('d-none');
                movingsTable.ajax.reload();
            });

            // Enter key press event for search
            $('#search-form input, #quick_search').keypress(function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#btn-search').click();
                }
            });

            // Improved loading overlay animations
            $(document).ajaxStart(function() {
                loadingOverlay.removeClass('d-none');
            }).ajaxStop(function() {
                loadingOverlay.addClass('d-none');
            });

            // Fix for table responsive behavior on mobile
            $(window).resize(function() {
                movingsTable.responsive.recalc();
            });
        });
    </script>
@endsection
