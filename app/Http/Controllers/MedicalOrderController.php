<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\MedicalOrder;
use Illuminate\Http\Request;

class MedicalOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.medicalOrder');
    }

    public function index()
    {
        $medicalOrders = MedicalOrder::orderBy('id')
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->get();


        return response()->json([
            'medicalOrders' => $medicalOrders
        ], 200);
    }

    public function store(
        MedicalOrder $medicalOrder,
        Request $request
    )
    {
        $medicalOrder->description = $request->description;
        $medicalOrder->state_id = $request->state_id;
        $medicalOrder->created_user_id = auth()->id();
        $medicalOrder->save();

        $medicalOrder = MedicalOrder::whereId($medicalOrder->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'medicalOrder' => $medicalOrder
        ], 200);
    }

    public function show($id)
    {

        $medicalOrder = MedicalOrder::find($id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return $medicalOrder;
    }

    public function update(
        Request $request,
        $id
    )
    {
        $medicalOrder = MedicalOrder::find($id);
        $medicalOrder->description = $request->description;
        $medicalOrder->state_id = $request->state_id;
        $medicalOrder->updated_user_id = auth()->id();

        $medicalOrder->save();

        $medicalOrder = MedicalOrder::whereId($medicalOrder->id)
            ->with('state')
            ->with('created_user')
            ->with('updated_user')
            ->first();

        return response()->json([
            'medicalOrder' => $medicalOrder
        ], 200);

    }

    public function destroy($id)
    {
        $medicalOrder = MedicalOrder::find($id);
        $medicalOrder->delete();

        return response()->json([
            'medicalOrder' => $medicalOrder
        ], 200);
    }
}
