<div class="equipment-info">
    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-truck"></i> Equipment Details
            </h5>
            <div class="info-group">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Unit No</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->unit_no }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Active Date</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">
                            {{ $equipment->active_date ? date('d-M-Y', strtotime($equipment->active_date)) : ' -' }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Description</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->description }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Model</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">
                            {{ $equipment->unitmodel->model_no . ' | ' . $equipment->unitmodel->description }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Manufacture</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->unitmodel->manufacture->name }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Plant Type</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->plant_type->name }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Asset Category</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->asset_category->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h5 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-cogs"></i> Technical Specifications
            </h5>
            <div class="info-group">
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Serial No</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->serial_no ?: '-' }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Engine Model</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->engine_model ?: '-' }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Machine No</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->machine_no ?: '-' }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Nomor Polisi</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->nomor_polisi ?: '-' }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Body Color</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->warna ?: '-' }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Fuel Type</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->bahan_bakar ?: '-' }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Capacity</label>
                    <div class="col-sm-7">
                        <p class="form-control-plaintext">{{ $equipment->capacity ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5 class="text-primary border-bottom pb-2 mb-3">
                <i class="fas fa-map-marker-alt"></i> Location & Notes
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Current Location</label>
                        <p class="form-control-plaintext border rounded p-2 bg-light">
                            {{ $equipment->current_project->project_code . ' - ' . $equipment->current_project->bowheer . ', ' . $equipment->current_project->location }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <p class="form-control-plaintext border rounded p-2 bg-light">
                            {{ $equipment->unitstatus->name }}
                            @if ($equipment->unitstatus_id == 1)
                                @if ($equipment->is_rfu == 1)
                                    <span class="badge badge-success ml-2">RFU</span>
                                @else
                                    <span class="badge badge-danger ml-2">B/D</span>
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <div class="border rounded p-2 bg-light">
                    {{ $equipment->remarks ?: 'No remarks available' }}
                </div>
            </div>
            <div class="text-muted mt-3">
                <small>Created by: {{ $equipment->creator->name }}</small>
            </div>
        </div>
    </div>
</div>
