<?php

namespace App\Http\Controllers;

use App\Loinc;
use Illuminate\Http\Request;

class LoincCustomController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {

    }

    public function store (
        Loinc $loinc,
        Request $request)
    {

        $loinc = Loinc::where('loinc_num',"$request->loinc_num")->first();

        if($loinc){
            return response()->json([
                'message' => 'Loinc already exists'
            ], 400);
        }

        //validate request
        $request->validate([
            'loinc_num' => 'required',
            'component' => 'required',
            'shortname' => 'required',
            'long_common_name' => 'required',
            'system' => 'required'
        ]);

        $loinc->loinc_num = $request->loinc_num;
        $loinc->component = $request->component;
        $loinc->shortname = $request->shortname;
        $loinc->long_common_name = $request->long_common_name;
        $loinc->system_ = $request->system;

        $loinc->save();

        return response()->json([
            'loinc' => $loinc
        ], 200);
        
    }

    public function show($id)
    {
        $loinc = Loinc::where('loinc_num',"$id")->first();
        return $loinc;
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $loinc = Loinc::where('loinc_num',"$id")->first();

        $loinc->delete();

        return response()->json([
            "message" => "Loinc deleted successfully"
        ], 200);
    }

}
