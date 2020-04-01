<?php

namespace App\Http\Controllers;

use App\QuantitySample;
use Illuminate\Http\Request;

class QuantitySampleController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {

    return view('admin.quantitySample');
  }
  public function index()
  {
    $quantitySamples = QuantitySample::orderBy('id')
      ->with('state')
      ->get();

    return response()->json([
      'quantitySamples' => $quantitySamples
    ], 200);
  }
  public function store(QuantitySample $quantitySample, Request $request)
  {
    $quantitySample->description = $request->description;
    $quantitySample->state_id = $request->state_id;
    $quantitySample->created_user_id = auth()->id();
    $quantitySample->save();

    $quantitySample = $this->show($quantitySample->id);

    return response()->json([
      'quantitySample' => $quantitySample
    ], 200);
  }


  public function show($id)
  {
    return QuantitySample::whereId($id)
      ->with('state')
      ->with('createdUser')
      ->with('updatedUser')
      ->first();
  }

  public function update(Request $request, $id)
  {
    $quantitySample = QuantitySample::whereId($id)->first();
    $quantitySample->description = $request->description;
    $quantitySample->state_id = $request->state_id;
    $quantitySample->updated_user_id = auth()->id();

    $quantitySample->save();

    $quantitySample = $this->show($quantitySample->id);

    return response()->json([
      'quantitySample' => $quantitySample
    ], 200);
  }

  public function destroy($id)
  {
    $quantitySample = QuantitySample::whereId($id)->first();
    $quantitySample->delete();

    return response()->json([
      'quantitySample' => $quantitySample
    ], 200);
  }
}
