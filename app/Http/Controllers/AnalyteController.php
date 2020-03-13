<?php

namespace App\Http\Controllers;

use App\Analyte;
use App\User;
use Illuminate\Http\Request;

class AnalyteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('admin.analyte');
    }

    public function index()
    {
        $analytes = Analyte::orderBy('id')
            ->with('hcaLaboratory')
            ->with('infinityLabdateTest')
            ->with('available')
            ->with('vihKey')
            ->with('medicalOrder')
            ->with('timeResponse')
            ->with('loinc')
            ->with('timeProcess')
            ->with('timeReception')
            ->with('workArea')
            ->with('fonasaTest')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->with('analyteSampleContainer.mainAnalyte', 'analyteSampleContainer.container', 'analyteSampleContainer.sampleCollectionMethod.sample', 'analyteSampleContainer.sampleCollectionMethod.collectionMethod')
            ->with('tests.referenceRanges.ageUnit', 'tests.referenceRanges.gender', 'tests.referenceRanges.test', 'tests.referenceRanges.test.unit')
            ->with('tests.method', 'tests.unit', 'tests.loinc', 'tests.infinityTest')
            ->get();

        return response()->json([
            'analytes' => $analytes
        ], 200);

    }


    public function store(
        Analyte $analyte,
        Request $request)
    {

        $analyte->description = $request->description;
        $analyte->observation = $request->observation;
        $analyte->hca_laboratory_id = $request->hca_laboratory_id;
        $analyte->infinity_labdate_test_id = $request->infinity_labdate_test_id;
        $analyte->available_id = $request->available_id;
        $analyte->vih_key_id = $request->vih_key_id;
        $analyte->loinc_id = $request->loinc_id;
        $analyte->time_process_id = $request->time_process_id;
        $analyte->time_reception_id = $request->time_reception_id;
        $analyte->workarea_id = $request->workarea_id;
        $analyte->medical_order_id = $request->medical_order_id;
        $analyte->time_response_id = $request->time_response_id;
        $analyte->fonasa_test_id = $request->fonasa_test_id;
        $analyte->state_id = $request->state_id;
        $analyte->created_user_id = auth()->id();
        $analyte->save();

        $analyte = $this->show($analyte->id);

        return response()->json(['analyte' => $analyte], 200);
    }

    public function show($id)
    {
        return Analyte::whereId($id)
        ->with('hcaLaboratory')
        ->with('infinityLabdateTest')
        ->with('available')
        ->with('vihKey')
        ->with('medicalOrder')
        ->with('timeResponse')
        ->with('loinc')
        ->with('timeProcess')
        ->with('timeReception')
        ->with('workArea')
        ->with('fonasaTest')
        ->with('state')
        ->with('createdUser')
        ->with('updatedUser')
        ->with('analyteSampleContainer.mainAnalyte', 'analyteSampleContainer.container', 'analyteSampleContainer.sampleCollectionMethod.sample', 'analyteSampleContainer.sampleCollectionMethod.collectionMethod')
        ->with('tests.referenceRanges.ageUnit', 'tests.referenceRanges.gender', 'tests.referenceRanges.test', 'tests.referenceRanges.test.unit')
        ->with('tests.method', 'tests.unit', 'tests.loinc', 'tests.infinityTest')
            ->first();
    }

    public function update(Request $request, $id)
    {
        $analyte = Analyte::whereId($id)->first();
        $analyte->description = $request->description;
        $analyte->observation = $request->observation;
        $analyte->hca_laboratory_id = $request->hca_laboratory_id;
        $analyte->infinity_labdate_test_id = $request->infinity_labdate_test_id;
        $analyte->available_id = $request->available_id;
        $analyte->vih_key_id = $request->vih_key_id;
        $analyte->loinc_id = $request->loinc_id;
        $analyte->time_process_id = $request->time_process_id;
        $analyte->time_reception_id = $request->time_reception_id;
        $analyte->medical_order_id = $request->medical_order_id;
        $analyte->time_response_id = $request->time_response_id;
        $analyte->fonasa_test_id = $request->fonasa_test_id;
        $analyte->workarea_id = $request->workarea_id;
        $analyte->state_id = $request->state_id;
        $analyte->updated_user_id = auth()->id();
        $analyte->save();

        $analyte = $this->show($analyte->id);

        return response()->json(['analyte' => $analyte], 200);
    }

    public function destroy($id)
    {
        $analyte = Analyte::whereId($id)->first();
        $analyte->delete();

        return response()->json(['analyte' => $analyte], 200);
    }

    public function updateChecked($id, Request $request){
        $analyte = Analyte::whereId($id)->first();
        $analyte->is_checked = $request->is_checked;

        $analyte->save();

        $analyte = $this->show($analyte->id);

        return response()->json(['analyte' => $analyte], 200);
    }
}
