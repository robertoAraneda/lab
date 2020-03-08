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
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'collectionMethods' => $collectionMethods
        ]);
    }

    public function store(
        CollectionMethod $collectionMethod,
        Request $request
    )
    {
        $collectionMethod->description = $request->description;
        $collectionMethod->state_id = $request->state_id;
        $collectionMethod->created_user_id = auth()->id();

        $collectionMethod->save();

        $collectionMethod = $this->show($collectionMethod->id);

        return response()->json([
            'collectionMethod' => $collectionMethod
        ]);
    }

    public function show($id)
    {
        return CollectionMethod::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();

    }

    public function update(
        Request $request,
        $id
    )
    {
        $collectionMethod = CollectionMethod::whereId($id)->first();
        $collectionMethod->description = $request->description;
        $collectionMethod->state_id = $request->state_id;
        $collectionMethod->updated_user_id = auth()->id();
        $collectionMethod->save();

        $collectionMethod = $this->show($collectionMethod->id);

        return response()->json([
            'collectionMethod' => $collectionMethod
        ]);
    }

    public function destroy($id)
    {
        $collectionMethod = CollectionMethod::whereId($id)->first();
        $collectionMethod->delete();

        return response()->json([
            'collectionMethod' => $collectionMethod
        ]);
    }
}
