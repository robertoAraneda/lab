<?php

namespace App\Http\Controllers;

use App\Test;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.test');
    }

    public function index()
    {
        $tests = Test::orderBy('id') //->where('state_id', 1)
            ->get()
            ->map(function ($test) {
            $stateController = new StateController();
            $infinityController = new InfinityTestController();
            $loincController = new LoincController();
            $methodController = new MethodController();
            $unitController = new UnitController();

            $test->state_id = $stateController->show($test->state_id);
            $test->infinity_test_id = $infinityController->show($test->infinity_test_id);
            $test->loinc_id = $loincController->show($test->loinc_id);
            $test->method_id = $methodController->show($test->method_id);
            $test->unit_id = $unitController->show($test->unit_id);
            $test->created_user_id = User::find($test->created_user_id);
            $test->updated_user_id = User::find($test->updated_user_id);

            return $test;
        });
        return response()->json([
            "tests" => $tests
        ], 200);

    }

    public function store(
        InfinityTestController $infinityTestController,
        LoincController $loincController,
        MethodController $methodController,
        UnitController $unitController,
        StateController $stateController,
        Request $request)
    {
        $request['created_user_id'] = Auth::id();
        $test = Test::create($request->only(['description',
            'infinity_test_id',
            'loinc_id',
            'method_id',
            'unit_id',
            'state_id',
            'created_user_id']));

        $test->state_id = $stateController->show($test->state_id);
        $test->infinity_test_id = $infinityTestController->show($test->infinity_test_id);
        $test->loinc_id = $loincController->show($test->loinc_id);
        $test->method_id = $methodController->show($test->method_id);
        $test->unit_id = $unitController->show($test->unit_id);

        return response()->json([
            'test' => $test
        ], 200);
    }

    public function show($id)
    {
        $test = Test::whereId($id)->first();

        $stateController = new StateController();
        $infinityTestController = new InfinityTestController();
        $loincController = new LoincController();
        $methodController = new MethodController();
        $unitController = new UnitController();

        $test->state_id = $stateController->show($test->state_id);
        $test->infinity_test_id = $infinityTestController->show($test->infinity_test_id);
        $test->loinc_id = $loincController->show($test->loinc_id);
        $test->method_id = $methodController->show($test->method_id);
        $test->unit_id = $unitController->show($test->unit_id);


        return $test;

    }

    public function update(
        InfinityTestController $infinityTestController,
        LoincController $loincController,
        MethodController $methodController,
        UnitController $unitController,
        StateController $stateController,
        Request $request, $id)
    {
        $test = Test::whereId($id)->first();
        $test->description = $request->description;
        $test->infinity_test_id = $request->infinity_test_id;
        $test->loinc_id = $request->loinc_id;
        $test->method_id = $request->method_id;
        $test->unit_id = $request->unit_id;
        $test->state_id = $request-> state_id;
        $test->updated_user_id = Auth::id();
        $test->save();

        $test->infinity_test_id = $infinityTestController->show($test->infinity_test_id);
        $test->loinc_id = $loincController->show($test->loinc_id);
        $test->method_id = $methodController->show($test->method_id);
        $test->unit_id = $unitController->show($test->unit_id);
        $test->state_id = $stateController->show($test->state_id);

        return $test;
    }

    public function destroy($id)
    {
        $test = Test::whereId($id)->first();

        $test->delete();

        return $test;
    }
}
