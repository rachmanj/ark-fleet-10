<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Document;
use App\Models\Equipment;
use App\Models\HazardReport;
use App\Models\Logger;
use App\Models\PlantGroup;
use App\Models\PlantType;
use App\Models\Unitstatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'projects' => $this->getCurrentProjects(),
            'equipments' => $this->getEquipments(),
            'unit_status' => $this->getUnitStatus(),
            'plant_types' => $this->getPlantType(),
            'plant_groups' => $this->getPlantGroup(),
            // 'activities' => $this->getActivities(),
            'activities' => $this->getLogs(),
            'documents_expired' => $this->getDocumentsExpired(),
            'projects_for_active_units' => $this->getCurrentProjectsForActiveUnits(),
            'active_units' => $this->getActiveUnits(),
            'stats_trends' => $this->getStatsTrends(),
            'quick_stats' => $this->getQuickStats(),
        ]);
    }

    public function getCurrentProjects()
    {
        $current_project_ids = DB::table('equipments')->distinct()
            ->orderBy('current_project_id', 'asc')
            ->pluck('current_project_id');

        $current_projects = DB::table('projects')->select('project_code', 'id')
            ->whereIn('id', $current_project_ids)
            ->orderBy('project_code', 'asc')
            ->get();

        return $current_projects;
    }

    public function getEquipments()
    {
        $equipments = Equipment::select(
            'current_project_id',
            'unitstatus_id',
            'plant_type_id',
            'plant_group_id'
        )
            ->where('unitstatus_id', '<>', 4)
            ->get();

        return $equipments;
    }

    public function getUnitStatus()
    {
        $unit_status = Unitstatus::select('id', 'name')
            ->where('id', '<>', 4)
            ->get();

        return $unit_status;
    }

    public function getPlantType()
    {
        $plant_type = PlantType::select('id', 'name')->get();

        return $plant_type;
    }

    public function getPlantGroup()
    {
        $plant_group = PlantGroup::select('id', 'name')->orderBy('name', 'asc')->get();

        return $plant_group;
    }

    public function getActivities()
    {
        $activities = Activity::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return $activities;
    }

    public function getLogs()
    {
        $logs = Logger::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return $logs;
    }

    public function getDocumentsExpired()
    {
        $documents_will_expired = Document::whereNull('extended_doc_id')
            ->whereBetween('due_date', [Carbon::now(), Carbon::now()->addMonths(2)])
            ->get()->count();

        $documents_expired = Document::whereNull('extended_doc_id')
            ->where('due_date', '<=', Carbon::now())
            ->get()->count();

        return [
            'documents_will_expired' => $documents_will_expired,
            'documents_expired' => $documents_expired,
        ];
    }

    public function getCurrentProjectsForActiveUnits()
    {
        // select distinct current_project_id from equipments where unitstatus_id = 1
        $current_project_ids = DB::table('equipments')->distinct()
            ->where('unitstatus_id', 1)
            ->orderBy('current_project_id', 'asc')
            ->pluck('current_project_id');

        // get project code from projects table
        $current_projects = DB::table('projects')->select('project_code', 'id')
            ->whereIn('id', $current_project_ids)
            ->orderBy('project_code', 'asc')
            ->get();

        return $current_projects;
    }

    public function getActiveUnits()
    {
        $active_units = Equipment::where('unitstatus_id', 1)
            ->get();

        return $active_units;
    }

    public function test()
    {
        return $this->getCurrentProjectsForActiveUnits();
    }

    public function getStatsTrends()
    {
        $currentTotal = Equipment::where('unitstatus_id', '<>', 4)->count();
        $currentRFU = Equipment::where('unitstatus_id', 1)->count();
        $currentExpiring = Document::whereNull('extended_doc_id')
            ->whereBetween('due_date', [Carbon::now(), Carbon::now()->addMonths(2)])
            ->count();
        
        $lastWeekTotal = Equipment::where('unitstatus_id', '<>', 4)
            ->where('created_at', '<=', Carbon::now()->subWeek())
            ->count();
        $lastWeekRFU = Equipment::where('unitstatus_id', 1)
            ->where('updated_at', '<=', Carbon::now()->subWeek())
            ->count();
        $lastWeekExpiring = Document::whereNull('extended_doc_id')
            ->whereBetween('due_date', [Carbon::now()->subWeek(), Carbon::now()->addMonths(2)->subWeek()])
            ->where('created_at', '<=', Carbon::now()->subWeek())
            ->count();
        
        $totalTrend = $lastWeekTotal > 0 ? round((($currentTotal - $lastWeekTotal) / $lastWeekTotal) * 100, 1) : 0;
        $rfuTrend = $lastWeekRFU > 0 ? round((($currentRFU - $lastWeekRFU) / $lastWeekRFU) * 100, 1) : 0;
        $expiringTrend = $lastWeekExpiring > 0 ? round((($currentExpiring - $lastWeekExpiring) / $lastWeekExpiring) * 100, 1) : 0;
        
        return [
            'total_fleet_trend' => $totalTrend,
            'rfu_trend' => $rfuTrend,
            'expiring_trend' => $expiringTrend,
        ];
    }

    public function getQuickStats()
    {
        // Calculate fleet utilization (RFU / Total)
        $totalFleet = Equipment::where('unitstatus_id', '<>', 4)->count();
        $rfuCount = Equipment::where('unitstatus_id', 1)->count();
        $fleetUtilization = $totalFleet > 0 ? round(($rfuCount / $totalFleet) * 100, 1) : 0;

        // Calculate average age in months (based on active_date)
        $equipmentsWithDate = Equipment::where('unitstatus_id', '<>', 4)
            ->whereNotNull('active_date')
            ->get();
        
        $totalMonths = 0;
        $count = 0;
        
        foreach ($equipmentsWithDate as $equipment) {
            $activeDate = Carbon::parse($equipment->active_date);
            $monthsDiff = $activeDate->diffInMonths(Carbon::now());
            $totalMonths += $monthsDiff;
            $count++;
        }
        
        $averageAge = $count > 0 ? round($totalMonths / $count) : 0;

        return [
            'fleet_utilization' => $fleetUtilization,
            'average_age' => $averageAge,
        ];
    }
}
