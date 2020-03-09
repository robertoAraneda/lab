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
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'fonasaTests' => $fonasaTests
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

        $fonasaTest = $this->show($fonasaTest->id);

        return response()->json([
            'fonasaTest' => $fonasaTest
        ], 200);
    }

    public function show($id)
    {
       return FonasaTest::whereId($id)
           ->with('state')
           ->with('createdUser')
           ->with('updatedUser')
           ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $fonasaTest = FonasaTest::whereId($id)->first();
        $fonasaTest->code = $request->code;
        $fonasaTest->description = $request->description;
        $fonasaTest->state_id = $request->state_id;
        $fonasaTest->updated_user_id = auth()->id();

        $fonasaTest->save();

        $fonasaTest = $this->show($fonasaTest->id);

        return response()->json([
            'fonasaTest' => $fonasaTest
        ], 200);
    }

    public function destroy($id)
    {
        $fonasaTest = FonasaTest::whereId($id)->first();
        $fonasaTest->delete();

         return response()->json([
            'fonasaTest' => $fonasaTest
        ], 200);
    }
}
