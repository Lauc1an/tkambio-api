<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\CreateReport;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        $users = User::whereBetween('birth_date', [$request->start, $request->end])->get();
        CreateReport::dispatch($users);

        return response([
            'message' => 'Reporte enviado'
        ], 201);
    }

}
