<?php

namespace App\Http\Controllers;

use App\Analyte;
use App\Http\Controllers\Controller;

use App\Workarea;
use Illuminate\Http\Request;

class SearchTestController extends Controller
{
    public function getAnalyteByName($id)
    {
        $analytes = Analyte::where('description', 'like', "%$id%")
            ->with('tests.method', 'tests.loinc', 'tests.infinity_test',
                'tests.state', 'tests.unit', 'tests.reference_range')
            ->with('labels')
            ->with('indications')
            ->with('hcaLaboratory')
            ->with('infinityLabdateTest')
            ->with('available')
            ->with('medicalOrder')
            ->with('timeResponse')
            ->with('vihKey')
            ->with('loinc')
            ->with('timeProcess')
            ->with('timeReception')
            ->with('workArea.section')
            ->with('state')->get()->map(function ($analyte) {

                $analyteSampleContainerController = new MainAnalyteSampleContainerController();

                $analyte['analyteSampleContainer'] = $analyteSampleContainerController->findByAnalyte($analyte->id)->first();
                return $analyte;
            });

        return $analytes;
    }
    public function getAnalyteByFirstLetter($id)
    {
        $analytes = Analyte::where('description', 'like', "$id%")
            ->with('tests.method', 'tests.loinc', 'tests.infinity_test',
                'tests.state', 'tests.unit', 'tests.reference_range')
            ->with('labels')
            ->with('indications')
            ->with('hcaLaboratory')
            ->with('infinityLabdateTest')
            ->with('available')
            ->with('medicalOrder')
            ->with('timeResponse')
            ->with('vihKey')
            ->with('loinc')
            ->with('timeProcess')
            ->with('timeReception')
            ->with('workArea.section')
            ->with('state')->get()->map(function ($analyte) {

                $analyteSampleContainerController = new MainAnalyteSampleContainerController();

                $analyte['analyteSampleContainer'] = $analyteSampleContainerController->findByAnalyte($analyte->id)->first();
                return $analyte;
            });

        return $analytes;
    }

    public function getAnalyteByWorkarea($id)
    {
        $workarea = Workarea::where('description', $id)->first();

        $analytes = Analyte::where('workarea_id', "$workarea->id")
            ->with('tests.method', 'tests.loinc', 'tests.infinity_test',
                'tests.state', 'tests.unit', 'tests.reference_range')
            ->with('labels')
            ->with('indications')
            ->with('hcaLaboratory')
            ->with('infinityLabdateTest')
            ->with('available')
            ->with('medicalOrder')
            ->with('timeResponse')
            ->with('vihKey')
            ->with('loinc')
            ->with('timeProcess')
            ->with('timeReception')
            ->with('workArea.section')
            ->with('state')->get()->map(function ($analyte) {

                $analyteSampleContainerController = new MainAnalyteSampleContainerController();

                $analyte['analyteSampleContainer'] = $analyteSampleContainerController->findByAnalyte($analyte->id)->first();
                return $analyte;
            });

        return $analytes;
    }

    public function page($id)
    {
        $id = $id;

        $analytes = SearchTestController::getAnalyteByName($id);

        return view('search', compact('analytes', 'id'));
    }

    public function pageByLetter($id){

        $id = $id;

        $analytes = SearchTestController::getAnalyteByFirstLetter($id);

        return view('search', compact('analytes', 'id'));
    }

    public function pageByWorkArea($id){

        $id = $id;

        $analytes = SearchTestController::getAnalyteByWorkarea($id);

        return view('search', compact('analytes', 'id'));
    }

    public function detailPage($id)
    {
        $analyte = Analyte::whereId($id)
            ->with('tests.method', 'tests.loinc', 'tests.infinity_test',
                'tests.state', 'tests.unit', 'tests.reference_range.gender',
                'tests.reference_range.age_unit')
            ->with('labels')
            ->with('indications')
            ->with('hcaLaboratory')
            ->with('infinityLabdateTest')
            ->with('available')
            ->with('medicalOrder')
            ->with('timeResponse')
            ->with('vihKey')
            ->with('loinc')
            ->with('timeProcess')
            ->with('timeReception')
            ->with('workArea.section')
            ->with('state')->first();

        $analyteSampleContainerController = new MainAnalyteSampleContainerController();

        $analyte['analyteSampleContainer'] = $analyteSampleContainerController->findByAnalyte($analyte->id)->first();

        return view('detail', compact('analyte'));
    }
}