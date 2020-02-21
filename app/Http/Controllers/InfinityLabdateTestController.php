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
            ->get()
            ->map(function ($infinityLabdateTest) {
                $stateController = new StateController();

                $infinityLabdateTest->state_id = $stateController->show($infinityLabdateTest->state_id);
                $infinityLabdateTest->created_user_id = User::find($infinityLabdateTest->created_user_id);
                $infinityLabdateTest->updated_user_id = User::find($infinityLabdateTest->updated_user_id);
                return $infinityLabdateTest;

            });

        return $infinityLabdateTests;
    }

    public function store(
        InfinityLabdateTest $infinityLabdateTest,
        StateController $stateController,
        Request $request)
    {
        $infinityLabdateTest->code = $request->code;
        $infinityLabdateTest->description = $request->description;
        $infinityLabdateTest->state_id = $request->state_id;
        $infinityLabdateTest->created_user_id = auth()->id();
        $infinityLabdateTest->save();

        $infinityLabdateTest->state_id = $stateController->show($infinityLabdateTest->state_id);
        $infinityLabdateTest->created_user_id = User::find($infinityLabdateTest->created_user_id);


        return $infinityLabdateTest;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $infinityLabdateTest = InfinityLabdateTest::find($id);
        $infinityLabdateTest['state_id ']= $stateController->show($infinityLabdateTest['state_id']);

        return $infinityLabdateTest;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $infinityLabdateTest = InfinityLabdateTest::find($id);

        $infinityLabdateTest->code = $request->code;
        $infinityLabdateTest->description = $request->description;
        $infinityLabdateTest->state_id = $request->state_id;
        $infinityLabdateTest->updated_user_id = auth()->id();

        $infinityLabdateTest->save();

        $infinityLabdateTest->state_id = $stateController->show($infinityLabdateTest->state_id);

        return $infinityLabdateTest;
    }

    public function destroy($id)
    {
        $infinityLabdateTest = InfinityLabdateTest::find($id);
        $infinityLabdateTest->delete();

        return $infinityLabdateTest;
    }
}
