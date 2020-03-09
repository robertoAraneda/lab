<?php

namespace App\Http\Controllers;

use App\AgeUnit;
use App\User;
use Illuminate\Http\Request;

class AgeUnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.ageUnit');
    }

    public function index()
    {
        $ageUnits = AgeUnit::orderBy('id')
            ->with(['referenceRanges.test', 'state', 'createdUser', 'updatedUser'])
            ->get();

        return response()->json([
            'ageUnits' => $ageUnits
        ], 200);
    }

    public function store(
        AgeUnit $ageUnit,
        Request $request)
    {
        $ageUnit->description = $request->description;
        $ageUnit->state_id = $request->state_id;
        $ageUnit->created_user_id = auth()->id();
        $ageUnit->save();

        $ageUnit = $this->show($ageUnit->id);

        return response()->json([
            'ageUnit' => $ageUnit
        ], 200);
    }

    public function show($id)
    {
        return AgeUnit::whereId($id)
            ->with(['referenceRanges.test', 'state', 'createdUser', 'updatedUser'])
            ->first();

    }

    public function update(Request $request, $id)
    {
        $ageUnit = AgeUnit::find($id);
        $ageUnit->description = $request->description;
        $ageUnit->state_id = $request->state_id;
        $ageUnit->updated_user_id = auth()->id();

        $ageUnit->save();

        $ageUnit = $this->show($ageUnit->id);

        return response()->json([
            'ageUnit' => $ageUnit
        ], 200);
    }

    public function destroy($id)
    {
        $ageUnit = AgeUnit::find($id);
        $ageUnit->delete();

        return response()->json([
            'ageUnit' => $ageUnit
        ], 200);
    }
}
