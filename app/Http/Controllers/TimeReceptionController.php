<?php

namespace App\Http\Controllers;

use App\TimeReception;
use Illuminate\Http\Request;

class TimeReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.timeReception');
    }

    public function index()
    {
        $timeReceptions = TimeReception::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'timeReceptions' => $timeReceptions
        ], 200);
    }

    public function store(
        TimeReception $timeReception,
        Request $request
    ) {
        $timeReception->description = $request->description;
        $timeReception->state_id = $request->state_id;
        $timeReception->created_user_id = auth()->id();

        $timeReception->save();

        $timeReception = TimeReception::whereId($timeReception->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'timeReception' => $timeReception
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $timeReception = TimeReception::find($id);
        $timeReception->state_id = $stateController->show($timeReception->state_id);

        return $timeReception;
    }

    public function update(
        Request $request,
        $id
    ) {
        $timeReception = TimeReception::find($id);
        $timeReception->description = $request->description;
        $timeReception->state_id = $request->state_id;
        $timeReception->updated_user_id = auth()->id();

        $timeReception->save();

        $timeReception = TimeReception::whereId($timeReception->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'timeReception' => $timeReception
        ], 200);
    }

    public function destroy($id)
    {
        $timeReception = TimeReception::find($id);
        $timeReception->delete();

        return response()->json([
            'timeReception' => $timeReception
        ], 200);
    }
}
