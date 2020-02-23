<?php

namespace App\Http\Controllers;

use App\Gender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.gender');
    }

    public function index()
    {
        $genders = Gender::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();


        return response()->json([
            'genders' => $genders
        ], 200);
    }

    public function store(
        Gender $gender,
        Request $request
    ) {
        $gender->description = $request->description;
        $gender->state_id = $request->state_id;
        $gender->created_user_id = auth()->id();
        $gender->save();

        $gender = Gender::whereId($gender->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'gender' => $gender
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $gender = Gender::find($id);
        $gender->state_id = $stateController->show($gender->state_id);

        return $gender;
    }

    public function update(
        Request $request,
        $id
    ) {
        $gender = Gender::find($id);
        $gender->description = $request->description;
        $gender->state_id = $request->state_id;
        $gender->updated_user_id = auth()->id();

        $gender->save();

        $gender = Gender::whereId($gender->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'gender' => $gender
        ], 200);


        return response()->json([
            'gender' => $gender
        ], 200);
    }

    public function destroy($id)
    {
        $gender = Gender::find($id);
        $gender->delete();

        return response()->json([
            'gender' => $gender
        ], 200);
    }
}
