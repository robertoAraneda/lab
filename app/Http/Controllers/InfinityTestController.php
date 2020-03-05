<?php

namespace App\Http\Controllers;

use App\InfinityTest;
use App\User;
use Illuminate\Http\Request;

class InfinityTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinityTest');
    }

    public function index()
    {
        $infinityTests = InfinityTest::orderBy('id')
            ->with('created_user_id')
            ->with('updated_user_id')
            ->with('state_id')
            ->get()
            ->map(function ($infinityTest){
                $stateController = new StateController();
                $infinityTypeTubeController = new InfinityTypeTubeController();

                $infinityTest->state_id = $stateController->show($infinityTest->state_id);
                $infinityTest->infinity_type_tube_id = $infinityTypeTubeController->show($infinityTest->infinity_type_tube_id);

                return $infinityTest;
            });

        return $infinityTests;
    }

    public function store(
        InfinityTest $infinityTest,
        StateController $stateController,
        InfinityTypeTubeController $infinityTypeTubeController,
        Request $request)
    {

        $infinityTest->abbreviation = $request->abbreviation;
        $infinityTest->description = $request->description;
        $infinityTest->code = $request->code;
        $infinityTest->created_infinity_at = $request->created_infinity_at;
        $infinityTest->infinity_type_tube_id = $request->infinity_type_tube_id;
        $infinityTest->state_id = $request->state_id;
        $infinityTest->created_user_id = auth()->id();
        $infinityTest->save();

        $infinityTest->state_id = $stateController->show($infinityTest->state_id);
        $infinityTest->infinity_type_tube_id = $infinityTypeTubeController->show($infinityTest->infinity_type_tube_id);
        $infinityTest->created_user_id = User::find($infinityTest->created_user_id);

        return $infinityTest;
    }

    public function show($id)
    {
        $infinityTest = InfinityTest::find($id);

        $stateController = new StateController();
        $infinityTypeTubeController = new InfinityTypeTubeController();

        $infinityTest->state_id = $stateController->show($infinityTest->state_id);
        $infinityTest->infinity_type_tube_id = $infinityTypeTubeController->show($infinityTest->infinity_type_tube_id);
        $infinityTest->created_user_id = User::find($infinityTest->created_user_id);

        return $infinityTest;

    }

    public function update(
        StateController $stateController,
        InfinityTypeTubeController $infinityTypeTubeController,
        Request $request, $id)
    {
        $infinityTest = InfinityTest::find($id);
        $infinityTest->abbreviation = $request->abbreviation;
        $infinityTest->description = $request->description;
        $infinityTest->code = $request->code;
        $infinityTest->created_infinity_at = $request->created_infinity_at;
        $infinityTest->infinity_type_tube_id = $request->infinity_type_tube_id;
        $infinityTest->state_id = $request->state_id;
        $infinityTest->updated_user_id = auth()->id();
        $infinityTest->save();

        $infinityTest->state_id = $stateController->show($infinityTest->state_id);
        $infinityTest->infinity_type_tube_id = $infinityTypeTubeController->show($infinityTest->infinity_type_tube_id);
        $infinityTest->created_user_id = User::find($infinityTest->created_user_id);

        return $infinityTest;
    }

    public function destroy($id)
    {
        $infinityTest = InfinityTest::find($id);
        $infinityTest->delete();

        return $infinityTest;
    }
}
