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
            ->get()
            ->map(function ($method) {
                $stateController = new StateController();

                $method->state_id = $stateController->show($method->state_id);
                $method->created_user_id = User::find($method->created_user_id);
                $method->updated_user_id = User::find($method->updated_user_id);
                return $method;

            });

        return $methods;
    }

    public function store(
        Method $method,
        StateController $stateController,
        Request $request)
    {
        $method->description = $request->description;
        $method->state_id = $request->state_id;
        $method->created_user_id = auth()->id();
        $method->save();

        $method->state_id = $stateController->show($method->state_id);
        $method->created_user_id = User::find($method->created_user_id);


        return $method;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $method = Method::find($id);
        $method->state_id = $stateController->show($method->state_id);

        return $method;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $method = Method::find($id);
        $method->description = $request->description;
        $method->state_id = $request->state_id;
        $method->updated_user_id = auth()->id();

        $method->save();

        $method->state_id = $stateController->show($method->state_id);

        return $method;
    }

    public function destroy($id)
    {
        $method = Method::find($id);
        $method->delete();

        return $method;
    }
}
