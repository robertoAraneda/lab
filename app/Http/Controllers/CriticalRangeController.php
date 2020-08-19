<?php

namespace App\Http\Controllers;

use App\CriticalRange;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CriticalRangeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CriticalRange $criticalRange, Request $request)
  {
    $criticalRange->test_id = $request->test_id;
    $criticalRange->age_unit_id = $request->age_unit_id;
    $criticalRange->state_id = $request->state_id;
    $criticalRange->gender_id = $request->gender_id;
    $criticalRange->critical_minimum = $request->critical_minimum;
    $criticalRange->critical_maximum = $request->critical_maximum;
    $criticalRange->age_start = $request->age_start;
    $criticalRange->age_end = $request->age_end;
    $criticalRange->interpretation = $request->interpretation;
    $criticalRange->type_value = $request->type_value;

    $criticalRange->critical_cualitative = $request->critical_cualitative;
    $criticalRange->created_user_id = auth()->id();

    $criticalRange->save();

    $criticalRange = $this->show($criticalRange->id);

    return response()->json([
      'criticalRange' => $criticalRange
    ], 200);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return CriticalRange::whereId($id)
      ->with('test.unit')
      ->with('state')
      ->with('ageUnit')
      ->with('gender')
      ->with('createdUser')
      ->with('updatedUser')
      ->first();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $criticalRange = CriticalRange::whereId($id)->first();
    $criticalRange->age_unit_id = $request->age_unit_id;
    $criticalRange->state_id = $request->state_id;
    $criticalRange->gender_id = $request->gender_id;
    $criticalRange->critical_minimum = $request->critical_minimum;
    $criticalRange->critical_maximum = $request->critical_maximum;
    $criticalRange->age_start = $request->age_start;
    $criticalRange->age_end = $request->age_end;
    $criticalRange->interpretation = $request->interpretation;
    $criticalRange->type_value = $request->type_value;

    $criticalRange->critical_cualitative = $request->critical_cualitative;
    $criticalRange->updated_user_id = auth()->id();

    $criticalRange->save();

    $criticalRange = $this->show($criticalRange->id);

    return response()->json([
      'criticalRange' => $criticalRange
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $criticalRange = CriticalRange::whereId($id)->first();
    $criticalRange->delete();

    return response()->json([
      'criticalRange' => $criticalRange
    ], 200);
  }


  public function findByTest($id)
  {
    $criticalRangesByTest = CriticalRange::where('test_id', $id)
      ->with('test.unit')
      ->with('state')
      ->with('ageUnit')
      ->with('gender')
      ->with('createdUser')
      ->with('updatedUser')
      ->get();

    return response()->json([
      'criticalRangesByTest' => $criticalRangesByTest
    ], 200);
  }
}
