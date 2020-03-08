<?php

namespace App\Http\Controllers;

use App\HcaLaboratory;
use Illuminate\Http\Request;

class HcaLaboratoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.hcaLaboratory');
    }

    public function index()
    {
        $hcaLaboratories = HcaLaboratory::orderBy('id')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->get();

        return response()->json([
            'hcaLaboratories' => $hcaLaboratories
        ], 200);
    }

    public function store(
        HcaLaboratory $hcaLaboratory,
        Request $request)
    {
        $hcaLaboratory->type_test = $request->type_test_id;
        $hcaLaboratory->description = $request->description;
        $hcaLaboratory->internal_code = $request->internal_code;
        $hcaLaboratory->external_code = $request->external_code;
        $hcaLaboratory->location = $request->location_lab;
        $hcaLaboratory->state_id = $request->state_id;
        $hcaLaboratory->created_user_id = auth()->id();

        $hcaLaboratory->save();

        $hcaLaboratory = $this->show($hcaLaboratory->id);

        return response()->json([
            'hcaLaboratory' => $hcaLaboratory
        ], 200);
    }

    public function show(
        $id)
    {
        return HcaLaboratory::whereId($id)
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();
    }

    public function update(
        Request $request,
        $id)
    {
        $hcaLaboratory = HcaLaboratory::whereId($id)->first();
        $hcaLaboratory->type_test = $request->type_test_id;
        $hcaLaboratory->description = $request->description;
        $hcaLaboratory->internal_code = $request->internal_code;
        $hcaLaboratory->external_code = $request->external_code;
        $hcaLaboratory->location = $request->location_lab;
        $hcaLaboratory->state_id = $request->state_id;
        $hcaLaboratory->updated_user_id = auth()->id();

        $hcaLaboratory->save();

        $hcaLaboratory = $this->show($hcaLaboratory->id);

        return response()->json([
            'hcaLaboratory' => $hcaLaboratory
        ], 200);

    }

    public function destroy($id)
    {
        $hcaLaboratory = HcaLaboratory::whereId($id)->first();
        $hcaLaboratory->delete();

        return response()->json([
            'hcaLaboratory' => $hcaLaboratory
        ], 200);
    }
}
