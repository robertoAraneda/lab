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
            ->with('createdUser')
            ->with('updatedUser')
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

        $timeReception = $this->show($timeReception->id);

        return response()->json([
            'timeReception' => $timeReception
        ], 200);
    }

    public function show($id)
    {
        return TimeReception::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $timeReception = TimeReception::whereId($id)->first();
        $timeReception->description = $request->description;
        $timeReception->state_id = $request->state_id;
        $timeReception->updated_user_id = auth()->id();

        $timeReception->save();

        $timeReception = $this->show($timeReception->id);

        return response()->json([
            'timeReception' => $timeReception
        ], 200);
    }

    public function destroy($id)
    {
        $timeReception = TimeReception::whereId($id)->first();
        $timeReception->delete();

        return response()->json([
            'timeReception' => $timeReception
        ], 200);
    }
}
