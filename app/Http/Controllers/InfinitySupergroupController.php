<?php

namespace App\Http\Controllers;

use App\InfinitySupergroup;
use App\State;
use App\User;
use Illuminate\Http\Request;

class InfinitySupergroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinitySupergroup');
    }

    public function index()
    {
        $infinitySupergroups = InfinitySupergroup::orderBy('id')
            ->with('infinityGroups')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'infinitySupergroups' => $infinitySupergroups
        ], 200);
    }

    public function store(
        InfinitySupergroup $infinitySupergroup,
        Request $request)
    {
        $infinitySupergroup->description = $request->description;
        $infinitySupergroup->state_id = $request->state_id;
        $infinitySupergroup->created_user_id = auth()->id();
        $infinitySupergroup->save();

        $infinitySupergroup = $this->show($infinitySupergroup->id);

        return response()->json([
            'infinitySupergroup' => $infinitySupergroup
        ], 200);
    }

    public function show($id)
    {
       return InfinitySupergroup::whereId($id)
            ->with('infinityGroups', 'createdUser', 'updatedUser', 'state')
            ->first();
    }

    public function update(
        Request $request, $id)
    {
        $infinitySupergroup = InfinitySupergroup::whereId($id)->first();
        $infinitySupergroup->description = $request->description;
        $infinitySupergroup->state_id = $request->state_id;
        $infinitySupergroup->save();

        $infinitySupergroup = $this->show($infinitySupergroup->id);

        return response()->json([
            'infinitySupergroup' => $infinitySupergroup
        ], 200);
    }

    public function destroy($id)
    {
        $infinitySupergroup = InfinitySupergroup::whereId($id)->first();
        $infinitySupergroup->delete();

        return response()->json([
            'infinitySupergroup' => $infinitySupergroup
        ], 200);

    }


}
