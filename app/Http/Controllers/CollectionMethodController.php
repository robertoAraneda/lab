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
        $collectionMethod = CollectionMethod::orderBy('id')->with('state_id')->get();

        return $collectionMethod;
    }

    public function store(
        CollectionMethod $collectionMethod,
        StateController $stateController,
        Request $request)
    {
        $collectionMethod->description = $request->description;
        $collectionMethod->state_id = $request->state_id;
        $collectionMethod->created_user_id = auth()->id();

        $collectionMethod->save();

        $collectionMethod['state_id'] = $stateController->show($collectionMethod->state_id);

        return $collectionMethod;
    }

    public function show(
        StateController $stateController,
        $id)
    {
        $collectionMethod = CollectionMethod::find($id);
        $collectionMethod['state_id'] = $stateController->show($collectionMethod->state_id);

        return $collectionMethod;

    }

    public function update(
        StateController $stateController,
        Request $request,
        $id)
    {
        $collectionMethod = CollectionMethod::find($id);
        $collectionMethod->description = $request->description;
        $collectionMethod->state_id = $request->state_id;
        $collectionMethod->updated_user_id = auth()->id();
        $collectionMethod->save();

        $collectionMethod['state_id'] = $stateController->show($collectionMethod->state_id);

        return $collectionMethod;

    }

    public function destroy($id)
    {
        $collectionMethod = CollectionMethod::find($id);
        $collectionMethod->delete();

        return $collectionMethod;
    }
}
