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

    //return $requests;

    $diffArray['detail'] = [];


    foreach ($requests as $value) {


      $diffArray['global'][] = $this->getDiffDays($value->sampled_at, $value->notified_at, $value->id);
      $diff = $this->getDiffDays($value->sampled_at, $value->notified_at, $value->id);

      if (isset($diff)) {
        if ($diff->diff < 0) {
          $diffArray['error'][] = $diff->id_testing_request;
        } else {

          $index = round($diff->diff);

          return $index;

          switch ($index) {
            case 0:
              !isset($diffArray['detail'][0]) ? $diffArray['detail'][0] = 1 : $diffArray['detail'][0] += 1;
              # code...
              break;
            case 1:
              !isset($diffArray['detail'][1]) ? $diffArray['detail'][1] = 1 : $diffArray['detail'][1] += 1;
              # code...
              break;
            case 2:
              !isset($diffArray['detail'][2]) ? $diffArray['detail'][2] = 1 : $diffArray['detail'][2] += 1;
              # code...
              break;
            case 3:
              !isset($diffArray['detail'][3]) ? $diffArray['detail'][3] = 1 : $diffArray['detail'][3] += 1;
              # code...
              break;

            default:
              !isset($diffArray['detail']['mas']) ? $diffArray['detail']['mas'] = 1 : $diffArray['detail']['mas'] += 1;
              break;
          }
        }
      }
    }

    return $diffArray['detail'];

    $collection = collect($diffArray['detail']);
    /*    $diffArray['group'] = $collection->groupBy('diff')->map(function ($value, $key) {
      return $value[$key] = count($value);
    }); */

    return $collection;
    $keys = $diffArray['group']->keys();

    $keys->all();

    // return $collection->pluck('diff');
    return $keys;
  }

  private function getDiffDays($date1, $date2, $id)
  {

    $diff = DB::connection('mysqlGestion')->table('minsal_statistics')
      ->select(DB::raw("DATEDIFF('" . Carbon::parse($date2)->format('Y-m-d H:i:s') . "','" . Carbon::parse($date1)->format('Y-m-d H:i:s') . "') as diff, id_testing_request"))
      ->where('id', $id)
      ->where('status', 'RESUELTO')
      ->where('sampled_at', '2020-10-23')
      ->groupBy('diff')
      ->get()->first();

    return $diff;
  }
}
