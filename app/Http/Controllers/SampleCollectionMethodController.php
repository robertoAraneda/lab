<?php

namespace App\Http\Controllers;

use App\SampleCollectionMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleCollectionMethodController extends Controller
{

    public function index()
    {
        //
    }

    public function store(
        SampleCollectionMethod $sampleCollectionMethod,
        Request $request)
    {
        $sampleCollectionMethod->sample_id = $request->sample_id;
        $sampleCollectionMethod->collection_method_id = $request->collection_method_id;
        $sampleCollectionMethod->created_user_id = Auth::id();

        $sampleCollectionMethod->save();

        $sampleCollectionMethod = SampleCollectionMethod::whereId($sampleCollectionMethod->id)
            ->with('sample')
            ->with('collection_method')
            ->first();

        return $sampleCollectionMethod;
    }

    public function show($id)
    {
      return SampleCollectionMethod::where('sample_id', $id)
          ->with('sample')
          ->with('collection_method')
          ->get();
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }


}
