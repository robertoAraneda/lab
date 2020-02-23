<?php

namespace App\Http\Controllers;

use App\CollectionMethod;
use Illuminate\Http\Request;

class CollectionMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.collectionMethod');
    }

    public function index()
    {
        $collectionMethods = CollectionMethod::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'collectionMethods' => $collectionMethods
        ]);
    }

    public function store(
        CollectionMethod $collectionMethod,
        Request $request
    ) {
        $collectionMethod->description = $request->description;
        $collectionMethod->state_id = $request->state_id;
        $collectionMethod->created_user_id = auth()->id();

        $collectionMethod->save();

        $collectionMethod = CollectionMethod::whereId($collectionMethod->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'collectionMethod' => $collectionMethod
        ]);
    }

    public function show(
        StateController $stateController,
        $id
    ) {
        $collectionMethod = CollectionMethod::find($id);
        $collectionMethod['state_id'] = $stateController->show($collectionMethod->state_id);

        return $collectionMethod;
    }

    public function update(
        Request $request,
        $id
    ) {
        $collectionMethod = CollectionMethod::find($id);
        $collectionMethod->description = $request->description;
        $collectionMethod->state_id = $request->state_id;
        $collectionMethod->updated_user_id = auth()->id();
        $collectionMethod->save();

        $collectionMethod = CollectionMethod::whereId($collectionMethod->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'collectionMethod' => $collectionMethod
        ]);
    }

    public function destroy($id)
    {
        $collectionMethod = CollectionMethod::find($id);
        $collectionMethod->delete();

        return response()->json([
            'collectionMethod' => $collectionMethod
        ]);
    }
}
