@extends('templates.main')

@section('title_page')
    Dashboard
@endsection

@section('breadcrumb_title')
    dashboard
@endsection

@section('content')

   
  <div class="row">
    <div class="col-6">
      @include('dashboard.document_expired')
    </div>
    <div class="col-6">
      @include('dashboard.logger')
    </div>
  </div>  

  <div class="row">
    <div class="col-12">
      @include('dashboard.status_rfu')
    </div>
  </div>

  
  <div class="row">
    <div class="col-6">
      @include('dashboard.by_status')
    </div>
    <div class="col-6">
      @include('dashboard.by_plant_type')
    </div>
  </div>

  {{-- 
  <div class="row">
    <div class="col-12">
        @include('dashboard.by_plant_group')
    </div>
  </div> --}}
@endsection
