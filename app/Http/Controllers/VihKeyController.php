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
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();

        return response()->json([
            'vihKeys' => $vihKeys
        ], 200);
    }

    public function store(
        VihKey $vihKey,
        Request $request
    ) {
        $vihKey->description = $request->description;
        $vihKey->state_id = $request->state_id;
        $vihKey->created_user_id = auth()->id();
        $vihKey->save();

        $vihKey = VihKey::whereId($vihKey->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'vihKey' => $vihKey
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $vihKey = VihKey::find($id);
        $vihKey->state_id = $stateController->show($vihKey->state_id);

        return $vihKey;
    }

    public function update(
        Request $request,
        $id
    ) {
        $vihKey = VihKey::find($id);
        $vihKey->description = $request->description;
        $vihKey->state_id = $request->state_id;
        $vihKey->updated_user_id = auth()->id();

        $vihKey->save();

        $vihKey = VihKey::whereId($vihKey->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'vihKey' => $vihKey
        ], 200);
    }

    public function destroy($id)
    {
        $vihKey = VihKey::find($id);
        $vihKey->delete();

        return response()->json([
            'vihKey' => $vihKey
        ], 200);
    }
}
