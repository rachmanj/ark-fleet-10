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
            'unit_code' => $this->unit_no,
            'project' => $this->current_project->project_code,
            'plant_group' => $this->plant_group->name,
            'model' => $this->unitmodel->model_no,
        ];
    }
}
