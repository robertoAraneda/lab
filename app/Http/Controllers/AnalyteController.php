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
//        $analytes = Analyte::orderBy('id')
//            ->get()
//            ->map(function ($analyte) {
//                $stateController = new StateController();
//                $labelController = new LabelController();
//                $hcaLaboratoryController = new HcaLaboratoryController();
//                $infinityLabdateTestController = new InfinityLabdateTestController();
//                $availableController = new AvailableController();
//                $loincController = new LoincController();
//                $timeProcessController = new TimeProcessController();
//                $timeReceptionController = new TimeReceptionController();
//                $workareaController = new WorkareaController();
//                $vihKeyController = new VihKeyController();
//
//                $analyte->label_id = $labelController->show($analyte->label_id);
//                $analyte->hca_laboratory_id = $hcaLaboratoryController->show($analyte->hca_laboratory_id);
//                $analyte->infinity_labdate_test_id = $infinityLabdateTestController->show($analyte->infinity_labdate_test_id);
//                $analyte->available_id = $availableController->show($analyte->available_id);
//                $analyte->vih_key_id = $vihKeyController->show($analyte->vih_key_id);
//                $analyte->loinc_id = $loincController->show($analyte->loinc_id);
//                $analyte->time_process_id = $timeProcessController->show($analyte->time_process_id);
//                $analyte->time_reception_id = $timeReceptionController->show($analyte->time_reception_id);
//                $analyte->workarea_id = $workareaController->show($analyte->workarea_id);
//                $analyte->state_id = $stateController->show($analyte->state_id);
//                $analyte->created_user_id = User::find($analyte->created_user_id);
//                $analyte->updated_user_id = User::find($analyte->updated_user_id);
//
//                return $analyte;
//
//            });

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
            ->get();

        return response()->json([
            'analytes' => $analytes
        ], 200);

    }


    public function store(
        Analyte $analyte,
        StateController $stateController,
        HcaLaboratoryController $hcaLaboratoryController,
        InfinityLabdateTestController $infinityLabdateTestController,
        AvailableController $availableController,
        LoincController $loincController,
        TimeProcessController $timeProcessController,
        TimeReceptionController $timeReceptionController,
        WorkareaController $workareaController,
        VihKeyController $vihKeyController,
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

        $analyte = Analyte::whereId($analyte->id)
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
            ->first();


//        $analyte['state_id'] = $stateController->show($analyte['state_id']);
//        $analyte->created_user_id = User::find($analyte->created_user_id);
//        $analyte->hca_laboratory_id = $hcaLaboratoryController->show($analyte->hca_laboratory_id);
//        $analyte->infinity_labdate_test_id = $infinityLabdateTestController->show($analyte->infinity_labdate_test_id);
//        $analyte['available_id'] = $availableController->show($analyte['available_id']);
//        $analyte->vih_key_id = $vihKeyController->show($analyte->vih_key_id);
//        $analyte->loinc_id = $loincController->show($analyte->loinc_id);
//        $analyte->time_process_id = $timeProcessController->show($analyte->time_process_id);
//        $analyte->time_reception_id = $timeReceptionController->show($analyte->time_reception_id);
//        $analyte->workarea_id = $workareaController->show($analyte->workarea_id);


        return $analyte;
    }

    public function show($id)
    {
        $stateController = new StateController();
        $labelController = new LabelController();
        $hcaLaboratoryController = new HcaLaboratoryController();
        $infinityLabdateTestController = new InfinityLabdateTestController();
        $availableController = new AvailableController();
        $loincController = new LoincController();
        $timeProcessController = new TimeProcessController();
        $timeReceptionController = new TimeReceptionController();
        $workareaController = new WorkareaController();
        $vihKeyController = new VihKeyController();

        $analyte = Analyte::find($id);
        $analyte->state_id = $stateController->show($analyte->state_id);
        $analyte->created_user_id = User::find($analyte->created_user_id);
        $analyte->label_id = $labelController->show($analyte->label_id);
        $analyte->hca_laboratory_id = $hcaLaboratoryController->show($analyte->hca_laboratory_id);
        $analyte->infinity_labdate_test_id = $infinityLabdateTestController->show($analyte->infinity_labdate_test_id);
        $analyte->available_id = $availableController->show($analyte->available_id);
        $analyte->vih_key_id = $vihKeyController->show($analyte->vih_key_id);
        $analyte->loinc_id = $loincController->show($analyte->loinc_id);
        $analyte->time_process_id = $timeProcessController->show($analyte->time_process_id);
        $analyte->time_reception_id = $timeReceptionController->show($analyte->time_reception_id);
        $analyte->workarea_id = $workareaController->show($analyte->workarea_id);

        return $analyte;
    }

    public function update(
        StateController $stateController,
        LabelController $labelController,
        HcaLaboratoryController $hcaLaboratoryController,
        InfinityLabdateTestController $infinityLabdateTestController,
        AvailableController $availableController,
        LoincController $loincController,
        TimeProcessController $timeProcessController,
        TimeReceptionController $timeReceptionController,
        WorkareaController $workareaController,
        VihKeyController $vihKeyController,
        Request $request, $id)
    {
        $analyte = Analyte::find($id);
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


        $analyte = Analyte::whereId($analyte->id)
            ->with('hcaLaboratory')
            ->with('infinityLabdateTest')
            ->with('available')
            ->with('vihKey')
            ->with('medicalOrder')
            ->with('timeResponse')
            ->with('loinc')
            ->with('timeProcess')
            ->with('timeReception')
            ->with('fonasaTest')
            ->with('workArea')
            ->with('state')
            ->with('createdUser')
            ->with('updatedUser')
            ->first();

//        $analyte->state_id = $stateController->show($analyte->state_id);
//        $analyte->updated_user_id = User::find($analyte->updated_user_id);
//        $analyte->created_user_id = User::find($analyte->created_user_id);
//        $analyte->hca_laboratory_id = $hcaLaboratoryController->show($analyte->hca_laboratory_id);
//        $analyte->infinity_labdate_test_id = $infinityLabdateTestController->show($analyte->infinity_labdate_test_id);
//        $analyte->available_id = $availableController->show($analyte->available_id);
//        $analyte->vih_key_id = $vihKeyController->show($analyte->vih_key_id);
//        $analyte->loinc_id = $loincController->show($analyte->loinc_id);
//        $analyte->time_process_id = $timeProcessController->show($analyte->time_process_id);
//        $analyte->time_reception_id = $timeReceptionController->show($analyte->time_reception_id);
//        $analyte->workarea_id = $workareaController->show($analyte->workarea_id);

        return $analyte;
    }

    public function destroy($id)
    {
        $analyte = Analyte::find($id);
        $analyte->delete();

        return $analyte;
    }
}
