<?php

namespace App\Http\Controllers;

use App\Analyte;
use App\AnalyteIndication;
use Illuminate\Http\Request;

class AnalyteIndicationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {
        return view('admin.analyteIndication');
    }


    public function index()
    {
        $analyteIndications = AnalyteIndication::orderBy('id')
            ->with('indication')
            ->with('analyte')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return $analyteIndications;
    }


    public function store(Request $request)
    {
        $analyte = Analyte::whereId($request->analyte_id)->first();

        $arr = array();

        foreach ($request->indications as $indication_id){
            $arr[$indication_id] = ['created_user_id' => auth()->id()];
        }

        $success = $analyte->indications()->sync($arr);


        return response()->json([
            'success' => $success,
            'analyte' => $analyte
        ], 200);
    }

    public function show($id)
    {
        $analyte = Analyte::whereId($id)->first();

        return $analyte->indications()->get();
    }

    public function update(Request $request, $id)
    {
        $analyte = Analyte::whereId($id)->first();

        $arr = array();

        foreach ($request->indications as $indication_id){
            $arr[$indication_id] = ['created_user_id' => auth()->id(),
                'updated_user_id' => auth()->id()];
        }

        $success = $analyte->indications()->sync($arr);


        return response()->json([
            'success' => $success,
            'analyte' => $analyte
        ], 200);
    }

    public function destroy($id)
    {
        $analyte = Analyte::whereId($id)->first();

        $success = $analyte->indications()->sync([]);

        return response()->json([
            'success' => $success
        ], 200);
    }
}
