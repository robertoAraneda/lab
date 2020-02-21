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
        $hcaLaboratory = HcaLaboratory::orderBy('id')->with('state_id')->get();
        return $hcaLaboratory;
    }

    public function store(
        HcaLaboratory $hcaLaboratory,
        StateController $stateController,
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

        $hcaLaboratory['state_id'] = $stateController->show($hcaLaboratory->state_id);

        return $hcaLaboratory;


    }

    public function show(
        $id)
    {

        $stateController = new StateController();
        $hcaLaboratory = HcaLaboratory::find($id);
        $hcaLaboratory['state_id'] = $stateController->show($hcaLaboratory['state_id']);
        return $hcaLaboratory;
    }

    public function update(
        StateController $stateController,
        Request $request,
        $id)
    {
        $hcaLaboratory = HcaLaboratory::find($id);
        $hcaLaboratory->type_test = $request->type_test_id;
        $hcaLaboratory->description = $request->description;
        $hcaLaboratory->internal_code = $request->internal_code;
        $hcaLaboratory->external_code = $request->external_code;
        $hcaLaboratory->location = $request->location_lab;
        $hcaLaboratory->state_id = $request->state_id;
        $hcaLaboratory->updated_user_id = auth()->id();

        $hcaLaboratory->save();

        $hcaLaboratory['state_id'] = $stateController->show($hcaLaboratory->state_id);

        return $hcaLaboratory;

    }

    public function destroy($id)
    {
        $hcaLaboratory = HcaLaboratory::find($id);
        $hcaLaboratory->delete();

        return $hcaLaboratory;
    }
}
