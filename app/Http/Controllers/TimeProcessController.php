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
            ->get()
            ->map(function ($timeProcess) {
                $stateController = new StateController();

                $timeProcess->state_id = $stateController->show($timeProcess->state_id);
                $timeProcess->created_user_id = User::find($timeProcess->created_user_id);
                $timeProcess->updated_user_id = User::find($timeProcess->updated_user_id);
                return $timeProcess;

            });

        return $timeProcesses;
    }

    public function store(
        TimeProcess $timeProcess,
        StateController $stateController,
        Request $request)
    {
        $timeProcess->description = $request->description;
        $timeProcess->state_id = $request->state_id;
        $timeProcess->created_user_id = auth()->id();
        $timeProcess->save();

        $timeProcess->state_id = $stateController->show($timeProcess->state_id);
        $timeProcess->created_user_id = User::find($timeProcess->created_user_id);


        return $timeProcess;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $timeProcess = TimeProcess::find($id);
        $timeProcess->state_id = $stateController->show($timeProcess->state_id);

        return $timeProcess;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $timeProcess = TimeProcess::find($id);
        $timeProcess->description = $request->description;
        $timeProcess->state_id = $request->state_id;
        $timeProcess->updated_user_id = auth()->id();

        $timeProcess->save();

        $timeProcess->state_id = $stateController->show($timeProcess->state_id);

        return $timeProcess;
    }

    public function destroy($id)
    {
        $timeProcess = TimeProcess::find($id);
        $timeProcess->delete();

        return $timeProcess;
    }
}
