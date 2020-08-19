<?php

namespace App\Http\Controllers\ControllerBack;

use App\AgeUnit;
use App\Analyte;
use App\AnalyteIndication;
use App\AnalyteLabel;
use App\AnalyteSampleCondition;
use App\AnalyteTests;
use App\Available;
use App\CollectionMethod;
use App\Container;
use App\FonasaTest;
use App\Gender;
use App\HcaLaboratory;
use App\Http\Controllers\Controller;
use App\Indication;
use App\InfinityGroup;
use App\InfinityLabdateTest;
use App\InfinityRelGroupTest;
use App\InfinitySample;
use App\InfinitySupergroup;
use App\InfinityTest;
use App\InfinityTypeTube;
use App\Label;
use App\Loinc;
use App\MainAnalyte;
use App\MainAnalyteSampleContainer;
use App\MedicalOrder;
use App\Method;
use App\QuantitySample;
use App\ReferenceRange;
use App\Sample;
use App\SampleCollectionMethod;
use App\SampleCondition;
use App\Section;
use App\Test;
use App\TimeProcess;
use App\TimeReception;
use App\TimeResponse;
use App\Unit;
use App\User;
use App\VihKey;
use App\Workarea;
use Illuminate\Http\Request;

class SyncTablesController extends Controller
{
  public function sections()
  {
    $sections = Section::orderBy('id')->get();
    return response()->json($sections);
  }

  public function users()
  {
    $users = User::orderBy('id')->get();
    return response()->json($users);
  }

  public function workareas()
  {
    $workareas = Workarea::orderBy('id')
      ->get();
    return response()->json($workareas);
  }

  public function vihKeys()
  {
    $vihKeys = VihKey::orderBy('id')
      ->get();

    return response()->json($vihKeys);
  }

  public function units()
  {

    $units = Unit::orderBy('id')
      ->get();

    return response()->json($units);
  }

  public function availables()
  {

    $availables = Available::orderBy('id')
      ->get();

    return response()->json($availables);
  }

  public function collectionMethods()
  {
    $collectionMethods = CollectionMethod::orderBy('id')
      ->get();

    return response()->json($collectionMethods);
  }

  public function containers()
  {
    $containers = Container::orderBy('id')
      ->get();

    return response()->json($containers);
  }


  public function genders()
  {
    $genders = Gender::orderBy('id')
      ->get();

    return response()->json($genders);
  }


  public function indications()
  {
    $indications = Indication::orderBy('id')
      ->get();

    return response()->json($indications);
  }

  public function labels()
  {
    $labels = Label::orderBy('id')
      ->get();

    return response()->json($labels);
  }

  public function mainAnalytes()
  {
    $mainAnalytes = MainAnalyte::orderBy('id')
      ->get();

    return response()->json($mainAnalytes);
  }

  public function medicalOrders()
  {
    $medicalOrders = MedicalOrder::orderBy('id')
      ->get();

    return response()->json($medicalOrders);
  }

  public function methods()
  {
    $methods = Method::orderBy('id')
      ->get();

    return response()->json($methods);
  }

  public function quantitySamples()
  {
    $quantitySamples = QuantitySample::orderBy('id')
      ->get();

    return response()->json($quantitySamples);
  }


  public function samples()
  {
    $samples = Sample::orderBy('id')
      ->get();

    return response()->json($samples);
  }

  public function sampleConditions()
  {
    $sampleConditions = SampleCondition::orderBy('id')
      ->get();

    return response()->json($sampleConditions);
  }

  public function timeProcesses()
  {
    $timeProcesses = TimeProcess::orderBy('id')
      ->get();

    return response()->json($timeProcesses);
  }

  public function timeReceptions()
  {
    $timeReceptions = TimeReception::orderBy('id')
      ->get();

    return response()->json($timeReceptions);
  }

  public function timeResponses()
  {
    $timeResponses = TimeResponse::orderBy('id')
      ->get();

    return response()->json($timeResponses);
  }


  public function ageUnits()
  {
    $ageUnits = AgeUnit::orderBy('id')
      ->get();

    return response()->json($ageUnits);
  }

  public function hcaLaboratories()
  {
    $hcaLaboratories = HcaLaboratory::orderBy('id')
      ->get();

    return response()->json($hcaLaboratories);
  }

  public function fonasaTests()
  {
    $fonasaTests = FonasaTest::orderBy('id')
      ->get();

    return response()->json($fonasaTests);
  }

  public function loincs()
  {
    ini_set('memory_limit', '-1');
    $loincs = Loinc::orderBy('id')
      ->get();

    return response()->json($loincs);
  }

  public function infinityLabdateTests()
  {
    $infinityLabdateTests = InfinityLabdateTest::orderBy('id')
      ->get();

    return response()->json($infinityLabdateTests);
  }


  public function analytes()
  {
    $analytes = Analyte::orderBy('id')
      ->get();

    return response()->json($analytes);
  }

  public function analyteIndications()
  {
    $analyteIndications = AnalyteIndication::orderBy('id')
      ->get();

    return response()->json($analyteIndications);
  }


  public function analyteLabels()
  {
    $analyteLabels = AnalyteLabel::orderBy('id')
      ->get();

    return response()->json($analyteLabels);
  }

  public function analyteSampleConditions()
  {
    $analyteSampleConditions = AnalyteSampleCondition::orderBy('id')
      ->get();

    return response()->json($analyteSampleConditions);
  }

  public function analyteTests()
  {
    $analyteTests = AnalyteTests::orderBy('id')
      ->get();

    return response()->json($analyteTests);
  }

  public function infinitySupergroup()
  {
    $infinitySupergroups = InfinitySupergroup::orderBy('id')
      ->get();

    return response()->json($infinitySupergroups);
  }
  public function infinityGroup()
  {
    $infinityGroup = InfinityGroup::orderBy('id')
      ->get();

    return response()->json($infinityGroup);
  }

  public function infinityRelGroupTest()
  {
    $infinityRelGroupTests = InfinityRelGroupTest::orderBy('id')
      ->get();

    return response()->json($infinityRelGroupTests);
  }


  public function infinitySample()
  {
    $infinitySamples = InfinitySample::orderBy('id')
      ->get();

    return response()->json($infinitySamples);
  }

  public function infinityTest()
  {
    $infinityTests = InfinityTest::orderBy('id')
      ->get();

    return response()->json($infinityTests);
  }

  public function infinityTypeTube()
  {
    $infinityTypeTubes = InfinityTypeTube::orderBy('id')
      ->get();

    return response()->json($infinityTypeTubes);
  }

  public function mainAnalyteSampleContainer()
  {
    $mainAnalyteSampleContainers = MainAnalyteSampleContainer::orderBy('id')
      ->get();

    return response()->json($mainAnalyteSampleContainers);
  }

  public function referenceRange()
  {
    $referenceRanges = ReferenceRange::orderBy('id')
      ->get();

    return response()->json($referenceRanges);
  }

  public function sampleCollectionMethod()
  {
    $sampleCollectionMethods = SampleCollectionMethod::orderBy('id')
      ->get();

    return response()->json($sampleCollectionMethods);
  }


  public function test()
  {
    $tests = Test::orderBy('id')
      ->get();

    return response()->json($tests);
  }
}
