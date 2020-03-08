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
            ->with('createdUser')
            ->with('updatedUser')
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

        $gender = $this->show($gender->id);

        return response()->json([
            'gender' => $gender
        ], 200);
    }

    public function show($id)
    {
        return Gender::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $gender = Gender::whereId($id)->first();
        $gender->description = $request->description;
        $gender->state_id = $request->state_id;
        $gender->updated_user_id = auth()->id();

        $gender->save();

        $gender = $this->show($gender->id);

        return response()->json([
            'gender' => $gender
        ], 200);
    }

    public function destroy($id)
    {
        $gender = Gender::whereId($id)->first();
        $gender->delete();

        return response()->json([
            'gender' => $gender
        ], 200);
    }
}
