<?php

namespace App\Http\Controllers;

use App\FonasaTest;
use App\User;
use Illuminate\Http\Request;

class FonasaTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.fonasa');
    }

    public function index()
    {
        $fonasaTests = FonasaTest::orderBy('id')
            ->get()
            ->map(function ($fonasaTest) {
                $stateController = new StateController();

                $fonasaTest->state_id = $stateController->show($fonasaTest->state_id);
                $fonasaTest->created_user_id = User::find($fonasaTest->created_user_id);
                $fonasaTest->updated_user_id = User::find($fonasaTest->updated_user_id);
                return $fonasaTest;

            });

        return $fonasaTests;
    }

    public function store(
        FonasaTest $fonasaTest,
        StateController $stateController,
        Request $request)
    {
        $fonasaTest->code = $request->code;
        $fonasaTest->description = $request->description;
        $fonasaTest->state_id = $request->state_id;
        $fonasaTest->created_user_id = auth()->id();
        $fonasaTest->save();

        $fonasaTest->state_id = $stateController->show($fonasaTest->state_id);
        $fonasaTest->created_user_id = User::find($fonasaTest->created_user_id);


        return $fonasaTest;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $fonasaTest = FonasaTest::find($id);
        $fonasaTest->state_id = $stateController->show($fonasaTest->state_id);

        return $fonasaTest;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $fonasaTest = FonasaTest::find($id);
        $fonasaTest->code = $request->code;
        $fonasaTest->description = $request->description;
        $fonasaTest->state_id = $request->state_id;
        $fonasaTest->updated_user_id = auth()->id();

        $fonasaTest->save();

        $fonasaTest->state_id = $stateController->show($fonasaTest->state_id);

        return $fonasaTest;
    }

    public function destroy($id)
    {
        $fonasaTest = FonasaTest::find($id);
        $fonasaTest->delete();

        return $fonasaTest;
    }
}
