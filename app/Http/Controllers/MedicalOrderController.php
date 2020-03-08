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
            ->with('createdUser')
            ->with('updatedUser')
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

        $medicalOrder = $this->show($medicalOrder->id);

        return response()->json([
            'medicalOrder' => $medicalOrder
        ], 200);
    }

    public function show($id)
    {
        return MedicalOrder::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id
    )
    {
        $medicalOrder = MedicalOrder::whereId($id)->first();
        $medicalOrder->description = $request->description;
        $medicalOrder->state_id = $request->state_id;
        $medicalOrder->updated_user_id = auth()->id();

        $medicalOrder->save();

        $medicalOrder = $this->show($medicalOrder->id);

        return response()->json([
            'medicalOrder' => $medicalOrder
        ], 200);

    }

    public function destroy($id)
    {
        $medicalOrder = MedicalOrder::whereId($id)->first();
        $medicalOrder->delete();

        return response()->json([
            'medicalOrder' => $medicalOrder
        ], 200);
    }
}
