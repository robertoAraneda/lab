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
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();


        return response()->json([
            'fonasas' => $fonasaTests
        ], 200);
    }
    public function store(
        FonasaTest $fonasaTest,
        Request $request
    ) {
        $fonasaTest->code = $request->code;
        $fonasaTest->description = $request->description;
        $fonasaTest->state_id = $request->state_id;
        $fonasaTest->created_user_id = auth()->id();
        $fonasaTest->save();

        $fonasaTest = FonasaTest::whereId($fonasaTest->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'fonasa' => $fonasaTest
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $fonasaTest = FonasaTest::find($id);
        $fonasaTest->state_id = $stateController->show($fonasaTest->state_id);

        return $fonasaTest;
    }

    public function update(
        Request $request,
        $id
    ) {
        $fonasaTest = FonasaTest::find($id);
        $fonasaTest->code = $request->code;
        $fonasaTest->description = $request->description;
        $fonasaTest->state_id = $request->state_id;
        $fonasaTest->updated_user_id = auth()->id();

        $fonasaTest->save();

        $fonasaTest = FonasaTest::whereId($fonasaTest->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'fonasa' => $fonasaTest
        ], 200);
    }

    public function destroy($id)
    {
        $fonasaTest = FonasaTest::find($id);
        $fonasaTest->delete();

         return response()->json([
            'fonasa' => $fonasaTest
        ], 200);
    }
}
