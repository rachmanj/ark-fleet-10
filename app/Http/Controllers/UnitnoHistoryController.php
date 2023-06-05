<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\UnitnoHistory;
use App\Models\Unitstatus;
use Illuminate\Http\Request;

class UnitnoHistoryController extends Controller
{
    public function index()
    {
        return view('unitno_histories.index');
    }

    public function create()
    {
        $unit_active = Unitstatus::where('name', 'ACTIVE')->first()->id;
        $equipments = Equipment::where('unitstatus_id', $unit_active)->orderBy('unit_no', 'asc')->get();
        return view('unitno_histories.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'equipment_id' => 'required',
            'new_unit_no' => 'required|unique:equipments,unit_no'
        ]);

        $equipment = Equipment::find($request->equipment_id);
        $unit_history = UnitnoHistory::create([
            'date' => $request->date,
            'equipment_id' => $request->equipment_id,
            'old_unit_no' => $equipment->unit_no,
            'new_unit_no' => $request->new_unit_no,
            'remarks' => $request->remarks,
        ]);

        $equipment->update([
            'unit_no' => $request->new_unit_no
        ]);

        // log activity
        $logger = app(LoggerController::class);
        $description = auth()->user()->name . ' changed unit no ' . $unit_history->old_unit_no . ' to ' . $unit_history->new_unit_no;
        $logger->store($description);

        return redirect()->route('unitnohistories.index')->with('sccuess', 'Unit change successfully added');
    }

    public function show($id)
    {
        $unitno_history = UnitnoHistory::with('equipment')->find($id);

        return view('unitno_histories.show', compact('unitno_history'));
    }

    public function edit($id)
    {
        $unitno_history = UnitnoHistory::with('equipment')->find($id);

        return view('unitno_histories.edit', compact('unitno_history'));
    }

    public function update(Request $request, $id)
    {
        $unitno_history = UnitnoHistory::find($id);

        $this->validate($request, [
            'date' => 'required'
        ]);

        $unitno_history->update([
            'date' => $request->date,
            'remarks' => $request->remarks
        ]);

        return redirect()->route('unitnohistories.index')->with('sccuess', 'Unit change successfully updated');
    }

    public function index_data()
    {
        $unitno_histories = UnitnoHistory::orderBy('date', 'desc')->get();

        return datatables()->of($unitno_histories)
            ->editColumn('date', function ($unitno_histories) {
                return date('d-M-Y', strtotime($unitno_histories->date));
            })
            ->addColumn('equipment', function ($unitno_histories) {
                return $unitno_histories->equipment->unitmodel->model_no . ' - ' . $unitno_histories->equipment->unitmodel->manufacture->name;
            })
            ->addColumn('creator', function ($unitno_histories) {
                return $unitno_histories->creator->name;
            })
            ->addIndexColumn()
            ->addColumn('action', 'unitno_histories.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
