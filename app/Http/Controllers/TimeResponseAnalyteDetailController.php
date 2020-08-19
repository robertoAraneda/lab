<?php

namespace App\Http\Controllers;

use App\Analyte;
use App\Http\Controllers\Controller;
use App\TimeResponseAnalyteDetail;
use Illuminate\Http\Request;

class TimeResponseAnalyteDetailController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $timeResponseAnalyteDetails = TimeResponseAnalyteDetail::orderBy('id')
      ->with('createdUser')
      ->with('updatedUser')
      ->with('timeResponseHosp')
      ->with('timeResponseUrg')
      ->with('timeResponseAmb')
      ->with('timeResponseExt')
      ->with('state')
      ->get();

    return response()->json([
      'timeResponseAnalyteDetails' => $timeResponseAnalyteDetails
    ], 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $timeResponseAnalyteDetail = new TimeResponseAnalyteDetail();
    $timeResponseAnalyteDetail->analyte_id = $request->analyte_id;
    $timeResponseAnalyteDetail->time_response_id_urgency = $request->time_response_id_urgency;
    $timeResponseAnalyteDetail->time_response_id_hospitalized = $request->time_response_id_hospitalized;
    $timeResponseAnalyteDetail->time_response_id_external = $request->time_response_id_external;
    $timeResponseAnalyteDetail->time_response_id_ambulatory = $request->time_response_id_ambulatory;
    $timeResponseAnalyteDetail->state_id = $request->state_id;
    $timeResponseAnalyteDetail->created_user_id = auth()->id();
    $timeResponseAnalyteDetail->save();

    $timeResponseAnalyteDetail = $this->show($timeResponseAnalyteDetail->id);

    return response()->json([
      'timeResponseAnalyteDetail' => $timeResponseAnalyteDetail
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
    return TimeResponseAnalyteDetail::whereId($id)
      ->with('createdUser')
      ->with('updatedUser')
      ->with('timeResponseHosp')
      ->with('timeResponseUrg')
      ->with('timeResponseAmb')
      ->with('timeResponseExt')
      ->with('state')
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
    $timeResponseAnalyteDetail = TimeResponseAnalyteDetail::find($id);

    $timeResponseAnalyteDetail->analyte_id = $request->analyte_id;
    $timeResponseAnalyteDetail->time_response_id_urgency = $request->time_response_id_urgency;
    $timeResponseAnalyteDetail->time_response_id_hospitalized = $request->time_response_id_hospitalized;
    $timeResponseAnalyteDetail->time_response_id_external = $request->time_response_id_external;
    $timeResponseAnalyteDetail->time_response_id_ambulatory = $request->time_response_id_ambulatory;
    $timeResponseAnalyteDetail->state_id = $request->state_id;
    $timeResponseAnalyteDetail->updated_user_id = auth()->id();
    $timeResponseAnalyteDetail->save();

    $timeResponseAnalyteDetail = $this->show($timeResponseAnalyteDetail->id);

    return response()->json([
      'timeResponseAnalyteDetail' => $timeResponseAnalyteDetail
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
    $timeResponseAnalyteDetail = TimeResponseAnalyteDetail::whereId($id)->first();
    $timeResponseAnalyteDetail->delete();

    return response()->json([
      'timeResponseAnalyteDetail' => $timeResponseAnalyteDetail
    ], 200);
  }

  public function findTimeResponseDetailByAnalyteId($analyteId)
  {
    $timeResponseAnalyteDetail = TimeResponseAnalyteDetail::where('analyte_id', $analyteId)->first();

    if (isset($timeResponseAnalyteDetail)) {

      return response()->json([
        'timeResponseAnalyteDetail' => $timeResponseAnalyteDetail
      ], 200);
    } else {
      return response()->json([
        'timeResponseAnalyteDetail' => null
      ], 200);
    }
  }
}
