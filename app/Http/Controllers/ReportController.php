<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\CreateReport;
use App\Jobs\SaveReport;
use Illuminate\Support\Facades\Bus;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        $time = date('d-m-Y_H-i-s');
        $filename = "reporte_{$time}.xlsx";
        $users = User::whereBetween('birth_date', [$request->start, $request->end])->get();

        Bus::chain([
            new CreateReport($users, $filename),
            new SaveReport($request->title, $filename)
        ])->dispatch();

        return response([
            'message' => 'Reporte enviado'
        ], 201);
    }

}
