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
        $infinitySupergroups = InfinitySupergroup::orderBy('id')->get()
            ->map(function ($infinitySupergroup) {
                $stateController = new StateController();

                $infinitySupergroup->state_id= $stateController->show($infinitySupergroup->state_id);
                $infinitySupergroup->state_id->created_user_id = User::find($infinitySupergroup->state_id->created_user_id);
                return $infinitySupergroup;
            });

        return $infinitySupergroups;
    }

    public function store(
        InfinitySupergroup $infinitySupergroup,
        StateController $stateController,
        Request $request)
    {
        $infinitySupergroup->description = $request->description;
        $infinitySupergroup->state_id = $request->state_id;
        $infinitySupergroup->created_user_id = auth()->id();
        $infinitySupergroup->save();

        $infinitySupergroup->state_id = $stateController->show($infinitySupergroup->state_id);

        return $infinitySupergroup;
    }

    public function show($id)
    {
        $infinitySuperGroup = InfinitySupergroup::whereId($id)
            ->with('infinityGroups', 'createdUser', 'updatedUser', 'state')
            ->first();

        return response()->json([
            'infinitySuperGroup' => $infinitySuperGroup
        ], 200);
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $infinitySupergroup = InfinitySupergroup::find($id);
        $infinitySupergroup->description = $request->description;
        $infinitySupergroup->state_id = $request->state_id;
        $infinitySupergroup->save();
        $infinitySupergroup->state_id = $stateController->show($infinitySupergroup->state_id);

        return $infinitySupergroup;
    }

    public function destroy($id)
    {
        $infinitySupergroup = InfinitySupergroup::find($id);
        $infinitySupergroup->delete();
    }


}
