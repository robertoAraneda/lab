<?php

namespace App\Http\Controllers;

use App\TimeProcess;
use App\User;
use Illuminate\Http\Request;

class TimeProcessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.timeProcess');
    }

    public function index()
    {
        $timeProcesses = TimeProcess::orderBy('id')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'timeProcesses' => $timeProcesses
        ], 200);
    }

    public function store(
        TimeProcess $timeProcess,
        Request $request
    )
    {
        $timeProcess->description = $request->description;
        $timeProcess->state_id = $request->state_id;
        $timeProcess->created_user_id = auth()->id();

        $timeProcess->save();

        $timeProcess = $this->show($timeProcess->id);

        return response()->json([
            'timeProcess' => $timeProcess
        ], 200);
    }

    public function show($id)
    {
        return TimeProcess::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id
    )
    {
        $timeProcess = TimeProcess::whereId($id)->first();
        $timeProcess->description = $request->description;
        $timeProcess->state_id = $request->state_id;
        $timeProcess->updated_user_id = auth()->id();

        $timeProcess->save();

        $timeProcess = $this->show($timeProcess->id);

        return response()->json([
            'timeProcess' => $timeProcess
        ], 200);
    }

    public function destroy($id)
    {
        $timeProcess = TimeProcess::whereId($id)->first();
        $timeProcess->delete();

        return response()->json([
            'timeProcess' => $timeProcess
        ], 200);
    }
}
