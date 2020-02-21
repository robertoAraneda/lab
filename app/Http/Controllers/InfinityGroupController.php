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
        $infinityGroups = InfinityGroup::orderBy('code')->get()
            ->map(function ($infinityGroup){

                $stateController = new StateController();
                $infinitySuperGroupController = new InfinitySupergroupController();

                $infinityGroup->state_id = $stateController->show($infinityGroup->state_id);
                $infinityGroup->infinity_supergroup_id = $infinitySuperGroupController->show($infinityGroup->infinity_supergroup_id);

                return $infinityGroup;

            });

        return $infinityGroups;
    }

    public function store(
        InfinityGroup $infinityGroup,
        StateController $stateController,
        InfinitySupergroupController $infinitySupergroupController,
        Request $request)
    {
        $infinityGroup->code = $request->code;
        $infinityGroup->description = $request->description;
        $infinityGroup->infinity_supergroup_id = $request->infinity_supergroup_id;
        $infinityGroup->state_id = $request->state_id;
        $infinityGroup->created_user_id = auth()->id();
        $infinityGroup->save();

        $infinityGroup->state_id = $stateController->show($infinityGroup->state_id);
        $infinityGroup->infinity_supergroup_id = $infinitySupergroupController->show($infinityGroup->infinity_supergroup_id);

        return $infinityGroup;
    }

    public function show($id)
    {
        $stateController = new StateController();
        $infinitySupergroupController = new InfinitySupergroupController();

        $infinityGroup = InfinityGroup::find($id);
        $infinityGroup->state_id = $stateController->show($infinityGroup->state_id);
        $infinityGroup->infinity_supergroup_id = $infinitySupergroupController->show($infinityGroup->infinity_supergroup_id);

        return $infinityGroup;
    }

    public function update(
        StateController $stateController,
        InfinitySupergroupController $infinitySupergroupController,
        Request $request, $id)
    {
        $infinityGroup = InfinityGroup::find($id);
        $infinityGroup->code = $request->code;
        $infinityGroup->description = $request->description;
        $infinityGroup->infinity_supergroup_id = $request->infinity_supergroup_id;
        $infinityGroup->state_id = $request->state_id;
        $infinityGroup->updated_user_id = auth()->id();
        $infinityGroup->save();

        $infinityGroup->state_id = $stateController->show($infinityGroup->state_id);
        $infinityGroup->infinity_supergroup_id = $infinitySupergroupController->show($infinityGroup->infinity_supergroup_id);

        return $infinityGroup;
    }

    public function destroy($id)
    {
        $infinityGroup = InfinityGroup::find($id);
        $infinityGroup->delete();
    }

    public function findBySupergroup($supergroup){

        $sg = InfinityGroup::where('infinity_supergroup_id', "$supergroup")->get();

        return $sg;
    }
}
