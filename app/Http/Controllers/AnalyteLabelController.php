<?php

namespace App\Http\Controllers;

use App\AnalyteLabel;
use App\Analyte;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyteLabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {
        return view('admin.analyteLabel');
    }

    public function index()
    {
        $analyteLabels = AnalyteLabel::orderBy('id')
            ->with('label')
            ->with('analyte')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('state')
            ->get();

        return response()->json([
            'analyteLabels' => $analyteLabels
        ], 200);
    }


    public function store(
        Request $request)
    {
        $analyte = Analyte::whereId($request->analyte_id)->first();

        $arr =[];

        foreach ($request->labels as $label_id){
            $arr[$label_id] =  ['created_user_id' => Auth::id()];
        }

        $analyte->labels()->sync($arr);

        return response()->json([
            'analyte' => $analyte->labels()->get()
        ], 200);
    }


    public function show($id)
    {
        $analyte = Analyte::whereId($id)->first();

        return $analyte->labels()->get();
    }


    public function update(Request $request, $id)
    {
        $analyte = Analyte::whereId($id)->first();

        $arr =[];

        foreach ($request->labels as $label_id){
            $arr[$label_id] =  ['updated_user_id' => Auth::id(), 'created_user_id' => Auth::id()];
        }

        $analyte->labels()->sync($arr);

        return response()->json([
            'analyte' => $analyte->labels()->get()
        ], 200);
    }

    public function destroy($id)
    {
        $analyte = Analyte::whereId($id)->first();

        $analyte->labels()->sync([]);

        return response()->json([
            'analyte' => $analyte->labels()->get()
        ], 200);
    }
}
