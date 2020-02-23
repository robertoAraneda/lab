<?php

namespace App\Http\Controllers;

use App\Available;
use Illuminate\Http\Request;

class AvailableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.available');
    }

    public function index()
    {
        $availables = Available::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();


        return response()->json([
            'availables' => $availables
        ], 200);
    }

    public function store(
        Available $available,
        Request $request
    ) {
        $available->description = $request->description;
        $available->state_id = $request->state_id;
        $available->created_user_id = auth()->id();
        $available->save();

        $available = Available::whereId($available->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();


        return response()->json([
            'available' => $available
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $available = Available::find($id);
        $available['state_id'] = $stateController->show($available['state_id']);

        return $available;
    }

    public function update(
        Request $request,
        $id
    ) {
        $available = Available::find($id);
        $available->description = $request->description;
        $available->state_id = $request->state_id;
        $available->updated_user_id = auth()->id();

        $available->save();
        $available = Available::whereId($available->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();


        return response()->json([
            'available' => $available
        ], 200);
    }

    public function destroy($id)
    {
        $available = Available::find($id);
        $available->delete();

        return response()->json([
            'available' => $available
        ], 200);
    }
}
