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
    $analytes = Analyte::where([['description', 'like', "%$id%"], ['state_id', 1],])
      ->with(
        'tests.method',
        'tests.loinc',
        'tests.infinityTest',
        'tests.state',
        'tests.unit',
        'tests.referenceRanges.test.unit'
      )
      ->with('labels')
      ->with('indications')
      ->with('hcaLaboratory')
      ->with('infinityLabdateTest')
      ->with('available')
      ->with('medicalOrder')
      ->with('timeResponse')
      ->with('sampleConditions')
      ->with('vihKey')
      ->with('loinc')
      ->with('fonasaTest')
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
    $analytes = Analyte::where([['description', 'like', "$id%"], ['state_id', 1],])
      ->with(
        'tests.method',
        'tests.loinc',
        'tests.infinityTest',
        'tests.state',
        'tests.unit',
        'tests.referenceRanges'
      )
      ->with('labels')
      ->with('indications')
      ->with('hcaLaboratory')
      ->with('infinityLabdateTest')
      ->with('available')
      ->with('medicalOrder')
      ->with('timeResponse')
      ->with('sampleConditions')
      ->with('vihKey')
      ->with('loinc')
      ->with('fonasaTest')
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

    $arr = array();

    $analytes = Analyte::where([['workarea_id', '=', "$workarea->id"], ['state_id', 1],])
      ->with(
        'tests.method',
        'tests.loinc',
        'tests.infinityTest',
        'tests.state',
        'tests.unit',
        'tests.referenceRanges'
      )
      ->with('labels')
      ->with('indications')
      ->with('hcaLaboratory')
      ->with('infinityLabdateTest')
      ->with('available')
      ->with('medicalOrder')
      ->with('timeResponse')
      ->with('sampleConditions')
      ->with('vihKey')
      ->with('loinc')
      ->with('fonasaTest')
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

  public function pageByLetter($id)
  {

    $id = $id;

    $analytes = SearchTestController::getAnalyteByFirstLetter($id);

    return view('search', compact('analytes', 'id'));
  }

  public function pageByWorkArea($id)
  {

    $id = $id;

    $analytes = SearchTestController::getAnalyteByWorkarea($id);

    return view('search', compact('analytes', 'id'));
  }

  public function detailPage($id)
  {
    $analyte = Analyte::whereId($id)
      ->with(
        'tests.method',
        'tests.loinc',
        'tests.infinityTest',
        'tests.state',
        'tests.unit',
        'tests.referenceRanges.gender',
        'tests.referenceRanges.ageUnit',
        'tests.referenceRanges.test.unit'
      )
      ->with('labels')
      ->with('indications')
      ->with('hcaLaboratory')
      ->with('infinityLabdateTest')
      ->with('available')
      ->with('medicalOrder')
      ->with('timeResponse')
      ->with('sampleConditions')
      ->with('fonasaTest')
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
