<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TracingLaboratoryRequest extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
  
    public function page()
    {
  
      return view('management.tracingLaboratoryRequest');
    }

   public function getInProcessRequest(){
    $currentDate = Carbon::now()->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $lastDay = "{$currentDate} 15:59";
    $last5Days = "{$sub5Days} 16:00";

    $inProcess = DB::connection('mysqlGestion')
    ->table('minsal_statistics')
    ->where('status', 'EN PROCESO')
    ->whereBetween('received_at', [$last5Days, $lastDay])
    ->get();

    return [
      'init' => $last5Days,
      'last' => $lastDay,
      'inProcess' => $inProcess
    ];
   }

   public function getReceivedRequest(){
    $currentDate = Carbon::now()->format('Y-m-d');
    $sub5Days = Carbon::now()->subDays(5)->format('Y-m-d');

    $lastDay = "{$currentDate} 15:59";
    $last5Days = "{$sub5Days} 16:00";

    $received = DB::connection('mysqlGestion')
    ->table('minsal_statistics')
    ->where('status', 'RECEPCIONADA')
    ->whereBetween('received_at', [$last5Days, $lastDay])
    ->get();

    return [
      'init' => $last5Days,
      'last' => $lastDay,
      'received' => $received
    ];
   }
}
