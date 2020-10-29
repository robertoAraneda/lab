<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\MinsalStatisticImport;
use App\ModelManagement\MinsalDetail;
use App\ModelManagement\MinsalStatistic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UploadFileController extends Controller

{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function page()
  {
    return view('management.uploadFile');
  }

  public function fileSubmit(Request $request)
  {

    $upload_path = storage_path('app');
    $file_name = $request->file->getClientOriginalName();
    $generated_new_name = 'full_covid.' . $request->file->getClientOriginalExtension();
    $request->file->move($upload_path,  $generated_new_name);

    $collection = (new MinsalStatisticImport)
      ->toCollection(storage_path('app/full_covid.xlsx'));


    $array = [];
    foreach ($collection as $value) {
      foreach ($value as $key) {
        $array[] = array(
          'id_testing_request' => $key[1],
          'sample' => $key[6],
          'result' => $key[7],
          'status' => $key[8],
          'professional_validator' => $key[9],
          'rejection_reason' => $key[16],
          'sending_institution' => $key[17],
          'processing_laboratory' => $key[18],
          'requesting_doctor' => $key[19],
          'patient_rut' => $key[2],
          'patient_name' => $key[3],
          'patient_gender' => $key[4],
          'patient_age' => $key[5],
          'patient_phone' => $key[20],
          'patient_email' => $key[21],
          'patient_comuna' => $key[22],
          'patient_address' => $key[23],
          'institution_region' => $key[24],
          'clasification' => $key[25],
          'sampled_at' => $key[10],
          'received_at' => $key[11],
          'validated_at' => $key[13],
          'notified_at' => $key[14],
          'rejected_at' => $key[15],
          'distributed_at' => $key[12]
        );
      }
    }

    $minsalCollection = array_slice($array, 1, count($array) - 1);

    // Storage::delete('upload_student.xlsx');

    // return new MinsalExport($minsalCollection);

    DB::connection('mysqlGestion')->table('minsal_statistics')->truncate();
    DB::connection('mysqlGestion')->table('minsal_details')->truncate();


    foreach ($minsalCollection as $key) {

      $this->storeStatistic($key);

      if (strcmp($key['status'], "RESUELTO") == 0) {
        $date = Carbon::parse($this->transformDate($key['notified_at']));

        // return response()->json($this->transformDate($key['notified_at']));

        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $subDay = Carbon::now()->subDay()->format('Y-m-d H:i:s');

        $splitDate = explode(" ", $currentDate);
        $splitSubDay = explode(" ", $subDay);

        $limitDateUp = Carbon::parse("{$splitDate[0]} 15:59");
        $limitDateDown = Carbon::parse("{$splitSubDay[0]} 16:00");

        $isBetween = $date->between($limitDateDown, $limitDateUp);

        if ($isBetween) {
          $this->storeMinsalDetail($key);
        }
      }
    }

    $uploadController = new UploadHistoryController();

    $fileName = $request->file->getClientOriginalName();

    $data = array('file_name' => $fileName, 'ip' => $request->ip());

    $uploadController->store($data);

    return response()->json(['created_at' => Carbon::now()->format('d/m/Y H:i'), 'file_name' => $data], 200);

    /*   return $minsalCollection;

    return Excel::download($export, 'invoices.csv'); */
  }

  private function storeStatistic($key)
  {
    $minsalStatistic = new MinsalStatistic();

    $minsalStatistic->sample = $key['sample'];
    $minsalStatistic->id_testing_request = $key['id_testing_request'];
    $minsalStatistic->result = $key['result'];
    $minsalStatistic->status = $key['status'];
    $minsalStatistic->professional_validator = $key['professional_validator'];
    $minsalStatistic->rejection_reason = $key['rejection_reason'];
    $minsalStatistic->sending_institution = $key['sending_institution'];
    $minsalStatistic->processing_laboratory = $key['processing_laboratory'];
    $minsalStatistic->requesting_doctor = $key['requesting_doctor'];
    $minsalStatistic->patient_rut = $key['patient_rut'];
    $minsalStatistic->patient_name = $key['patient_name'];
    $minsalStatistic->patient_gender = $key['patient_gender'];
    $minsalStatistic->patient_age = $key['patient_age'];
    $minsalStatistic->patient_phone = $key['patient_phone'];
    $minsalStatistic->patient_email = $key['patient_email'];
    $minsalStatistic->patient_comuna = $key['patient_comuna'];
    $minsalStatistic->patient_address = $key['patient_address'];
    $minsalStatistic->institution_region = $key['institution_region'];
    $minsalStatistic->clasification = $key['clasification'];
    $minsalStatistic->sampled_at = $this->transformDate($key['sampled_at']);
    $minsalStatistic->received_at = $this->transformDate($key['received_at']);
    $minsalStatistic->validated_at = $this->transformDate($key['validated_at']);
    $minsalStatistic->notified_at = $this->transformDate($key['notified_at']);
    $minsalStatistic->rejected_at = $this->transformDate($key['rejected_at']);
    $minsalStatistic->distributed_at = $this->transformDate($key['distributed_at']);
    $minsalStatistic->save();
  }

  private function storeMinsalDetail($key)
  {
    $minsalDetail = new MinsalDetail();

    $minsalDetail->patient_rut = $this->transformRut($key['patient_rut']);
    $minsalDetail->patient_name = $this->cleanName($key['patient_name']);
    $minsalDetail->patient_gender = $this->transformGender($key['patient_gender']);
    $minsalDetail->patient_age = $key['patient_age'];
    $minsalDetail->patient_phone = $key['patient_phone'];
    $minsalDetail->patient_email = $key['patient_email'];
    $minsalDetail->patient_address = $key['patient_address'];
    $minsalDetail->sample = $key['sample'];
    $minsalDetail->result = $this->transformResult($key['result']);
    $minsalDetail->sampled_at = $this->splitDate($key['sampled_at']);
    $minsalDetail->received_at = $this->splitDate($key['received_at']);
    $minsalDetail->validated_at = $this->splitDate($key['notified_at']);
    $minsalDetail->requesting_institution_name = $key['sending_institution'];
    $minsalDetail->requesting_institution_region = $key['institution_region'];
    $minsalDetail->processing_laboratory_region = $key['institution_region'];
    $minsalDetail->processing_laboratory_name = $key['processing_laboratory'];

    $minsalDetail->save();
  }

  private function transformRut($rut)
  {

    if (!isset($rut)) {
      return '';
    } else {
      $contains = Str::contains($rut, '-');

      if ($contains) {
        $formatedRut = str_replace('-', "", $rut);

        return $formatedRut;
      }
    }
  }

  private function splitDate($date)
  {

    if (!isset($date)) {
      return null;
    } else {
      $formatedDate = str_replace('/', "-", $date);
      $splitDate = explode(" ", $formatedDate);

      if (count($splitDate) == 2) {
        return $splitDate[0];
      } else {
        return $formatedDate;
      }
    }
  }

  private function transformDate($date)
  {
    if (!isset($date)) {
      return null;
    } else {
      $contains = Str::contains($date, '/');

      if ($contains) {
        $formatedDate = str_replace('/', "-", $date);

        $splitDate = explode(" ", $formatedDate);

        if (count($splitDate) == 2) {
          $explodeDate = explode("-", $splitDate[0]);
          return "{$explodeDate[2]}-{$explodeDate[1]}-{$explodeDate[0]} {$splitDate[1]}";
        } else {
          $explodeDate = explode("-", $formatedDate);
          return "{$explodeDate[2]}-{$explodeDate[1]}-{$explodeDate[0]}";
        }
      }
    }
  }

  private function cleanName($name)
  {
    if (!isset($name)) {
      return null;
    } else {

      $letters = ['Á', 'É', 'Í', 'Ó', 'Ú'];
      $replace = ['A', 'E', 'I', 'O', 'U'];

      $upperName = Str::upper($name);

      for ($i = 0; $i < count($replace); $i++) {
        $upperName = str_replace($letters[$i], $replace[$i], $upperName);
      }

      return $upperName;
    }
  }

  private function transformGender($gender)
  {
    if (!isset($gender)) {
      return null;
    } else {
      switch ($gender) {
        case 'MASCULINO':
          return 'Hombre';
          break;
        case 'FEMENINO':
          return 'Mujer';
          break;
        default:
          return '';
          break;
      }
    }
  }

  private function transformResult($result)
  {
    if (!isset($result)) {
      return null;
    } else {
      switch ($result) {
        case 'NEGATIVO':
          return 'Negativo';
          break;
        case 'POSITIVO':
          return 'Positivo';
          break;
        case 'NO CONCLUYENTE. SE SOLICITA NUEVA MUESTRA.':
          return 'Requiere nueva muestra';
          break;
        default:
          return '';
          break;
      }
    }
  }
}
