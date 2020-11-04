<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use App\ModelManagement\MinsalStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowResultDayController extends Controller
{
  public function getAllRequestSamples()
  {
    $requests = MinsalStatistic::all();

    $diffArray['detail'] = [];
    foreach ($requests as $value) {

      $diff = $this->getDiffDays($value->sampled_at, $value->notified_at, $value->id);

      if (isset($diff)) {
        if ($diff->diff < 0) {
          $diffArray['error'][] = $diff->id_testing_request;
        } else {

          $index = round($diff->diff);

          switch ($index) {
            case 0:
              !isset($diffArray['detail'][0]) ? $diffArray['detail'][0] = 1 : $diffArray['detail'][0] += 1;

              break;
            case 1:
              !isset($diffArray['detail'][1]) ? $diffArray['detail'][1] = 1 : $diffArray['detail'][1] += 1;

              break;
            case 2:
              !isset($diffArray['detail'][2]) ? $diffArray['detail'][2] = 1 : $diffArray['detail'][2] += 1;

              break;
            case 3:
              !isset($diffArray['detail'][3]) ? $diffArray['detail'][3] = 1 : $diffArray['detail'][3] += 1;

              break;

            default:
              !isset($diffArray['detail']['mas']) ? $diffArray['detail']['mas'] = 1 : $diffArray['detail']['mas'] += 1;
              break;
          }
        }
      }
    }

    return $diffArray;
  }

  public function getTATReceivedNotified($date)
  {
    $requests = MinsalStatistic::where('received_at', 'like', $date . "%")->orderBy('received_at', 'asc')->get();

    $diffArray['detail'] = [];

    foreach ($requests as $value) {

      $diffArray['detail'][] = [
        "floatDiffInHours" => $this->floatDiffInHoursCarbon($value->received_at, $value->notified_at),
        "diffInMinutes" => $this->diffInMinutesCarbon($value->received_at, $value->notified_at),
        "diff" => $this->diffCarbon($value->received_at, $value->notified_at),
        'id_testing_request' => $value->id_testing_request,
        'professional_validator' => $value->professional_validator,
        'processing_laboratory' => $value->processing_laboratory,
        'sampled_at' => $value->sampled_at,
        'received_at' => $value->received_at,
        'validated_at' => $value->validated_at,
        'notified_at' => $value->notified_at,
        'rejected_at' => $value->rejected_at,
        'distributed_at' => $value->distributed_at,
      ];
    }

    $collect = collect($diffArray['detail']);

    $data = [];

    $value = $collect->groupBy('received_at');
    $current = Carbon::parse($date . "00:00:00");

    for ($i = 0; $i < 1440; $i++) {

      if (isset($value[$current->format('Y-m-d H:i:s')])) {
        $data[] = [
          "x" => $current->format('H:i'),
          "y" => count($value[$current->format('Y-m-d H:i:s')])
        ];
      } else {
        $data[] = [
          "x" => $current->format('H:i'),
          "y" => 0
        ];
      }
      $current->addMinute();
    }

    return [
      'data' => $collect->sortBy('diffInMinutes')->values()->all(),
      'analitycs' => [
        'min' => $collect->min('diffInMinutes'),
        'max' => $collect->max('diffInMinutes'),
        'median' => $collect->median('diffInMinutes'),
        'count' => count($collect)
      ],
      'dataSet' =>  $data
    ];

    return $diffArray;
  }



  public function getTATValidated($date)
  {
    $requests = MinsalStatistic::where('validated_at', 'like', $date . "%")
      ->where('processing_laboratory', 'LABORATORIO HHHA')
      ->orderBy('validated_at', 'asc')
      ->get();

    $diffArray['detail'] = [];

    foreach ($requests as $value) {

      $diffArray['detail'][] = [
        "floatDiffInHours" => $this->floatDiffInHoursCarbon($value->received_at, $value->notified_at),
        "diffInMinutes" => $this->diffInMinutesCarbon($value->received_at, $value->notified_at),
        "diff" => $this->diffCarbon($value->received_at, $value->notified_at),
        'id_testing_request' => $value->id_testing_request,
        'professional_validator' => $value->professional_validator,
        'processing_laboratory' => $value->processing_laboratory,
        'sampled_at' => $value->sampled_at,
        'received_at' => $value->received_at,
        'validated_at' => Carbon::parse($value->validated_at)->format('Y-m-d H:i') . ":00",
        'notified_at' => $value->notified_at,
        'rejected_at' => $value->rejected_at,
        'distributed_at' => $value->distributed_at,
      ];
    }

    $collect = collect($diffArray['detail']);

    $data = [];

    $value = $collect->groupBy('validated_at');
    $current = Carbon::parse($date . "00:00:00");

    for ($i = 0; $i < 1440; $i++) {

      if (isset($value[$current->format('Y-m-d H:i:s')])) {
        $data[] = [
          "x" => $current->format('H:i'),
          "y" => count($value[$current->format('Y-m-d H:i:s')])
        ];
      } else {
        $data[] = [
          "x" => $current->format('H:i'),
          "y" => 0
        ];
      }
      $current->addMinute();
    }

    return [
      'data' => $collect->sortBy('diffInMinutes')->values()->all(),
      'analitycs' => [
        'min' => $collect->min('diffInMinutes'),
        'max' => $collect->max('diffInMinutes'),
        'median' => $collect->median('diffInMinutes'),
        'count' => count($collect)
      ],
      'dataSet' =>  $data
    ];

    return $diffArray;
  }


  private function getDiffDays($date1, $date2, $id)
  {

    $diff = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw("DATEDIFF('" . Carbon::parse($date2)->format('Y-m-d H:i:s') . "','" . Carbon::parse($date1)->format('Y-m-d H:i:s') . "') as diff, id_testing_request"))
      ->where('id', $id)
      ->where('status', 'RESUELTO')
      ->where('sampled_at', '2020-10-30')
      ->groupBy('diff')
      ->get()->first();

    return $diff;
  }

  private function getDiffHours($date1, $date2, $id)
  {

    $diff = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw("TIMEDIFF('" . Carbon::parse($date2)->format('Y-m-d H:i:s') . "','" . Carbon::parse($date1)->format('Y-m-d H:i:s') . "') as diff, id_testing_request"))
      ->where('id', $id)
      ->where('status', 'RESUELTO')
      ->where('received_at', 'like', '2020-10-30%')
      ->groupBy('diff')
      ->get()->first();

    return $diff;
  }

  private function floatDiffInHoursCarbon($date1, $date2)
  {

    $initial = Carbon::parse($date1);
    $final = Carbon::parse($date2);

    return round($initial->floatDiffInHours($final), 2);
  }

  private function diffInMinutesCarbon($date1, $date2)
  {

    $initial = Carbon::parse($date1);
    $final = Carbon::parse($date2);

    return round($initial->diffInMinutes($final), 2);
  }
  private function diffCarbon($date1, $date2)
  {

    $initial = Carbon::parse($date1);
    $final = Carbon::parse($date2);

    return $initial->diff($final)->format('%H:%I:%S');
  }
}
