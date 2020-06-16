<?php

namespace App\Http\Controllers;

use App\Analyte;
use App\AnalyteSampleCondition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyteSampleConditionController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {
    return view('admin.analyteSampleCondition');
  }


  public function index()
  {
    $analyteSampleCondition = AnalyteSampleCondition::orderBy('id')
      ->with('sampleCondition')
      ->with('analyte')
      ->with('createdUser')
      ->get();

    return response()->json([
      'analyteSampleCondition' => $analyteSampleCondition
    ], 200);
  }


  public function store(Request $request)
  {
    $analyte = Analyte::whereId($request->analyte_id)->first();

    $arr = array();

    foreach ($request->sampleConditions as $sample_condition_id) {
      $arr[$sample_condition_id] = [
        'created_user_id' => auth()->id(),
        'order' => count($arr) + 1
      ];
    }

    $analyte->sampleConditions()->sync($arr);


    return response()->json([
      'analyte' => $analyte->sampleConditions()->orderBy('order')->get()
    ], 200);
  }

  public function show($id)
  {
    $analyte = Analyte::whereId($id)->first();

    return $analyte->sampleConditions()->get();
  }

  public function update(Request $request, $id)
  {
    $analyte = Analyte::whereId($id)->first();

    $arr = array();

    foreach ($request->sampleConditions as $sample_condition_id) {
      $arr[$sample_condition_id] = [
        'created_user_id' => auth()->id(),
        'order' => count($arr) + 1
      ];
    }

    $analyte->sampleConditions()->sync($arr);


    return response()->json([
      'analyte' => $analyte->sampleConditions()->orderBy('order')->get()
    ], 200);
  }

  public function destroy($id)
  {
    $analyte = Analyte::whereId($id)->first();

    $analyte->sampleConditions()->sync([]);

    return response()->json([
      'analyte' => $analyte
    ], 200);
  }
}
