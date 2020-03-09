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
            ->with('infinityTypeTube.infinitySample',
                'infinityTypeTube.label')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('state')
            ->get();

        return response()->json([
            'infinityTests' => $infinityTests
        ], 200);
    }

    public function store(
        InfinityTest $infinityTest,
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

        $infinityTest = $this->show($infinityTest->id);

        return response()->json([
            'infinityTest' => $infinityTest
        ], 200);
    }

    public function show($id)
    {
        return InfinityTest::whereId($id)
            ->with('infinityTypeTube.infinitySample',
                'infinityTypeTube.label')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('state')
            ->first();
    }

    public function update(
        Request $request, $id)
    {
        $infinityTest = InfinityTest::whereId($id)->first();
        $infinityTest->abbreviation = $request->abbreviation;
        $infinityTest->description = $request->description;
        $infinityTest->code = $request->code;
        $infinityTest->created_infinity_at = $request->created_infinity_at;
        $infinityTest->infinity_type_tube_id = $request->infinity_type_tube_id;
        $infinityTest->state_id = $request->state_id;
        $infinityTest->updated_user_id = auth()->id();
        $infinityTest->save();

        $infinityTest = $this->show($infinityTest->id);

        return response()->json([
            'infinityTest' => $infinityTest
        ], 200);
    }

    public function destroy($id)
    {
        $infinityTest = InfinityTest::whereId($id)->first();
        $infinityTest->delete();

        return response()->json([
            'infinityTest' => $infinityTest
        ], 200);
    }
}
