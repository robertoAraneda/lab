<?php

namespace App\Http\Controllers;

use App\InfinitySample;
use App\User;
use Illuminate\Http\Request;

class InfinitySampleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinitySample');
    }

    public function index()
    {
        $infinitySamples = InfinitySample::orderBy('id')->get()
            ->map(function ($infinitySample){
                $stateController = new StateController();

                $infinitySample->state_id= $stateController->show($infinitySample->state_id);
                $infinitySample->state_id->created_user_id = User::find($infinitySample->state_id->created_user_id);

                return $infinitySample;
            });

        return $infinitySamples;
    }

    public function store(
        InfinitySample $infinitySample,
        StateController $stateController,
        Request $request)
    {
        $infinitySample->abbreviature = $request->abbreviature;
        $infinitySample->description = $request->description;
        $infinitySample->state_id = $request->state_id;
        $infinitySample->created_user_id = auth()->id();
        $infinitySample->save();

        $infinitySample->state_id = $stateController->show($infinitySample->state_id);

        return $infinitySample;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $infinitySample = InfinitySample::find($id);
        $infinitySample->state_id = $stateController->show($infinitySample->state_id);

        return $infinitySample;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $infinitySample = InfinitySample::find($id);
        $infinitySample->abbreviature = $request->abbreviature;
        $infinitySample->description = $request->description;
        $infinitySample->state_id = $request->state_id;
        $infinitySample->updated_user_id = auth()->id();
        $infinitySample->save();

        $infinitySample->state_id = $stateController->show($infinitySample->state_id);

        return $infinitySample;
    }

    public function destroy($id)
    {
        $infinitySample = InfinitySample::find($id);
        $infinitySample->delete();

        return $infinitySample;
    }
}
