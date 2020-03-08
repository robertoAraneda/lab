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
        $samples = Sample::orderBy('id')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('state')
            ->get();

        return response()->json([
            'samples' => $samples
        ], 200);
    }

    public function store(Request $request)
    {

        $sample = new Sample();
        $sample->description = $request->description;
        $sample->state_id = $request->state_id;
        $sample->created_user_id = auth()->id();

        $sample->save();

        $sample = $this->show($sample->id);

        return response()->json([
            'sample' => $sample
        ], 200);
    }


    public function show($id)
    {
        return Sample::whereId($id)
            ->with('createdUser')
            ->with('updatedUser')
            ->with('state')
            ->first();
    }

    public function update(Request $request, $id)
    {
        $sample = Sample::whereId($id)->first();
        $sample->description = $request->description;
        $sample->state_id = $request->state_id;
        $sample->updated_user_id = auth()->id();
        $sample->save();

        $sample = $this->show($sample->id);

        return response()->json([
            'sample' => $sample
        ], 200);
    }

    public function destroy($id)
    {
        $sample = Sample::whereId($id)->first();
        $sample->delete();

        return response()->json([
            'sample' => $sample
        ], 200);
    }
}
