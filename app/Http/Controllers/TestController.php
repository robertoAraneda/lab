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
        $tests = Test::orderBy('id')
            ->with('referenceRanges')
            ->with('analytes')
            ->with('unit')
            ->with('method')
            ->with('loinc')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('infinityTest')
            ->with('state')
            ->get();

        return response()->json([
            "tests" => $tests
        ], 200);

    }

    public function store(
        Test $test,
        Request $request)
    {
        $test->description = $request->description;
        $test->infinity_test_id = $request->infinity_test_id;
        $test->loinc_id = $request->loinc_id;
        $test->method_id = $request->method_id;
        $test->unit_id = $request->unit_id;
        $test->state_id = $request->state_id;
        $test->created_user_id = auth()->id();

        $test->save();

        $test = $this->show($test->id);

        return response()->json([
            'test' => $test
        ], 200);
    }

    public function show($id)
    {
        return Test::whereId($id)
            ->with('referenceRanges')
            ->with('analytes')
            ->with('unit')
            ->with('method')
            ->with('loinc')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('infinityTest')
            ->with('state')
            ->first();
    }

    public function update(
        Request $request, $id)
    {
        $test = Test::whereId($id)->first();
        $test->description = $request->description;
        $test->infinity_test_id = $request->infinity_test_id;
        $test->loinc_id = $request->loinc_id;
        $test->method_id = $request->method_id;
        $test->unit_id = $request->unit_id;
        $test->state_id = $request->state_id;
        $test->updated_user_id = auth()->id();
        $test->save();

        $test = $this->show($test->id);

        return response()->json([
            'test' => $test
        ], 200);
    }

    public function destroy($id)
    {
        $test = Test::whereId($id)->first();

        $test->delete();

        return response()->json([
            'test' => $test
        ], 200);
    }
}
