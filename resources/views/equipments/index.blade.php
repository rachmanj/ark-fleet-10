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

            <div class="card">

                <div class="card-header">
                    @can('create_equipment')
                        <a href="{{ route('equipments.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                            Equipment</a>
                    @endcan
                    @can('export_equipment')
                        <a href="{{ route('equipments.export_excel') }}" class="btn btn-sm btn-success"><i
                                class="fas fa-print"></i> Export to Excel</a>
                    @endcan
                    @can('update_rfu')
                        <button class="btn btn-sm btn-warning float-right mx-2" data-toggle="modal"
                            data-target="#update_to_rfu">Update RFU Units</button>
                        <button class="btn btn-sm btn-warning float-right" data-toggle="modal"
                            data-target="#update_to_bd">Update B/D Units</button>
                    @endcan
                </div> {{-- card-header --}}

                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Search Equipment</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="search-form">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="unit_no">Unit No</label>
                                                    <select class="form-control" id="unit_no" name="unit_no">
                                                        <option value="">-- Select Unit No --</option>
                                                        @forelse($unit_nos as $unit_no)
                                                            <option value="{{ $unit_no }}">{{ $unit_no }}</option>
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
                                                            <option value="{{ $model->model_no }}">{{ $model->model_no }}
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
                                                    <select class="form-control" id="asset_category" name="asset_category">
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
                                                                {{ $project->project_code }} - {{ $project->location }}
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
                                                                <option value="{{ $status->id }}">{{ $status->name }}
                                                                </option>
                                                            @endif
                                                        @empty
                                                            <option disabled>No additional statuses available</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="button" id="btn-search" class="btn btn-primary">
                                                    <i class="fas fa-search"></i> Search
                                                </button>
                                                <button type="button" id="btn-reset" class="btn btn-secondary">
                                                    <i class="fas fa-undo"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="equipments" class="table table-bordered table-striped">
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
                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div>
    </div>

    {{-- Loading overlay --}}
    <div class="loading-overlay d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    {{-- MODAL UPDATE TO RFU --}}
    <div class="modal fade" id="update_to_rfu">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Update to RFU</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <div class="modal-footer float-left">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div>

    {{-- MODAL UPDATE TO RFU --}}
    <div class="modal fade" id="update_to_bd">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Update to B/D</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <div class="modal-footer float-left">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"> Close</button>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
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
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
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

    <script>
        $(function() {
            //Initialize Select2 Elements
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
            const loadingOverlay = $('.loading-overlay');
            loadingOverlay.removeClass('d-none');

            // Initialize DataTable
            const equipmentsTable = $('#equipments').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                retrieve: true,
                ajax: {
                    url: "{{ route('equipments.index.data') }}",
                    data: function(d) {
                        // Add custom search parameters
                        d.unit_no = $('#unit_no').val();
                        d.model = $('#model').val();
                        d.asset_category = $('#asset_category').val();
                        d.manufacture = $('#manufacture').val();
                        d.serial_no = $('#serial_no').val();
                        d.plant_type = $('#plant_type').val();
                        d.current_project = $('#current_project').val();
                        d.is_rfu = $('#is_rfu').val();

                        // For debugging
                        console.log('Search parameters:', {
                            unit_no: d.unit_no,
                            model: d.model,
                            asset_category: d.asset_category,
                            manufacture: d.manufacture,
                            serial_no: d.serial_no,
                            plant_type: d.plant_type,
                            current_project: d.current_project,
                            is_rfu: d.is_rfu
                        });

                        return d;
                    },
                    dataSrc: function(json) {
                        // Hide loading overlay when data is loaded
                        loadingOverlay.addClass('d-none');
                        return json.data;
                    },
                    error: function() {
                        loadingOverlay.addClass('d-none');
                        alert('Error loading equipment data. Please refresh the page and try again.');
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
                        data: 'is_rfu'
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
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
            });

            // Search button click event
            $('#btn-search').on('click', function() {
                loadingOverlay.removeClass('d-none');
                equipmentsTable.ajax.reload();
            });

            // Reset button click event
            $('#btn-reset').on('click', function() {
                $('#search-form')[0].reset();
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
            $('#search-form input').keypress(function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#btn-search').click();
                }
            });
        });
    </script>
@endsection
