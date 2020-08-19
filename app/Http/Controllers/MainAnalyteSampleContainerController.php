<?php

namespace App\Http\Controllers;

use App\MainAnalyteSampleContainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainAnalyteSampleContainerController extends Controller
{

  public function index()
  {
    //
  }

  public function store(
    MainAnalyteSampleContainer $analyteSampleContainer,
    Request $request
  ) {
    $analyteSampleContainer->main_analyte_id = $request->main_analyte_id;
    $analyteSampleContainer->analyte_id = $request->analyte_id;
    $analyteSampleContainer->sample_collection_method_id = $request->sample_collection_method_id;
    $analyteSampleContainer->container_id = $request->container_id;
    $analyteSampleContainer->state_id = $request->state_id;
    $analyteSampleContainer->created_user_id = Auth::id();

    $analyteSampleContainer->save();

    $analyteSampleContainer = MainAnalyteSampleContainer::whereId($analyteSampleContainer->id)
      ->with('mainAnalyte')
      ->with('analyte')
      ->with('sampleCollectionMethod')
      ->with('container')
      ->with('createdUser')
      ->with('state')
      ->first();

    return $analyteSampleContainer;
  }

  public function show($id)
  {
  }

  public function update(Request $request, $id)
  {
    $analyteSampleContainer = MainAnalyteSampleContainer::whereId($id)->first();

    $analyteSampleContainer->main_analyte_id = $request->main_analyte_id;
    $analyteSampleContainer->analyte_id = $request->analyte_id;
    $analyteSampleContainer->sample_collection_method_id = $request->sample_collection_method_id;
    $analyteSampleContainer->container_id = $request->container_id;
    $analyteSampleContainer->state_id = $request->state_id;
    $analyteSampleContainer->updated_user_id = Auth::id();

    $analyteSampleContainer->save();

    $analyteSampleContainer = MainAnalyteSampleContainer::whereId($analyteSampleContainer->id)
      ->with('mainAnalyte')
      ->with('analyte')
      ->with('sampleCollectionMethod')
      ->with('container')
      ->with('createdUser')
      ->with('state')
      ->first();

    return $analyteSampleContainer;
  }

  public function destroy($id)
  {
    $analyteSampleContainer = MainAnalyteSampleContainer::whereId($id)->first();
    $analyteSampleContainer->delete();

    return response()->json([
      'success' => $analyteSampleContainer
    ], 200);
  }

  public function findByAnalyte($id)
  {
    $analyteSampleContainer = MainAnalyteSampleContainer::where('analyte_id', $id)
      ->with('mainAnalyte')
      ->with('analyte')
      ->with('analyte.analyteTimeResponseDetail')
      ->with('sampleCollectionMethod.sample', 'sampleCollectionMethod.collectionMethod')
      ->with('container')
      ->with('createdUser')
      ->with('state')
      ->get();

    return $analyteSampleContainer;
  }
}
