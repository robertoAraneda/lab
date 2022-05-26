<?php

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

//Route::middleware('auth:api')->get('/test', function (Request $request) {
//    return $request->test();
//});

Route::group(['prefix' => 'sync'], function () {
  Route::get('/section', 'ControllerBack\SyncTablesController@sections');
  Route::get('/user', 'ControllerBack\SyncTablesController@users');
  Route::get('/workarea', 'ControllerBack\SyncTablesController@workareas');
  Route::get('/vih-key', 'ControllerBack\SyncTablesController@vihKeys');
  Route::get('/unit', 'ControllerBack\SyncTablesController@units');
  Route::get('/available', 'ControllerBack\SyncTablesController@availables');
  Route::get('/collection-method', 'ControllerBack\SyncTablesController@collectionMethods');
  Route::get('/container', 'ControllerBack\SyncTablesController@containers');
  Route::get('/gender', 'ControllerBack\SyncTablesController@genders');
  Route::get('/indication', 'ControllerBack\SyncTablesController@indications');
  Route::get('/label', 'ControllerBack\SyncTablesController@labels');
  Route::get('/main-analyte', 'ControllerBack\SyncTablesController@mainAnalytes');
  Route::get('/medical-order', 'ControllerBack\SyncTablesController@medicalOrders');
  Route::get('/method', 'ControllerBack\SyncTablesController@methods');
  Route::get('/quantity-sample', 'ControllerBack\SyncTablesController@quantitySamples');
  Route::get('/sample', 'ControllerBack\SyncTablesController@samples');
  Route::get('/sample-condition', 'ControllerBack\SyncTablesController@sampleConditions');
  Route::get('/time-process', 'ControllerBack\SyncTablesController@timeProcesses');
  Route::get('/time-reception', 'ControllerBack\SyncTablesController@timeReceptions');
  Route::get('/time-response', 'ControllerBack\SyncTablesController@timeResponses');
  Route::get('/age-unit', 'ControllerBack\SyncTablesController@ageUnits');
  Route::get('/hca-laboratory', 'ControllerBack\SyncTablesController@hcaLaboratories');
  Route::get('/fonasa-test', 'ControllerBack\SyncTablesController@fonasaTests');
  Route::get('/loinc', 'ControllerBack\SyncTablesController@loincs');
  Route::get('/infinity-labdate-test', 'ControllerBack\SyncTablesController@infinityLabdateTests');
  Route::get('/analyte', 'ControllerBack\SyncTablesController@analytes');
  Route::get('/analyte-indication', 'ControllerBack\SyncTablesController@analyteIndications');
  Route::get('/analyte-label', 'ControllerBack\SyncTablesController@analyteLabels');
  Route::get('/analyte-sample-condition', 'ControllerBack\SyncTablesController@analyteSampleConditions');
  Route::get('/analyte-test', 'ControllerBack\SyncTablesController@analyteTests');
  Route::get('/infinity-super-group', 'ControllerBack\SyncTablesController@infinitySupergroup');
  Route::get('/infinity-group', 'ControllerBack\SyncTablesController@infinityGroup');
  Route::get('/infinity-rel-group-test', 'ControllerBack\SyncTablesController@infinityRelGroupTest');
  Route::get('/infinity-sample', 'ControllerBack\SyncTablesController@infinitySample');
  Route::get('/infinity-test', 'ControllerBack\SyncTablesController@infinityTest');
  Route::get('/infinity-type-tube', 'ControllerBack\SyncTablesController@infinityTypeTube');
  Route::get('/main-analyte-sample-container', 'ControllerBack\SyncTablesController@mainAnalyteSampleContainer');
  Route::get('/reference-range', 'ControllerBack\SyncTablesController@referenceRange');
  Route::get('/sample-collection-method', 'ControllerBack\SyncTablesController@sampleCollectionMethod');
  Route::get('/test', 'ControllerBack\SyncTablesController@test');
});


Route::apiResource('/v1/user', 'UserController')->names('api.user');