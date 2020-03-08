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
            ->with('createdUser')
            ->with('updatedUser')
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

        $available = $this->show($available->id);

        return response()->json([
            'available' => $available
        ], 200);
    }

    public function show($id)
    {
        return Available::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $available = Available::whereId($id)->first();
        $available->description = $request->description;
        $available->state_id = $request->state_id;
        $available->updated_user_id = auth()->id();

        $available->save();

        $available = $this->show($available->id);

        return response()->json([
            'available' => $available
        ], 200);
    }

    public function destroy($id)
    {
        $available = Available::whereId($id)->first();
        $available->delete();

        return response()->json([
            'available' => $available
        ], 200);
    }
}
