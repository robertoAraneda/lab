<?php

namespace App\Http\Controllers;

use App\TimeReception;
use App\User;
use Illuminate\Http\Request;

class TimeReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.TimeReception');
    }

    public function index()
    {
        $timeReceptions = TimeReception::orderBy('id')
            ->get()
            ->map(function ($timeReception) {
                $stateController = new StateController();

                $timeReception->state_id = $stateController->show($timeReception->state_id);
                $timeReception->created_user_id = User::find($timeReception->created_user_id);
                $timeReception->updated_user_id = User::find($timeReception->updated_user_id);
                return $timeReception;

            });

        return $timeReceptions;
    }

    public function store(
        TimeReception $timeReception,
        StateController $stateController,
        Request $request)
    {
        $timeReception->description = $request->description;
        $timeReception->state_id = $request->state_id;
        $timeReception->created_user_id = auth()->id();
        $timeReception->save();

        $timeReception->state_id = $stateController->show($timeReception->state_id);
        $timeReception->created_user_id = User::find($timeReception->created_user_id);


        return $timeReception;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $timeReception = TimeReception::find($id);
        $timeReception->state_id = $stateController->show($timeReception->state_id);

        return $timeReception;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $timeReception = TimeReception::find($id);
        $timeReception->description = $request->description;
        $timeReception->state_id = $request->state_id;
        $timeReception->updated_user_id = auth()->id();

        $timeReception->save();

        $timeReception->state_id = $stateController->show($timeReception->state_id);

        return $timeReception;
    }

    public function destroy($id)
    {
        $timeReception = TimeReception::find($id);
        $timeReception->delete();

        return $timeReception;
    }
}
