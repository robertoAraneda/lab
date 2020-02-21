<?php

namespace App\Http\Controllers;

use App\User;
use App\VihKey;
use Illuminate\Http\Request;

class VihKeyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.vihkey');
    }

    public function index()
    {
        $vihKeys = VihKey::orderBy('id')
            ->get()
            ->map(function ($vihKey) {
                $stateController = new StateController();

                $vihKey->state_id = $stateController->show($vihKey->state_id);
                $vihKey->created_user_id = User::find($vihKey->created_user_id);
                $vihKey->updated_user_id = User::find($vihKey->updated_user_id);
                return $vihKey;

            });

        return $vihKeys;
    }

    public function store(
        VihKey $vihKey,
        StateController $stateController,
        Request $request)
    {
        $vihKey->description = $request->description;
        $vihKey->state_id = $request->state_id;
        $vihKey->created_user_id = auth()->id();
        $vihKey->save();

        $vihKey->state_id = $stateController->show($vihKey->state_id);
        $vihKey->created_user_id = User::find($vihKey->created_user_id);


        return $vihKey;
    }

    public function show($id)
    {
        $stateController = new StateController();

        $vihKey = VihKey::find($id);
        $vihKey->state_id = $stateController->show($vihKey->state_id);

        return $vihKey;
    }

    public function update(
        StateController $stateController,
        Request $request, $id)
    {
        $vihKey = VihKey::find($id);
        $vihKey->description = $request->description;
        $vihKey->state_id = $request->state_id;
        $vihKey->updated_user_id = auth()->id();

        $vihKey->save();

        $vihKey->state_id = $stateController->show($vihKey->state_id);

        return $vihKey;
    }

    public function destroy($id)
    {
        $vihKey = VihKey::find($id);
        $vihKey->delete();

        return $vihKey;
    }
}
