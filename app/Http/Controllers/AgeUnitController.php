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
            ->get()
            ->map(function ($ageUnit) {
                $stateController = new StateController();

                $ageUnit->state_id = $stateController->show($ageUnit->state_id);
                $ageUnit->created_user_id = User::find($ageUnit->created_user_id);
                $ageUnit->updated_user_id = User::find($ageUnit->updated_user_id);
                return $ageUnit;

            });

        return response()->json([
            'ageUnits' => $ageUnits
        ], 200);
    }

    public function store(
        AgeUnit $ageUnit,
        StateController $stateController,
        Request $request)
    {
        $ageUnit->description = $request->description;
        $ageUnit->state_id = $request->state_id;
        $ageUnit->created_user_id = auth()->id();
        $ageUnit->save();

        $ageUnit->state_id = $stateController->show($ageUnit->state_id);
        $ageUnit->created_user_id = User::find($ageUnit->created_user_id);

        return response()->json([
            'ageUnit' => $ageUnit
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $ageUnit = AgeUnit::find($id);
        $ageUnit->state_id = $stateController->show($ageUnit->state_id);

        return $ageUnit;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $ageUnit = AgeUnit::find($id);
        $ageUnit->description = $request->description;
        $ageUnit->state_id = $request->state_id;
        $ageUnit->updated_user_id = auth()->id();

        $ageUnit->save();

        $ageUnit->state_id = $stateController->show($ageUnit->state_id);

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
