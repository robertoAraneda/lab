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
            ->with('created_user')
            ->with('updated_user')
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

        $mainAnalyte = MainAnalyte::whereId($mainAnalyte->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();


        return response()->json([
            'mainAnalyte' => $mainAnalyte
        ], 200);
    }

    public function show(
        StateController $stateController,
        $id
    ) {
        $mainAnalyte = MainAnalyte::find($id);
        $mainAnalyte['state_id'] = $stateController->show($mainAnalyte->state_id);

        return $mainAnalyte;
    }

    public function update(
        Request $request,
        $id
    ) {
        $mainAnalyte = MainAnalyte::find($id);
        $mainAnalyte->description = $request->description;
        $mainAnalyte->state_id = $request->state_id;
        $mainAnalyte->updated_user_id = auth()->id();

        $mainAnalyte->save();

        $mainAnalyte = MainAnalyte::whereId($mainAnalyte->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();


        return response()->json([
            'mainAnalyte' => $mainAnalyte
        ], 200);
    }

    public function destroy($id)
    {
        $mainAnalyte = MainAnalyte::find($id);
        $mainAnalyte->delete();

        return response()->json([
            'mainAnalyte' => $mainAnalyte
        ], 200);
    }
}
