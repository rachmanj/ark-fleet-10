<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'unit_no' => $this->unit_no,
            'description' => $this->description,
            'active_date' => $this->active_date,
            'nomor_polisi' => $this->nomor_polisi,
            'serial_no' => $this->serial_no,
            'chasis_no' => $this->chasis_no,
            'engine_model' => $this->engine_model,
            'machine_no' => $this->machine_no,
            'bahan_bakar' => $this->bahan_bakar,
            'warna' => $this->warna,
            'capacity' => $this->capacity,
            'remarks' => $this->remarks,
            'project_code' => $this->current_project->project_code ?? null,
            'project_id' => $this->current_project_id,
            'plant_group' => $this->plant_group->name,
            'plant_group_id' => $this->plant_group_id,
            'model' => $this->unitmodel->model_no,
            'model_id' => $this->unitmodel_id,
            'unitstatus' => $this->unitstatus->name,
            'unitstatus_id' => $this->unitstatus_id,
            'asset_category' => $this->asset_category->name,
            'asset_category_id' => $this->asset_category_id,
            'plant_type' => $this->plant_type->name,
            'plant_type_id' => $this->plant_type_id,
        ];
    }
}
