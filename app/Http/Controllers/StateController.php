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
        $states = State::orderBy('id')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'states' => $states
        ], 200);
    }

    public function store(
        State $state,
        Request $request)
    {
        $state->description = $request->description;
        $state->created_user_id = auth()->id();
        $state->save();

        $state = $this->show($state->id);

        return response()->json([
            'state' => $state
        ], 200);
    }

    public function show($id)
    {
        return State::whereId($id)
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(Request $request, $id)
    {
        $state = State::whereId($id)->first();
        $state->description = $request->description;
        $state->updated_user_id = auth()->id();

        $state->save();

        $state = $this->show($state->id);

        return response()->json([
            'state' => $state
        ], 200);
    }

    public function destroy($id)
    {
        $state = State::whereId($id)->first();
        $state->delete();

        return response()->json([
            'state' => $state
        ], 200);
    }
}
