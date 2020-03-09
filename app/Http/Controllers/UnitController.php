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
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'units' => $units
        ], 200);
    }

    public function store(
        Unit $unit,
        Request $request
    )
    {
        $unit->description = $request->description;
        $unit->state_id = $request->state_id;
        $unit->created_user_id = auth()->id();
        $unit->save();

        $unit = $this->show($unit->id);

        return response()->json([
            'unit' => $unit
        ], 200);
    }

    public function show($id)
    {
        return Unit::whereId($id)
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
        $unit = Unit::whereId($id)->first();
        $unit->description = $request->description;
        $unit->state_id = $request->state_id;
        $unit->updated_user_id = auth()->id();

        $unit->save();

        $unit = $this->show($unit->id);

        return response()->json([
            'unit' => $unit
        ], 200);
    }

    public function destroy($id)
    {
        $unit = Unit::whereId($id)->first();
        $unit->delete();

        return response()->json([
            'unit' => $unit
        ], 200);
    }
}
