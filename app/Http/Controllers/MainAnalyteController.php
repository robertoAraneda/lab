<?php

namespace App\Http\Controllers;

use App\MainAnalyte;
use Illuminate\Http\Request;

class MainAnalyteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.mainAnalyte');
    }

    public function index()
    {
        $mainAnalytes = MainAnalyte::orderBy('id')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'mainAnalytes' => $mainAnalytes
        ], 200);
    }

    public function store(
        MainAnalyte $mainAnalyte,
        Request $request
    ) {
        $mainAnalyte->description = $request->description;
        $mainAnalyte->state_id = $request->state_id;
        $mainAnalyte->created_user_id = auth()->id();

        $mainAnalyte->save();

        $mainAnalyte = $this->show($mainAnalyte->id);

        return response()->json([
            'mainAnalyte' => $mainAnalyte
        ], 200);
    }

    public function show(
        $id
    ) {
       return MainAnalyte::whereId($id)
           ->with('state')
           ->with('createdUser')
           ->with('updatedUser')
           ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $mainAnalyte = MainAnalyte::whereId($id)->first();
        $mainAnalyte->description = $request->description;
        $mainAnalyte->state_id = $request->state_id;
        $mainAnalyte->updated_user_id = auth()->id();

        $mainAnalyte->save();

        $mainAnalyte = $this->show($mainAnalyte->id);

        return response()->json([
            'mainAnalyte' => $mainAnalyte
        ], 200);
    }

    public function destroy($id)
    {
        $mainAnalyte = MainAnalyte::whereId($id)->first();
        $mainAnalyte->delete();

        return response()->json([
            'mainAnalyte' => $mainAnalyte
        ], 200);
    }
}
