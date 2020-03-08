<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Indication;
use Illuminate\Http\Request;

class IndicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.indication');
    }

    public function index()
    {
        $indications = Indication::orderBy('id')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'indications' => $indications
        ], 200);
    }

    public function store(
        Indication $indication,
        Request $request
    ) {
        $indication->description = $request->description;
        $indication->state_id = $request->state_id;
        $indication->created_user_id = auth()->id();
        $indication->save();

        $indication = $this->show($indication->id);

        return response()->json([
            'indication' => $indication
        ], 200);
    }

    public function show($id)
    {
       return Indication::whereId($id)
           ->with('state')
           ->with('createdUser')
           ->with('updatedUser')
           ->first();
    }

    public function update(
        Request $request,
        $id
    ) {
        $indication = Indication::whereId($id)->first();
        $indication->description = $request->description;
        $indication->state_id = $request->state_id;
        $indication->updated_user_id = auth()->id();

        $indication->save();

        $indication = $this->show($indication->id);

        return response()->json([
            'indication' => $indication
        ], 200);
    }

    public function destroy($id)
    {
        $indication = Indication::whereId($id)->first();
        $indication->delete();

        return response()->json([
            'indication' => $indication
        ], 200);
    }
}
