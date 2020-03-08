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
            ->with('createdUser')
            ->with('updatedUser')
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

        $vihKey = $this->show($vihKey->id);

        return response()->json([
            'vihKey' => $vihKey
        ], 200);
    }

    public function show($id)
    {

        return VihKey::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $vihKey = VihKey::whereId($id)->first();
        $vihKey->description = $request->description;
        $vihKey->state_id = $request->state_id;
        $vihKey->updated_user_id = auth()->id();

        $vihKey->save();

        $vihKey = $this->show($vihKey->id);

        return response()->json([
            'vihKey' => $vihKey
        ], 200);
    }

    public function destroy($id)
    {
        $vihKey = VihKey::whereId($id)->first();
        $vihKey->delete();

        return response()->json([
            'vihKey' => $vihKey
        ], 200);
    }
}
