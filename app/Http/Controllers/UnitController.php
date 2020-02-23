<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.unit');
    }

    public function index()
    {
        $units = Unit::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'units' => $units
        ], 200);
    }

    public function store(
        Unit $unit,
        Request $request
    ) {
        $unit->description = $request->description;
        $unit->state_id = $request->state_id;
        $unit->created_user_id = auth()->id();
        $unit->save();

        $unit = Unit::whereId($unit->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'unit' => $unit
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $unit = Unit::find($id);
        $unit->state_id = $stateController->show($unit->state_id);

        return $unit;
    }

    public function update(
        Request $request,
        $id
    ) {
        $unit = Unit::find($id);
        $unit->description = $request->description;
        $unit->state_id = $request->state_id;
        $unit->updated_user_id = auth()->id();

        $unit->save();

        $unit = Unit::whereId($unit->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'unit' => $unit
        ], 200);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();

        return response()->json([
            'unit' => $unit
        ], 200);
    }
}
