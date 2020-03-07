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
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('infinitySample')
            ->with('label')
            ->get();

        return response()->json([
            'infinityTypeTubes' => $infinityTypeTubes
        ], 200);
    }

    public function store(
        InfinityTypeTube $infinityTypeTube,
        Request $request)
    {

        $infinityTypeTube->abbreviation = $request->abbreviation;
        $infinityTypeTube->description = $request->description;
        $infinityTypeTube->state_id = $request->state_id;
        $infinityTypeTube->label_id = $request->label_id;
        $infinityTypeTube->infinity_sample_id = $request->infinity_sample_id;
        $infinityTypeTube->created_user_id = auth()->id();
        $infinityTypeTube->save();

        $infinityTypeTube = $this->show($infinityTypeTube->id);

        return response()->json([
            'infinityTypeTube' => $infinityTypeTube
        ], 200);

    }

    public function show(
        $id)
    {
        return InfinityTypeTube::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('infinitySample')
            ->with('label')
            ->first();
    }

    public function update(
        Request $request, $id)
    {
        $infinityTypeTube = InfinityTypeTube::whereId($id)->first();
        $infinityTypeTube->abbreviation = $request->abbreviation;
        $infinityTypeTube->description = $request->description;
        $infinityTypeTube->state_id = $request->state_id;
        $infinityTypeTube->label_id = $request->label_id;
        $infinityTypeTube->infinity_sample_id = $request->infinity_sample_id;
        $infinityTypeTube->updated_user_id = auth()->id();
        $infinityTypeTube->save();

        $infinityTypeTube = $this->show($infinityTypeTube->id);

        return response()->json([
            'infinityTypeTube' => $infinityTypeTube
        ], 200);

    }

    public function destroy($id)
    {
        $infinityTypeTube = InfinityTypeTube::find($id);
        $infinityTypeTube->delete();

        return response()->json(['infinityTypeTube' => $infinityTypeTube], 200);
    }
}
