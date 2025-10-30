<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARKFleet v10</title>
  
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  
    <style>
        /* Disable table-striped globally for better dark mode compatibility */
        .table-striped tbody tr:nth-of-type(odd),
        .table-striped tbody tr:nth-of-type(even) {
            background-color: transparent !important;
        }
        
        /* Force disable stripes in dark mode - override AdminLTE defaults */
        .dark-mode .table-striped tbody tr:nth-of-type(odd),
        .dark-mode .table-striped tbody tr:nth-of-type(even) {
            background-color: transparent !important;
        }
        
        /* Additional override for DataTables in dark mode */
        .dark-mode table.dataTable.table-striped tbody tr:nth-of-type(odd),
        .dark-mode table.dataTable.table-striped tbody tr:nth-of-type(even) {
            background-color: transparent !important;
        }
        
        /* Ensure consistent background for all table rows in dark mode */
        .dark-mode .table tbody tr {
            background-color: transparent !important;
        }
    </style>

    @yield('styles')
  </head>