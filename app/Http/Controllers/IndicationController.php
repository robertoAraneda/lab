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
            ->with('created_user')
            ->with('updated_user')
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

        $indication = indication::whereId($indication->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'indication' => $indication
        ], 200);
    }

    public function show($id)
    {
        $stateController = new StateController();

        $indication = Indication::find($id);
        $indication->state_id = $stateController->show($indication->state_id);

        return $indication;
    }

    public function update(
        Request $request,
        $id
    ) {
        $indication = Indication::find($id);
        $indication->description = $request->description;
        $indication->state_id = $request->state_id;
        $indication->updated_user_id = auth()->id();

        $indication->save();

        $indication = Indication::whereId($indication->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'indication' => $indication
        ], 200);
    }

    public function destroy($id)
    {
        $indication = Indication::find($id);
        $indication->delete();

        return response()->json([
            'indication' => $indication
        ], 200);
    }
}
