@extends('templates.main')

@section('title_page')
    Equipments
@endsection

@section('breadcrumb_title')
    equipments
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm animated fadeIn">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="action-buttons">
                        @can('create_equipment')
                            <a href="{{ route('equipments.create') }}" class="btn btn-sm btn-primary btn-hover-effect">
                                <i class="fas fa-plus"></i> Equipment
                            </a>
                        @endcan
                        @can('export_equipment')
                            <a href="{{ route('equipments.export_excel') }}" class="btn btn-sm btn-success btn-hover-effect">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </a>
                        @endcan
                    </div>
                    <div class="admin-actions">
                        @can('update_rfu')
                            <button class="btn btn-sm btn-warning btn-hover-effect mx-2" data-toggle="modal"
                                data-target="#update_to_rfu">
                                <i class="fas fa-sync-alt"></i> Update RFU Units
                            </button>
                            <button class="btn btn-sm btn-warning btn-hover-effect" data-toggle="modal"
                                data-target="#update_to_bd">
                                <i class="fas fa-tools"></i> Update B/D Units
                            </button>
                        @endcan
                    </div>
                </div> {{-- card-header --}}

                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary shadow-sm animated fadeIn delay-1">
                                <div class="card-header bg-light">
                                    <h3 class="card-title">
                                        <i class="fas fa-search mr-2"></i> Search Equipment
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
                                                        placeholder="Quick search: Type unit number, serial, model...">
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
                                                        <label for="unit_no">Unit No</label>
                                                        <select class="form-control" id="unit_no" name="unit_no">
                                                            <option value="">-- Select Unit No --</option>
                                                            @forelse($unit_nos as $unit_no)
                                                                <option value="{{ $unit_no }}">{{ $unit_no }}
                                                                </option>
                                                            @empty
                                                                <option disabled>No units available</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="model">Model</label>
                                                        <select class="form-control" id="model" name="model">
                                                            <option value="">-- Select Model --</option>
                                                            @forelse($models as $model)
                                                                <option value="{{ $model->model_no }}">
                                                                    {{ $model->model_no }}
                                                                </option>
                                                            @empty
                                                                <option disabled>No models available</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="asset_category">Asset Category</label>
                                                        <select class="form-control" id="asset_category"
                                                            name="asset_category">
                                                            <option value="">-- Select Asset Category --</option>
                                                            @forelse($asset_categories as $category)
                                                                <option value="{{ $category->name }}">{{ $category->name }}
                                                                </option>
                                                            @empty
                                                                <option disabled>No asset categories available</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="manufacture">Manufacture</label>
                                                        <select class="form-control" id="manufacture" name="manufacture">
                                                            <option value="">-- Select Manufacture --</option>
                                                            @forelse($manufactures as $manufacture)
                                                                <option value="{{ $manufacture->name }}">
                                                                    {{ $manufacture->name }}</option>
                                                            @empty
                                                                <option disabled>No manufacturers available</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="serial_no">Serial Number</label>
                                                        <input type="text" class="form-control" id="serial_no"
                                                            name="serial_no" placeholder="Enter serial number">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="plant_type">Plant Type</label>
                                                        <select class="form-control" id="plant_type" name="plant_type">
                                                            <option value="">-- Select Plant Type --</option>
                                                            @forelse($plant_types as $plant_type)
                                                                <option value="{{ $plant_type->name }}">
                                                                    {{ $plant_type->name }}</option>
                                                            @empty
                                                                <option disabled>No plant types available</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="current_project">Location/Project</label>
                                                        <select class="form-control" id="current_project"
                                                            name="current_project">
                                                            <option value="">-- Select Location/Project --</option>
                                                            @forelse($projects as $project)
                                                                <option value="{{ $project->project_code }}">
                                                                    {{ $project->project_code }} -
                                                                    {{ $project->location }}
                                                                </option>
                                                            @empty
                                                                <option disabled>No projects available</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="is_rfu">Status</label>
                                                        <select class="form-control" id="is_rfu" name="is_rfu">
                                                            <option value="">All</option>
                                                            <option value="RFU">RFU</option>
                                                            <option value="B/D">B/D</option>
                                                            @forelse($unitstatuses as $status)
                                                                @if ($status->id > 1)
                                                                    {{-- Skip active status which is already covered by RFU/B/D --}}
                                                                    <option value="{{ $status->id }}">
                                                                        {{ $status->name }}
                                                                    </option>
                                                                @endif
                                                            @empty
                                                                <option disabled>No additional statuses available</option>
                                                            @endforelse
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
                        <span id="results-count">0</span> equipment(s) found
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="table-responsive animated fadeIn delay-2">
                        <table id="equipments" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit No</th>
                                    <th>Model</th>
                                    <th>Asset Category</th>
                                    <th>Manufacture</th>
                                    <th>SN</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>action</th>
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
            <p class="mt-2 text-white">Loading equipment data...</p>
        </div>
    </div>

    {{-- MODAL UPDATE TO RFU --}}
    <div class="modal fade" id="update_to_rfu">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeInUp faster">
                <div class="modal-header bg-warning text-white">
                    <h4 class="modal-title"><i class="fas fa-sync-alt mr-2"></i> Update to RFU</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('equipments.update_rfu') }}" method="POST">
                    @csrf @method('POST')

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select Equipments to update to RFU</label>
                            <div class="select2-purple">
                                <select name="equipments[]" class="select2 form-control" multiple="multiple"
                                    data-dropdown-css-class="select2-purple" data-placeholder="Select Equipments"
                                    style="width: 100%;">
                                    @foreach (\App\Models\Equipment::where('is_rfu', 0)->where('unitstatus_id', 1)->get() as $equipment)
                                        <option value="{{ $equipment->id }}">
                                            {{ $equipment->unit_no . ' - ' . $equipment->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-default btn-hover-effect" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-hover-effect">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                    </div>
                </form>
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div>

    {{-- MODAL UPDATE TO BD --}}
    <div class="modal fade" id="update_to_bd">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated fadeInUp faster">
                <div class="modal-header bg-warning text-white">
                    <h4 class="modal-title"><i class="fas fa-tools mr-2"></i> Update to B/D</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('equipments.update_bd') }}" method="POST">
                    @csrf @method('POST')

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select Equipments to update to B/D</label>
                            <div class="select2-purple">
                                <select name="equipments[]" class="select2 form-control" multiple="multiple"
                                    data-dropdown-css-class="select2-purple" data-placeholder="Select Equipments"
                                    style="width: 100%;">
                                    @foreach (\App\Models\Equipment::where('is_rfu', 1)->where('unitstatus_id', 1)->get() as $equipment)
                                        <option value="{{ $equipment->id }}">
                                            {{ $equipment->unit_no . ' - ' . $equipment->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-default btn-hover-effect" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-hover-effect">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                    </div>
                </form>
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div>
@endsection

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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

        /* Status badges */
        .badge-rfu {
            background-color: #28a745;
            color: white;
        }

        .badge-bd {
            background-color: #dc3545;
            color: white;
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

            .admin-actions {
                margin-top: 10px;
            }

            .action-buttons .btn,
            .admin-actions .btn {
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
            $('.select2').select2();

            $('#is_rfu').select2({
                theme: 'bootstrap4',
                placeholder: "Select status"
            });

            $('#plant_type').select2({
                theme: 'bootstrap4',
                placeholder: "Select plant type"
            });

            $('#current_project').select2({
                theme: 'bootstrap4',
                placeholder: "Select location/project"
            });

            $('#unit_no').select2({
                theme: 'bootstrap4',
                placeholder: "Select unit number"
            });

            $('#model').select2({
                theme: 'bootstrap4',
                placeholder: "Select model"
            });

            $('#asset_category').select2({
                theme: 'bootstrap4',
                placeholder: "Select asset category"
            });

            $('#manufacture').select2({
                theme: 'bootstrap4',
                placeholder: "Select manufacture"
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
            const equipmentsTable = $('#equipments').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                retrieve: true,
                searching: false, // Disable built-in search
                ajax: {
                    url: "{{ route('equipments.index.data') }}",
                    data: function(d) {
                        // Quick search parameter
                        d.quick_search = $('#quick_search').val();

                        // Advanced search parameters
                        d.unit_no = $('#unit_no').val();
                        d.model = $('#model').val();
                        d.asset_category = $('#asset_category').val();
                        d.manufacture = $('#manufacture').val();
                        d.serial_no = $('#serial_no').val();
                        d.plant_type = $('#plant_type').val();
                        d.current_project = $('#current_project').val();
                        d.is_rfu = $('#is_rfu').val();
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
                            text: 'Error loading equipment data. Please refresh the page and try again.',
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
                        data: 'unit_no'
                    },
                    {
                        data: 'model'
                    },
                    {
                        data: 'asset_category'
                    },
                    {
                        data: 'manufacture'
                    },
                    {
                        data: 'serial_no'
                    },
                    {
                        data: 'plant_type'
                    },
                    {
                        data: 'current_project'
                    },
                    {
                        data: 'is_rfu',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                if (data.includes('RFU')) {
                                    return '<span class="badge badge-rfu">' + data + '</span>';
                                } else if (data.includes('B/D')) {
                                    return '<span class="badge badge-bd">' + data + '</span>';
                                } else {
                                    return '<span class="badge badge-secondary">' + data +
                                        '</span>';
                                }
                            }
                            return data;
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                orderCellsTop: true,
                order: [
                    [1, 'asc']
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    emptyTable: '<div class="text-center py-4"><i class="fas fa-box-open fa-3x text-muted mb-3"></i><br>No equipment found</div>'
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>rtip', // Remove search box from DOM
                drawCallback: function() {
                    // Add custom classes to table rows for animation
                    $('#equipments tbody tr').each(function(index) {
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
                    equipmentsTable.ajax.reload();
                }, 500);
            });

            // Quick search button click event
            $('#btn-quick-search').on('click', function() {
                loadingOverlay.removeClass('d-none');
                equipmentsTable.ajax.reload();
            });

            // Search button click event
            $('#btn-search').on('click', function() {
                loadingOverlay.removeClass('d-none');
                equipmentsTable.ajax.reload();
            });

            // Reset button click event
            $('#btn-reset').on('click', function() {
                $('#search-form')[0].reset();
                $('#quick_search').val('');
                $('#is_rfu').val('').trigger('change'); // Reset Select2
                $('#plant_type').val('').trigger('change'); // Reset Select2
                $('#current_project').val('').trigger('change'); // Reset Select2
                $('#unit_no').val('').trigger('change'); // Reset Select2
                $('#model').val('').trigger('change'); // Reset Select2
                $('#asset_category').val('').trigger('change'); // Reset Select2
                $('#manufacture').val('').trigger('change'); // Reset Select2
                loadingOverlay.removeClass('d-none');
                equipmentsTable.ajax.reload();
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
                equipmentsTable.responsive.recalc();
            });
        });
    </script>
@endsection
