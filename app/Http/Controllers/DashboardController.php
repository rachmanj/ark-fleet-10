<?php

namespace App\Http\Controllers;

use App\Models\HazardReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function test()
    {
        //
    }
}
