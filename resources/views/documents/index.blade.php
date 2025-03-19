@extends('templates.main')

@section('title_page')
    Documents
@endsection

@section('breadcrumb_title')
    document
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('documents.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i>
                        Document</a>
                </div> {{-- card-header --}}

                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Search Documents</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="search-form">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="document_no">Document Number</label>
                                                    <input type="text" class="form-control" id="document_no"
                                                        name="document_no" placeholder="Enter document number">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="document_type">Document Type</label>
                                                    <select class="form-control" id="document_type" name="document_type">
                                                        <option value="">-- Select Document Type --</option>
                                                        @foreach ($doctypes as $doctype)
                                                            <option value="{{ $doctype->id }}">{{ $doctype->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="unit_no">Unit Number</label>
                                                    <input type="text" class="form-control" id="unit_no" name="unit_no"
                                                        placeholder="Enter unit number">
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

                    <table id="documents" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Doc. No</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Unit No</th>
                                <th>Due Date</th>
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
            // Initialize Select2
            $('#document_type').select2({
                theme: 'bootstrap4',
                placeholder: "Select a document type"
            });

            // Show loading overlay
            const loadingOverlay = $('.loading-overlay');
            loadingOverlay.removeClass('d-none');

            // Initialize DataTable
            const documentsTable = $("#documents").DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: {
                    url: '{{ route('documents.index.data') }}',
                    data: function(d) {
                        // Add custom search parameters
                        d.document_no = $('#document_no').val();
                        d.document_type = $('#document_type').val();
                        d.unit_no = $('#unit_no').val();

                        // For debugging
                        console.log('Search parameters:', {
                            document_no: d.document_no,
                            document_type: d.document_type,
                            unit_no: d.unit_no
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
                        alert('Error loading document data. Please refresh the page and try again.');
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
                        data: 'document_date'
                    },
                    {
                        data: 'doctype'
                    },
                    {
                        data: 'unit_no'
                    },
                    {
                        data: 'due_date'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                fixedHeader: true,
                responsive: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                pageLength: 10,
                order: [
                    [2, 'desc']
                ] // Sort by date column by default
            });

            // Search button click event
            $('#btn-search').on('click', function() {
                loadingOverlay.removeClass('d-none');
                documentsTable.ajax.reload();
            });

            // Reset button click event
            $('#btn-reset').on('click', function() {
                $('#search-form')[0].reset();
                $('#document_type').val('').trigger('change'); // Reset Select2
                loadingOverlay.removeClass('d-none');
                documentsTable.ajax.reload();
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
