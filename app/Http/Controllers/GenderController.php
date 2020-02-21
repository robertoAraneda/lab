<?php

namespace App\Http\Controllers;

use App\Gender;
use App\User;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.Gender');
    }

    public function index()
    {
        $genders = Gender::orderBy('id')
            ->get()
            ->map(function ($gender) {
                $stateController = new StateController();

                $gender->state_id = $stateController->show($gender->state_id);
                $gender->created_user_id = User::find($gender->created_user_id);
                $gender->updated_user_id = User::find($gender->updated_user_id);
                return $gender;

            });

        return response()->json([
            'genders' => $genders
        ], 200);
    }

    public function store(
        Gender $gender,
        StateController $stateController,
        Request $request)
    {
        $gender->description = $request->description;
        $gender->state_id = $request->state_id;
        $gender->created_user_id = auth()->id();
        $gender->save();

        $gender->state_id = $stateController->show($gender->state_id);
        $gender->created_user_id = User::find($gender->created_user_id);

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
        StateController $stateController,
        Request $request, $id)
    {
        $gender = Gender::find($id);
        $gender->description = $request->description;
        $gender->state_id = $request->state_id;
        $gender->updated_user_id = auth()->id();

        $gender->save();

        $gender->state_id = $stateController->show($gender->state_id);

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
