<?php

namespace App\Http\Controllers;

use App\Models\ProjectInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectInfoController extends Controller
{

    public function getInfos()
    {
        $projectInfos = DB::connection('mysqlParams')->table('projects')->where('id', 1)->get();

        return response()->json($projectInfos[0]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectInfos = DB::connection('mysqlParams')->select("select * from projects where id='1';");

        return view('dashboard', ['projectInfos' => $projectInfos[0]]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectInfo $projectInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectInfo $projectInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectInfo $projectInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectInfo $projectInfo)
    {
        //
    }
}
