<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentDetailResource extends JsonResource
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
            'unit_pic' => $this->unit_pic,
            'assign_to' => $this->assign_to,
            'remarks' => $this->remarks,
            'project' => [
                'id' => $this->current_project_id,
                'project_code' => $this->current_project->project_code ?? null,
                'bowheer' => $this->current_project->bowheer ?? null,
                'location' => $this->current_project->location ?? null,
            ],
            'plant_group' => [
                'id' => $this->plant_group_id,
                'name' => $this->plant_group->name,
            ],
            'model' => [
                'id' => $this->unitmodel_id,
                'model_no' => $this->unitmodel->model_no,
            ],
            'unitstatus' => [
                'id' => $this->unitstatus_id,
                'name' => $this->unitstatus->name,
            ],
            'asset_category' => [
                'id' => $this->asset_category_id,
                'name' => $this->asset_category->name,
            ],
            'plant_type' => [
                'id' => $this->plant_type_id,
                'name' => $this->plant_type->name,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

