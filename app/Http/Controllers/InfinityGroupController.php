<?php

namespace App\Http\Controllers;

use App\InfinityGroup;
use Illuminate\Http\Request;

class InfinityGroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinityGroup');
    }

    public function index()
    {
        $infinityGroups = InfinityGroup::orderBy('id')
            ->with('state')
            ->with('infinitySupergroup')
            ->with('infinityTests')
            ->get();

        return response()->json([
            'infinityGroups' => $infinityGroups
        ], 200);
    }

    public function store(
        InfinityGroup $infinityGroup,
        Request $request)
    {
        $infinityGroup->code = $request->code;
        $infinityGroup->description = $request->description;
        $infinityGroup->infinity_supergroup_id = $request->infinity_supergroup_id;
        $infinityGroup->state_id = $request->state_id;
        $infinityGroup->created_user_id = auth()->id();
        $infinityGroup->save();

        $infinityGroup = $this->show($infinityGroup->id);

        return response()->json([
            'infinityGroup' => $infinityGroup
        ], 200);
    }

    public function show($id)
    {
        return InfinityGroup::whereId($id)
            ->with(['infinityTests.infinityTypeTube',
                'infinityTests.infinityTypeTube.label',
                'infinityTests.infinityTypeTube.infinitySample',
                'infinitySupergroup',
                'state'])
            ->first();
    }

    public function update(
        Request $request, $id)
    {
        $infinityGroup = InfinityGroup::whereId($id)->first();
        $infinityGroup->code = $request->code;
        $infinityGroup->description = $request->description;
        $infinityGroup->infinity_supergroup_id = $request->infinity_supergroup_id;
        $infinityGroup->state_id = $request->state_id;
        $infinityGroup->updated_user_id = auth()->id();
        $infinityGroup->save();

        $infinityGroup = $this->show($infinityGroup->id);

        return response()->json([
            'infinityGroup' => $infinityGroup
        ], 200);
    }

    public function destroy($id)
    {
        $infinityGroup = InfinityGroup::whereId($id)->first();
        $infinityGroup->delete();

        return response()->json([
            'infinityGroup' => $infinityGroup
        ], 200);

    }

    public function findBySupergroup($supergroup)
    {

        $sg = InfinityGroup::where('infinity_supergroup_id', "$supergroup")->get();

        return $sg;
    }
}
