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
            ->where('state_id', 1)
            ->get()
            ->map(function ($analyteTest) {
                $stateController = new StateController();
                $analyteController = new AnalyteController();
                $testController = new TestController();

                $analyteTest->state_id = $stateController->show($analyteTest->state_id);
                $analyteTest->analyte_id = $analyteController->show($analyteTest->analyte_id);
                $analyteTest->test_id = $testController->show($analyteTest->test_id);
                $analyteTest->created_user_id = User::find($analyteTest->created_user_id);
                $analyteTest->updated_user_id = User::find($analyteTest->updated_user_id);

                return $analyteTest;
            });

        return response()->json([
            "analyteTests" => $analyteTests
        ], 200);
    }

    public function store(Request $request)
    {


        $analyte = Analyte::whereId($request->analyte_id)->first();

        $arr =[];

        foreach ($request->tests as $test_id){
                $arr[$test_id] =  ['created_user_id' => Auth::id()];
        }

        $json= $analyte->tests()->sync($arr);

        return response()->json([
            "success" => $json
        ], 200);

    }

    public function show($id)
    {
        $analyteTest = AnalyteTests::whereId($id)->first();

        $stateController = new StateController();
        $analyteController = new AnalyteController();
        $testController = new TestController();

        $analyteTest['state_id'] = $stateController->show($analyteTest['state_id']);
        $analyteTest->analyte_id = $analyteController->show($analyteTest->analyte_id);
        $analyteTest['test_id']= $testController->show($analyteTest['test_id']);

        return $analyteTest;
    }

    public function update(Request $request, $id)
    {
        $analyte = Analyte::whereId($id)->first();

        $arr =[];

        foreach ($request->tests as $test_id){
            $arr[$test_id] =  ['updated_user_id' => Auth::id(), 'created_user_id' => Auth::id()];
        }

        $json= $analyte->tests()->sync($arr);

        return response()->json([
            "success" => $json
        ], 200);
    }

    public function destroy($id)
    {
        $analyte = Analyte::whereId($id)->first();

        $json= $analyte->tests()->sync([]);

        return response()->json([
            "success" => $json
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
