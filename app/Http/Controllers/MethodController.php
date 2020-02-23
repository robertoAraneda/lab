<?php

namespace App\Http\Controllers;

use App\Method;
use App\User;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.method');
    }

    public function index()
    {
        $methods = Method::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();


        return response()->json([
            'methods' => $methods
        ], 200);
    }

    public function store(
        Method $method,
        Request $request
    ) {
        $method->description = $request->description;
        $method->state_id = $request->state_id;
        $method->created_user_id = auth()->id();
        $method->save();

        $method = Method::whereId($method->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'method' => $method
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $method = Method::find($id);
        $method->state_id = $stateController->show($method->state_id);

        return $method;
    }

    public function update(
        Request $request,
        $id
    ) {
        $method = Method::find($id);
        $method->description = $request->description;
        $method->state_id = $request->state_id;
        $method->updated_user_id = auth()->id();

        $method->save();

        $method = Method::whereId($method->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'method' => $method
        ], 200);
    }

    public function destroy($id)
    {
        $method = Method::find($id);
        $method->delete();

        return response()->json([
            'method' => $method
        ], 200);
    }
}
