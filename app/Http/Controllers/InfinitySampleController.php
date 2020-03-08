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
        $infinitySamples = InfinitySample::orderBy('id')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('state')
            ->get();

        return response()->json([
            'infinitySamples' => $infinitySamples
        ], 200);
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

        $infinitySample =$this->show($infinitySample->id);

        return response()->json([
            'infinitySample' => $infinitySample
        ], 200);
    }

    public function show($id)
    {
      return InfinitySample::whereId($id)
          ->with('createdUser')
          ->with('updatedUser')
          ->with('state')
          ->first();

    }

    public function update(
        Request $request, $id)
    {
        $infinitySample = InfinitySample::whereId($id)->first();
        $infinitySample->abbreviature = $request->abbreviature;
        $infinitySample->description = $request->description;
        $infinitySample->state_id = $request->state_id;
        $infinitySample->updated_user_id = auth()->id();
        $infinitySample->save();

        $infinitySample =$this->show($infinitySample->id);

        return response()->json([
            'infinitySample' => $infinitySample
        ], 200);
    }

    public function destroy($id)
    {
        $infinitySample = InfinitySample::whereId($id)->first();
        $infinitySample->delete();

        return response()->json([
            'infinitySample' => $infinitySample
        ], 200);
    }
}
