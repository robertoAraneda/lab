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
        $unites = Unit::orderBy('id')
            ->get()
            ->map(function ($unit) {
                $stateController = new StateController();

                $unit->state_id = $stateController->show($unit->state_id);
                $unit->created_user_id = User::find($unit->created_user_id);
                $unit->updated_user_id = User::find($unit->updated_user_id);
                return $unit;

            });

        return $unites;
    }

    public function store(
        Unit $unit,
        StateController $stateController,
        Request $request)
    {
        $unit->description = $request->description;
        $unit->state_id = $request->state_id;
        $unit->created_user_id = auth()->id();
        $unit->save();

        $unit->state_id = $stateController->show($unit->state_id);
        $unit->created_user_id = User::find($unit->created_user_id);


        return $unit;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $unit = Unit::find($id);
        $unit->state_id = $stateController->show($unit->state_id);

        return $unit;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $unit = Unit::find($id);
        $unit->description = $request->description;
        $unit->state_id = $request->state_id;
        $unit->updated_user_id = auth()->id();

        $unit->save();

        $unit->state_id = $stateController->show($unit->state_id);

        return $unit;
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();

        return $unit;
    }
}
