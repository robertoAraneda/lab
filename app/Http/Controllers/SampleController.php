<?php

namespace App\Http\Controllers;

use App\Sample;
use Illuminate\Http\Request;

class SampleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page(){

        return view('admin.sample');
    }

    public function index()
    {
        $samples = Sample::orderBy('id')->with('state_id')->get();

        return $samples;

    }

    public function store(StateController $stateController, Request $request)
    {

        $sample = new Sample();
        $sample->description = $request->description;
        $sample->state_id = $request->state_id;
        $sample->created_user_id = auth()->id();

        $sample->save();

        $sample['state_id'] = $stateController->show($sample->state_id);

        return $sample;

    }


    public function show($id)
    {
         $stateController = new StateController();
        $sample = Sample::find($id);
        $sample->state_id = $stateController->show($sample->state_id);

        return $sample;
    }

    public function update(StateController $stateController, Request $request, $id)
    {
        $sample = Sample::find($id);
        $sample->description = $request->description;
        $sample->state_id = $request->state_id;
        $sample->updated_user_id = auth()->id();
        $sample->save();

        $sample['state_id'] = $stateController->show($sample->state_id);

        return $sample;
    }

    public function destroy($id)
    {
        $sample = Sample::find($id);
        $sample->delete();

        return $sample;
    }
}
