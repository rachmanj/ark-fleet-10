<?php

namespace App\Http\Controllers;

use App\Exports\HazardReportExport;
use App\Models\DangerType;
use App\Models\Department;
use App\Models\HazardReport;
use App\Models\ReportAttachment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HazardReportController extends Controller
{
    public function index()
    {
        return view('hazard-rpt.index');
    }

    public function create()
    {
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];
        $departments = Department::orderBy('department_name', 'asc')->get();
        $danger_types = DangerType::orderBy('name', 'asc')->get();
        $date_time = Carbon::now()->addHours(8)->format('d M Y H:i:s');
        $nomor = Carbon::now()->addHours(8)->format('y') . '/SHE/' . auth()->user()->project . '/' . str_pad(HazardReport::count() + 1, 3, '0', STR_PAD_LEFT);

        return view('hazard-rpt.create', compact('projects', 'departments', 'danger_types', 'date_time', 'nomor'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        // die;

        $request->validate([
            'project_code' => 'required',
            'to_department_id' => 'required',
            'description' => 'required',
        ]);

        $hazard = new HazardReport();
        $hazard->nomor = 'H' . Carbon::now()->addHours(8)->format('y') . '/' . $request->project_code . '/' . str_pad(HazardReport::count() + 1, 3, '0', STR_PAD_LEFT);
        $hazard->project_code = $request->project_code;
        $hazard->to_department_id = $request->to_department_id;
        $hazard->category = $request->category;
        $hazard->danger_type_id = $request->danger_type_id;
        $hazard->description = $request->description;
        $hazard->created_by = auth()->user()->id;
        $hazard->save();

        if ($request->danger_types) {
            foreach ($request->danger_types as $danger_type) {
                $hazard->danger_types()->attach($danger_type);
            }
        }

        if ($request->file_upload) {
            foreach ($request->file_upload as $file) {
                $filename = rand() . '_' . $file->getClientOriginalName();
                $file->move(public_path('document_upload'), $filename);

                $attachment = new ReportAttachment();
                $attachment->hazard_report_id = $hazard->id;
                $attachment->filename = $filename;
                $attachment->uploaded_by = auth()->user()->id;
                $attachment->save();
            }
        }

        return redirect()->route('hazard-rpt.index')->with('success', 'Hazard Report has been created successfully.');
    }

    public function show($id)
    {
        $hazard = HazardReport::with('danger_types')->findOrFail($id);
        $attachments = ReportAttachment::where('hazard_report_id', $id)->get();
        // return $hazard;
        // die;

        return view('hazard-rpt.show', compact('hazard', 'attachments'));
    }

    public function show_closed($id)
    {
        $hazard = HazardReport::findOrFail($id);
        $attachments = ReportAttachment::where('hazard_report_id', $id)->get();

        return view('hazard-rpt.show_closed', compact('hazard', 'attachments'));
    }

    public function store_attachment(Request $request)
    {
        app(ReportAttachmentController::class)->store($request);

        return redirect()->route('hazard-rpt.show', $request->hazard_report_id)->with('success', 'Attachment has been uploaded successfully.');
    }

    public function store_response(Request $request)
    {
        app(HazardResponseController::class)->store($request);

        return redirect()->route('hazard-rpt.show', $request->hazard_report_id)->with('success', 'Response has been submitted successfully.');
    }

    public function edit($id)
    {
        $hazard = HazardReport::findOrFail($id);
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];
        $departments = Department::orderBy('department_name', 'asc')->get();
        $danger_types = DangerType::orderBy('name', 'asc')->get();

        return view('hazard-rpt.edit', compact('hazard', 'projects', 'departments', 'danger_types'));
    }

    public function close_report($id) // update status to closed
    {
        $hazard = HazardReport::findOrFail($id);
        $hazard->status = 'closed';
        $hazard->updated_by = auth()->user()->id;
        $hazard->closed_date = Carbon::now();
        $hazard->save();

        return redirect()->route('hazard-rpt.index')->with('success', 'Hazard Report has been closed successfully.');
    }

    public function destroy($id)
    {
        $hazard = HazardReport::findOrFail($id);
        $hazard->delete();

        return redirect()->route('hazard-rpt.index')->with('success', 'Hazard Report has been deleted successfully.');
    }

    public function closed_index()
    {
        return view('hazard-rpt.closed_index');
    }

    public function data()
    {
        $roles = User::find(auth()->user()->id)->getRoleNames()->toArray();

        if (in_array('superadmin', $roles) || in_array('admin_ho', $roles)) {
            $hazards = HazardReport::where('status', 'pending')->orderBy('created_at', 'desc')
                ->get();
        } else {
            $hazards = HazardReport::where('status', 'pending')
                ->where('project_code', auth()->user()->project)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return datatables()->of($hazards)
            ->editColumn('created_at', function ($hazard) {
                // 8 hours added because of timezone
                return $hazard->created_at->addHours(8)->format('d M Y - H:i:s');
            })
            ->editColumn('updated_at', function ($hazard) {
                return $hazard->updated_at->addHours(8)->format('d M Y - H:i:s');
            })
            ->editColumn('to_department_id', function ($hazard) {
                return $hazard->department->department_name;
            })
            ->editColumn('description', function ($hazard) {
                return '<small>' . $hazard->description . '</small>';
            })
            ->addColumn('days', function ($hazard) {
                return $hazard->created_at->addHours(8)->diffInDays(Carbon::now()->addHours(8));
            })
            ->addColumn('action', 'hazard-rpt.action')
            ->addIndexColumn()
            ->rawColumns(['action', 'description'])
            ->toJson();
    }

    public function response_data($id)
    {
        $responses = app(HazardResponseController::class)->get_data($id);


        return datatables()->of($responses)
            ->editColumn('created_at', function ($response) {
                // 8 hours added because of timezone
                return $response->created_at->addHours(8)->format('d-m-Y - H:i:s');
            })
            ->editColumn('comment_by', function ($response) {
                return $response->employee->name;
            })
            ->editColumn('comment', function ($response) {
                return '<small>' . $response->comment . '</small>';
            })
            ->editColumn('attachment', function ($response) {
                if ($response->filename) {
                    return '<a href="' . asset('document_upload/' . $response->filename) . '" target="_blank" class="btn btn-xs btn-info"> view</a>';
                } else {
                    return ' - ';
                }
            })
            ->addColumn('action', 'hazard-rpt.response_action')
            ->addIndexColumn()
            ->rawColumns(['action', 'comment', 'attachment'])
            ->toJson();
        // ->make(true);
    }

    public function closed_data()
    {
        $roles = User::find(auth()->user()->id)->getRoleNames()->toArray();

        if (in_array('superadmin', $roles) || in_array('admin_ho', $roles)) {
            $hazards = HazardReport::where('status', 'closed')->orderBy('created_at', 'desc')
                ->get();
        } else {
            $hazards = HazardReport::where('status', 'closed')
                ->where('project_code', auth()->user()->project)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return datatables()->of($hazards)
            ->editColumn('created_at', function ($hazard) {
                // 8 hours added because of timezone
                return $hazard->created_at->addHours(8)->format('d M Y - H:i:s');
            })
            ->editColumn('updated_at', function ($hazard) {
                return $hazard->updated_at->addHours(8)->format('d M Y - H:i:s');
            })
            ->editColumn('to_department_id', function ($hazard) {
                return $hazard->department->department_name;
            })
            ->editColumn('description', function ($hazard) {
                return '<small>' . $hazard->description . '</small>';
            })
            ->addColumn('duration', function ($hazard) {
                if ($hazard->created_at && $hazard->closed_date) {
                    $end_date = Carbon::createFromFormat('Y-m-d H:s:i', $hazard->closed_date);
                    $start_date = Carbon::createFromFormat('Y-m-d H:s:i', $hazard->created_at);
                    $days = $start_date->diffInDays($end_date);
                    $hours = $start_date->copy()->addDays($days)->diffInHours($end_date);
                    $minutes = $start_date->copy()->addDays($days)->addHours($hours)->diffInMinutes($end_date);
                    return $days . 'd ' . $hours . 'h ' . $minutes . 'm';
                } else {
                    return '-';
                }
            })
            ->addColumn('action', 'hazard-rpt.closed_action')
            ->addIndexColumn()
            ->rawColumns(['action', 'description'])
            ->toJson();
    }

    public function export_to_excel()
    {
        return Excel::download(new HazardReportExport, 'hazard_report.xlsx');
    }

    /*
    public function export()
    {
        $roles = User::find(auth()->user()->id)->getRoleNames()->toArray();

        if (in_array('superadmin', $roles) || in_array('admin_ho', $roles)) {
            $hazards = HazardReport::where('status', 'pending')->orderBy('created_at', 'desc')
                ->get();
        } else {
            $hazards = HazardReport::where('status', 'pending')
                ->where('project_code', auth()->user()->project)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $data = [];
        foreach ($hazards as $hazard) {
            $data[] = [
                'Date' => $hazard->created_at->addHours(8)->format('d M Y - H:i:s'),
                'Project' => $hazard->project->project_name,
                'Department' => $hazard->department->department_name,
                'Danger Type' => $hazard->danger_type->danger_type,
                'Description' => $hazard->description,
                'Days' => $hazard->created_at->addHours(8)->diffInDays(Carbon::now()->addHours(8)),
            ];
        }

        return Excel::create('hazard_report', function ($excel) use ($data) {
            $excel->sheet('hazard_report', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }
    */
}
