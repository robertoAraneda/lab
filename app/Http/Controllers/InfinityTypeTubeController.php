<?php

namespace App\Http\Controllers;

use App\InfinityTypeTube;
use App\Label;
use App\User;
use Illuminate\Http\Request;

class InfinityTypeTubeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.infinityTypeTube');
    }

    public function index()
    {
        $infinityTypeTubes = InfinityTypeTube::orderBy('id')
            ->get()
            ->map(function ($infinityTypeTube) {
                $stateController = new StateController();
                $infinitySampleController = new InfinitySampleController();
                $labelController = new LabelController();


                $infinityTypeTube->state_id = $stateController->show($infinityTypeTube->state_id);
                $infinityTypeTube->state_id->created_user_id = User::find($infinityTypeTube->state_id->created_user_id);
                $infinityTypeTube->infinity_sample_id = $infinitySampleController->show($infinityTypeTube->infinity_sample_id);
                $infinityTypeTube->label_id = $labelController->show($infinityTypeTube->label_id);

                return $infinityTypeTube;
            });

        return $infinityTypeTubes;
    }

    public function store(
        InfinityTypeTube $infinityTypeTube,
        StateController $stateController,
        InfinitySampleController $infinitySampleController,
        LabelController $labelController,
        Request $request)
    {

        $infinityTypeTube->abbreviation = $request->abbreviation;
        $infinityTypeTube->description = $request->description;
        $infinityTypeTube->state_id = $request->state_id;
        $infinityTypeTube->label_id = $request->label_id;
        $infinityTypeTube->infinity_sample_id = $request->infinity_sample_id;
        $infinityTypeTube->created_user_id = auth()->id();
        $infinityTypeTube->save();

        $infinityTypeTube->state_id = $stateController->show($infinityTypeTube->state_id);
        $infinityTypeTube->infinity_sample_id = $infinitySampleController->show($infinityTypeTube->infinity_sample_id);
        $infinityTypeTube->label_id = $labelController->show($infinityTypeTube->label_id);


        return $infinityTypeTube;
    }

    public function show(
        $id)
    {
        $stateController = new StateController();
        $infinitySampleController = new InfinitySampleController();
        $infinityLabelController = new LabelController();

        $infinityTypeTube = InfinityTypeTube::find($id);
        $infinityTypeTube->state_id = $stateController->show($infinityTypeTube->state_id);
        $infinityTypeTube->infinity_sample_id = $infinitySampleController->show($infinityTypeTube->infinity_sample_id);
        $infinityTypeTube->label_id = $infinityLabelController->show($infinityTypeTube->label_id);

        return $infinityTypeTube;


    }

    public function update(
        StateController $stateController,
        InfinitySampleController $infinitySampleController,
        LabelController $labelController,
        Request $request, $id)
    {
        $infinityTypeTube = InfinityTypeTube::find($id);
        $infinityTypeTube->abbreviation = $request->abbreviation;
        $infinityTypeTube->description = $request->description;
        $infinityTypeTube->state_id = $request->state_id;
        $infinityTypeTube->label_id = $request->label_id;
        $infinityTypeTube->infinity_sample_id = $request->infinity_sample_id;
        $infinityTypeTube->updated_user_id = auth()->id();
        $infinityTypeTube->save();

        $infinityTypeTube->state_id = $stateController->show($infinityTypeTube->state_id);
        $infinityTypeTube->infinity_sample_id = $infinitySampleController->show($infinityTypeTube->infinity_sample_id);
        $infinityTypeTube->label_id = $labelController->show($infinityTypeTube->label_id);

        return $infinityTypeTube;

    }

    public function destroy($id)
    {
        $infinityTypeTube = InfinityTypeTube::find($id);
        $infinityTypeTube->delete();
    }
}
