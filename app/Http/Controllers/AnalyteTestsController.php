<?php

namespace App\Http\Controllers;

use App\Analyte;
use App\AnalyteTests;
use App\Test;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyteTestsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.relAnalyteTest');
    }


    public function index()
    {
        $analyteTests = AnalyteTests::orderBy('id')
            ->with('state')
            ->with('analyte')
            ->with('test')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            "analyteTests" => $analyteTests
        ], 200);
    }

    public function store(Request $request)
    {
        $analyte = Analyte::whereId($request->analyte_id)->first();

        $arr =[];

        foreach ($request->tests as $test_id){
                $arr[$test_id] =  ['created_user_id' => Auth::id(),
                'order' => count($arr) + 1];
        }

        $analyte->tests()->sync($arr);

        return response()->json([
            "analyte" => $analyte->tests()->orderBy('order')->get()
        ], 200);

    }

    public function show($id)
    {
        $analyteTest = AnalyteTests::whereId($id)->first();

        return $analyteTest->tests()->get();
    }

    public function update(Request $request, $id)
    {
        $analyte = Analyte::whereId($id)->first();

        $arr =[];

        foreach ($request->tests as $test_id){
            $arr[$test_id] =  ['created_user_id' => Auth::id(),
            'order' => count($arr) + 1];
        }

        $json= $analyte->tests()->sync($arr);

        return response()->json([
            $analyte->tests()->orderBy('order')->get()
        ], 200);
    }

    public function destroy($id)
    {
        $analyte = Analyte::whereId($id)->first();

        $analyte->tests()->sync([]);

        return response()->json([
            $analyte->tests()->get()
        ], 200);
    }

    public function agregateData()
    {

        $analytes = Analyte::all();
        $json = [];

        foreach ($analytes as $analyte){
            $arr = array(
                'analyte' => $analyte,
                'tests' =>$analyte->tests
            );

            $json[] = $arr;
        }

        return response()->json([
            'json' => $json
        ], 200);
    }
}
