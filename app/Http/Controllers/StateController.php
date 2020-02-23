<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.state');
    }


    public function index()
    {
        $states = State::orderBy('description')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'states' => $states
        ], 200);
    }

    public function store(Request $request)
    {
        $state = new State();
        $state->description = $request->description;
        $state->created_user_id = auth()->id();
        $state->save();

        $state = State::whereId($state->id)
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'state' => $state
        ], 200);
    }

    public function show($id)
    {
        $state = State::find($id);
        return $state;
    }

    public function update(Request $request, $id)
    {
        $state = State::find($id);
        $state->description = $request->description;
        $state->updated_user_id = auth()->id();

        $state->save();

        $state = State::whereId($state->id)
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'state' => $state
        ], 200);
    }

    public function destroy($id)
    {
        $state = State::find($id);
        $state->delete();

        return response()->json([
            'state' => $state
        ], 200);
    }
}
