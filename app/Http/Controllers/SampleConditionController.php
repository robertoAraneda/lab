<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\SampleCondition;
use Illuminate\Http\Request;

class SampleConditionController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {

    return view('admin.sampleCondition');
  }

  public function index()
  {
    $sampleConditions = SampleCondition::orderBy('id')
      ->with('state')
      ->with('createdUser')
      ->with('updatedUser')
      ->get();


    return response()->json([
      'sampleConditions' => $sampleConditions
    ], 200);
  }

  public function store(
    SampleCondition $sampleCondition,
    Request $request
  ) {
    $sampleCondition->description = $request->description;
    $sampleCondition->state_id = $request->state_id;
    $sampleCondition->created_user_id = auth()->id();
    $sampleCondition->save();

    $sampleCondition = $this->show($sampleCondition->id);

    return response()->json([
      'sampleCondition' => $sampleCondition
    ], 200);
  }

  public function show($id)
  {
    return SampleCondition::whereId($id)
      ->with('state')
      ->with('createdUser')
      ->with('updatedUser')
      ->first();
  }

  public function update(
    Request $request,
    $id
  ) {
    $sampleCondition = SampleCondition::whereId($id)->first();
    $sampleCondition->description = $request->description;
    $sampleCondition->state_id = $request->state_id;
    $sampleCondition->updated_user_id = auth()->id();

    $sampleCondition->save();

    $sampleCondition = $this->show($sampleCondition->id);

    return response()->json([
      'sampleCondition' => $sampleCondition
    ], 200);
  }

  public function destroy($id)
  {
    $sampleCondition = SampleCondition::whereId($id)->first();
    $sampleCondition->delete();

    return response()->json([
      'sampleCondition' => $sampleCondition
    ], 200);
  }
}
