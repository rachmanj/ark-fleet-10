<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentApiController extends Controller
{
    public function index()
    {
        $equipments = Equipment::where('unitstatus_id', 1)->orderBy('unit_no', 'asc');

        return [
            'count' => $equipments->count(),
            'data' => EquipmentResource::collection($equipments->get()),
        ];
    }

    // count equipments by project
    public function count_active_by_project()
    {
        $equipment_by_project = Equipment::where('unitstatus_id', 1)
            ->select('current_project_id', DB::raw('count(*) as total'))
            ->groupBy('current_project_id')
            ->get();

        $reponse = [];
        foreach ($equipment_by_project as $equipment) {
            $reponse[$equipment->current_project_id] = [
                'project_code' => $equipment->current_project->project_code,
                'count' => $equipment->total
            ];
        }

        return $reponse;
    }

    public function test2()
    {
        $equipment_by_project = Equipment::where('unitstatus_id', 1)
            ->select('current_project_id', DB::raw('count(*) as total'))
            ->groupBy('current_project_id')
            ->get();

        $reponse = [];
        foreach ($equipment_by_project as $equipment) {
            $reponse[$equipment->current_project_id] = [
                'project_code' => $equipment->current_project->project_code,
                'count' => $equipment->total
            ];
        }

        return $reponse;
    }

    // count equipments by project
    public function test()
    {
        $equipments = Equipment::where('unitstatus_id', 1)->get();

        $projects = [];
        foreach ($equipments as $equipment) {
            if ($equipment->current_project_id) {
                if (array_key_exists($equipment->current_project_id, $projects)) {
                    $projects[$equipment->current_project_id] += 1;
                } else {
                    $projects[$equipment->current_project_id] = 1;
                }
            }
        }

        $projects_with_code = [];
        foreach ($projects as $key => $value) {
            $projects_with_code[$key] = [
                'project_code' => $equipment->current_project->project_code,
                'count' => $value
            ];
        }



        return $projects_with_code;
    }
}
