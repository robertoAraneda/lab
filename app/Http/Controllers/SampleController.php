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

    public function page()
    {

        return view('admin.sample');
    }

    public function index()
    {
        $samples = Sample::orderBy('id')->with('state')->get();

        return response()->json([
            'samples' => $samples
        ]);
    }

    public function store(Request $request)
    {

        $sample = new Sample();
        $sample->description = $request->description;
        $sample->state_id = $request->state_id;
        $sample->created_user_id = auth()->id();

        $sample->save();

        $sample = Sample::whereId($sample->id)
            ->with('state')
            ->first();

        return response()->json([
            'sample' => $sample
        ]);
    }


    public function show($id)
    {
        $stateController = new StateController();
        $sample = Sample::find($id);
        $sample->state_id = $stateController->show($sample->state_id);

        return $sample;
    }

    public function update(Request $request, $id)
    {
        $sample = Sample::find($id);
        $sample->description = $request->description;
        $sample->state_id = $request->state_id;
        $sample->updated_user_id = auth()->id();
        $sample->save();

        $sample = Sample::whereId($sample->id)
            ->with('state')
            ->first();

        return response()->json([
            'sample' => $sample
        ]);
    }

    public function destroy($id)
    {
        $sample = Sample::find($id);
        $sample->delete();

        return response()->json([
            'sample' => $sample
        ]);
    }
}
