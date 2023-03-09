@extends('templates.main')

@section('title_page')
    Hazard Report <small>(Pending)</small>
@endsection

@section('breadcrumb_title')
    hazard-report
@endsection

@section('content')
<div class="row">
  <div class="col-12">

    <div class="card">
      <div class="card-header">
        <a href="#"><b>PENDING REPORTS</b> | </a>
        <a href="{{ route('hazard-rpt.closed_index') }}"> Closed Reports</a>
        <a href="{{ route('hazard-rpt.create') }}" class="btn btn-sm btn-primary float-right mx-3"><i class="fas fa-plus"></i> New Report</a>
        <a href="{{ route('hazard-rpt.export_to_excel') }}" class="btn btn-sm btn-success float-right"><i class="fas fa-file-excel"></i>   Export to Excel</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="hazard-rpt" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>Nomor</th>
            <th>Project</th>
            <th>To Dept</th>
            <th>Date & Time</th>
            <th>Description</th>
            <th>Days</th>
            <th></th>
          </tr>
          </thead>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


@endsection

@section('styles')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/plugins/datatables/css/datatables.min.css') }}"/>
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
  $(function () {
    $("#hazard-rpt").DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('hazard-rpt.data') }}',
      columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'nomor'},
        {data: 'project_code'},
        {data: 'to_department_id'},
        {data: 'created_at'},
        {data: 'description'},
        {data: 'days'},
        {data: 'action', orderable: false, searchable: false},
      ],
      fixedHeader: true,
      columnDefs: [
              {
                "targets": [6],
                "className": "text-right"
              },
            ]
    })
  });
</script>
@endsection