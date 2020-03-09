<?php

namespace App\Http\Controllers;

use App\InfinityRelGroupTest;
use App\InfinityGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfinityRelGroupTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinityRelGroupTest');
    }

    public function index()
    {
        $infinityTestGroup = InfinityRelGroupTest::orderBy('id')
            ->with(['infinityTest', 'infinityGroup', 'state', 'createdUser', 'updatedUser'])
            ->get();

        return response()->json([
            'infinityTestGroup' => $infinityTestGroup
        ], 200);

    }

    public function store(Request $request)
    {
        $infinityTestGroup = InfinityGroup::whereId($request->infinity_group_id)->first();

        $arr =[];


        foreach ($request->infinity_test_ids as $infinity_test_id){
            $arr[$infinity_test_id] =  ['created_user_id' => auth()->id()];
        }

        $infinityTestGroup->infinityTests()->sync($arr);

        return response()->json([
            'infinityTestGroup' => $infinityTestGroup->infinityTests()->get()
        ], 200);
    }

    public function show($id)
    {
       $infinityTestGroup = InfinityRelGroupTest::whereId($id)
           ->with(['infinityTest', 'infinityGroup', 'state', 'createdUser', 'updatedUser'])
           ->first();

       return response()->json([
           'infinityTestGroup' => $infinityTestGroup
       ], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
