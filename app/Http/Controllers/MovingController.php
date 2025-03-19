<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Moving;
use App\Models\Project;
use App\Models\Unitstatus;
use Illuminate\Http\Request;

class MovingController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('project_code', 'asc')->get();
        return view('movings.index', compact('projects'));
    }

    public function create()
    {

        $projects = Project::where('isActive', 1)->orderBy('project_code', 'asc')->get();

        return view('movings.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'ipa_date' => ['required'],
            'from_project_id' => ['required'],
            'to_project_id' => ['required'],
            'tujuan_row_1' => ['required'],
            'cc_row_1' => ['required'],
            'ipa_no' => ['required', 'unique:movings,ipa_no']
        ]);

        $moving_flag = 'DRAFT' . auth()->id();
        $moving = Moving::create(array_merge($validated, [
            'ipa_no' => $request->ipa_no,
            'tujuan_row_2' => $request->tujuan_row_2,
            'cc_row_2' => $request->cc_row_2,
            'cc_row_3' => $request->cc_row_3,
            'remarks' => $request->remarks,
            'flag' => $moving_flag,
        ]));

        $moving_id = $moving->id;

        // log activity
        $logger = app(LoggerController::class);
        $description = auth()->user()->name . ' created IPA ' . $moving->ipa_no;
        $logger->store($description);

        return redirect()->route('moving_details.create', $moving_id);
    }

    public function edit_before_select_equipment($moving_id)
    {
        $moving = Moving::find($moving_id);
        $projects = Project::where('isActive', 1)->orderBy('project_code', 'asc')->get();

        return view('movings.edit_before_equipment', compact('moving', 'projects'));
    }

    public function update_before_select_equipment(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'ipa_date' => ['required'],
            'from_project_id' => ['required'],
            'to_project_id' => ['required'],
            'tujuan_row_1' => ['required'],
            'cc_row_1' => ['required'],
            'ipa_no' => ['required', 'unique:movings,ipa_no,' . $id]
        ]);

        $moving = Moving::find($id);
        $moving->update(array_merge($validated, [
            'ipa_no' => $request->ipa_no,
            'tujuan_row_2' => $request->tujuan_row_2,
            'cc_row_2' => $request->cc_row_2,
            'cc_row_3' => $request->cc_row_3,
            'remarks' => $request->remarks,
        ]));

        // log activity
        $logger = app(LoggerController::class);
        $description = auth()->user()->name . ' updated IPA ' . $moving->ipa_no;
        $logger->store($description);

        return redirect()->route('moving_details.create', $id);
    }

    public function print_pdf($id)
    {
        $moving = Moving::with('moving_details.equipment')->where('id', $id)->first();

        return view('movings.print_pdf', compact('moving'));
    }

    public function print2_pdf($id)
    {
        $moving = Moving::with('moving_details.equipment')->where('id', $id)->first();

        return view('movings.print2_pdf', compact('moving'));
    }

    public function edit(Moving $moving)
    {
        $projects = Project::where('isActive', 1)->orderBy('project_code', 'asc')->get();

        return view('movings.edit', compact('moving', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validate($request, [
            'ipa_date' => ['required'],
            'from_project_id' => ['required'],
            'to_project_id' => ['required'],
            'tujuan_row_1' => ['required'],
            'cc_row_1' => ['required'],
            'ipa_no' => ['required', 'unique:movings,ipa_no,' . $id]
        ]);

        $moving = Moving::find($id);
        $moving->update(array_merge($validated, [
            'ipa_no' => $request->ipa_no,
            'tujuan_row_2' => $request->tujuan_row_2,
            'cc_row_2' => $request->cc_row_2,
            'cc_row_3' => $request->cc_row_3,
            'remarks' => $request->remarks,
        ]));

        // log activity
        $logger = app(LoggerController::class);
        $description = auth()->user()->name . ' created IPA ' . $moving->ipa_no;
        $logger->store($description);

        return redirect()->route('movings.index')->with('success', 'Data successfully updated');
    }

    public function destroy(Moving $moving)
    {
        $moving->delete();
        // save activity
        $activity = app(ActivityController::class);
        $activity->store(auth()->user()->id, 'delete', 'Moving', $moving->id);

        return redirect()->route('movings.index')->with('success', 'IPA successfully deleted');
    }

    public function index_data()
    {
        $movings = Moving::with(['creator', 'from_project', 'to_project']);

        // Handle quick search
        if (request()->has('quick_search') && request('quick_search') != '') {
            $searchTerm = request('quick_search');
            $movings->where(function ($query) use ($searchTerm) {
                $query->where('ipa_no', 'like', '%' . $searchTerm . '%')
                    ->orWhere('ipa_date', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('from_project', function ($q) use ($searchTerm) {
                        $q->where('project_code', 'like', '%' . $searchTerm . '%')
                            ->orWhere('location', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('to_project', function ($q) use ($searchTerm) {
                        $q->where('project_code', 'like', '%' . $searchTerm . '%')
                            ->orWhere('location', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Apply IPA No filter
        if (request()->has('ipa_no') && request('ipa_no') != '') {
            $movings->where('ipa_no', 'like', '%' . request('ipa_no') . '%');
        }

        // Apply date range filter
        if (request()->has('date_from') && request('date_from') != '') {
            $movings->where('ipa_date', '>=', request('date_from'));
        }

        if (request()->has('date_to') && request('date_to') != '') {
            $movings->where('ipa_date', '<=', request('date_to'));
        }

        // Apply from_project filter
        if (request()->has('from_project_id') && request('from_project_id') != '') {
            $movings->where('from_project_id', request('from_project_id'));
        }

        // Apply to_project filter
        if (request()->has('to_project_id') && request('to_project_id') != '') {
            $movings->where('to_project_id', request('to_project_id'));
        }

        $movings = $movings->orderBy('ipa_date', 'desc')
            ->orderBy('ipa_no', 'desc')
            ->get();

        return datatables()->of($movings)
            ->editColumn('ipa_date', function ($movings) {
                return date('d-M-Y', strtotime($movings->ipa_date));
            })
            ->editColumn('from_project', function ($movings) {
                return $movings->from_project->project_code;
            })
            ->editColumn('to_project', function ($movings) {
                return $movings->to_project->project_code;
            })
            ->editColumn('created_by', function ($movings) {
                return $movings->creator->name;
            })
            ->addIndexColumn()
            ->addColumn('action', 'movings.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
