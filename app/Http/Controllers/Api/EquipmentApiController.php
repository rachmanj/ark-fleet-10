<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentDetailResource;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentApiController extends Controller
{
    public function index(Request $request)
    {
        $equipments = Equipment::query();

        // Filter by project (support both ID and code)
        if ($request->has('current_project_id')) {
            $equipments->where('current_project_id', $request->current_project_id);
        } elseif ($request->has('project_code')) {
            $equipments->whereHas('current_project', function ($query) use ($request) {
                $query->where('project_code', $request->project_code);
            });
        }

        // Filter by plant group (support both ID and name)
        if ($request->has('plant_group_id')) {
            $equipments->where('plant_group_id', $request->plant_group_id);
        } elseif ($request->has('plant_group')) {
            $equipments->whereHas('plant_group', function ($query) use ($request) {
                $query->where('name', $request->plant_group);
            });
        }

        // Filter by unit status (support both ID and name)
        if ($request->has('unitstatus_id')) {
            $equipments->where('unitstatus_id', $request->unitstatus_id);
        } elseif ($request->has('status')) {
            $equipments->whereHas('unitstatus', function ($query) use ($request) {
                $query->where('name', strtoupper($request->status));
            });
        }

        $equipments->orderBy('unit_no', 'asc');

        return [
            'count' => $equipments->count(),
            'data' => EquipmentResource::collection($equipments->get()),
        ];
    }

    public function showByUnitNo($unit_no)
    {
        $equipment = Equipment::where('unit_no', $unit_no)->first();

        if (!$equipment) {
            return response()->json([
                'message' => 'Equipment not found',
                'unit_no' => $unit_no
            ], 404);
        }

        return new EquipmentDetailResource($equipment);
    }
}
