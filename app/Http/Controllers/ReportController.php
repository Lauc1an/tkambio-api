<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Jobs\CreateReport;
use App\Jobs\SaveReport;
use Illuminate\Support\Facades\Bus;

class ReportController extends Controller
{
    /**
     * Mostrar todos los reportes
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::all();
    }

    /**
     * Mostrar un reporte específico
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Report::findOrFail($id);
    }

    /**
     * Crear reportes
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
