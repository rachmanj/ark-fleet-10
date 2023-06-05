<?php

namespace App\Http\Controllers;

use App\Models\Logger;
use Illuminate\Http\Request;

class LoggerController extends Controller
{
    public function store($description)
    {
        Logger::create([
            'description' => $description
        ]);

        return null;
    }
}
