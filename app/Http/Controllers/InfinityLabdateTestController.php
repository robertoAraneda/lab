<?php

namespace App\Http\Controllers;

use App\InfinityLabdateTest;
use App\User;
use Illuminate\Http\Request;

class InfinityLabdateTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinityLabdate');
    }

    public function index()
    {
        $infinityLabdateTests = InfinityLabdateTest::orderBy('id')
            ->with(['state', 'createdUser', 'updatedUser'])
            ->get();

        return response()->json([
            'infinityLabdateTests' => $infinityLabdateTests
        ], 200);
    }

    public function store(
        InfinityLabdateTest $infinityLabdateTest,
        Request $request)
    {
        $infinityLabdateTest->code = $request->code;
        $infinityLabdateTest->description = $request->description;
        $infinityLabdateTest->state_id = $request->state_id;
        $infinityLabdateTest->created_user_id = auth()->id();
        $infinityLabdateTest->save();

        $infinityLabdateTest = $this->show($infinityLabdateTest->id);

        return response()->json([
            'infinityLabdateTest' => $infinityLabdateTest
        ], 200);
    }

    public function show($id)
    {
        $infinityLabdateTest = InfinityLabdateTest::whereId($id)
            ->with(['state', 'createdUser', 'updatedUser'])
            ->first();

        return response()->json([
            'infinityLabdateTest' => $infinityLabdateTest
        ], 200);
    }

    public function update(
        Request $request, $id)
    {
        $infinityLabdateTest = InfinityLabdateTest::find($id);

        $infinityLabdateTest->code = $request->code;
        $infinityLabdateTest->description = $request->description;
        $infinityLabdateTest->state_id = $request->state_id;
        $infinityLabdateTest->updated_user_id = auth()->id();

        $infinityLabdateTest->save();

        $infinityLabdateTest = $this->show($infinityLabdateTest->id);

        return response()->json([
            'infinityLabdateTest' => $infinityLabdateTest
        ], 200);
    }

    public function destroy($id)
    {
        $infinityLabdateTest = InfinityLabdateTest::find($id);
        $infinityLabdateTest->delete();

        return response()->json([
            'infinityLabdateTest' => $infinityLabdateTest
        ], 200);
    }
}
