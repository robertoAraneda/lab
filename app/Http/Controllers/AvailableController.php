<?php

namespace App\Http\Controllers;

use App\Available;
use App\User;
use Illuminate\Http\Request;

class AvailableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.available');
    }

    public function index()
    {
        $availables = Available::orderBy('id')
            ->get()
            ->map(function($available){
                $stateController = new StateController();

                $available->state_id = $stateController->show($available->state_id );
                $available->created_user_id = User::find($available->created_user_id);
                $available->updated_user_id = User::find($available->updated_user_id);
                return $available;

            });

        return $availables;
    }

    public function store(
        Available $available,
        StateController $stateController,
        Request $request)
    {
        $available->description = $request->description;
        $available->state_id = $request->state_id;
        $available->created_user_id = auth()->id();
        $available->save();

        $available->state_id = $stateController->show($available->state_id);
        $available->created_user_id = User::find($available->created_user_id);


        return $available;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $available = Available::find($id);
        $available['state_id'] = $stateController->show($available['state_id']);

        return $available;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $available = Available::find($id);
        $available->description = $request->description;
        $available->state_id = $request->state_id;
        $available->updated_user_id = auth()->id();

        $available->save();

        $available->state_id = $stateController->show($available->state_id);

        return $available;
    }

    public function destroy($id)
    {
        $available = Available::find($id);
        $available->delete();

        return $available;
    }
}
