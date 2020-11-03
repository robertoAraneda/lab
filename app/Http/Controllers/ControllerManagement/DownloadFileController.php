<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Exports\MinsalExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DownloadFileController extends Controller
{

  public function page()
  {
    return view('management.exportHHHA');
  }

  public function export()
  {

    $date = Carbon::now()->format('d-m-Y');

    $formatDate = explode("-", $date);

    $nameFile = "LABORATORIOHOSPITALHERNANHENRIQUEZARAVENA_" . $formatDate[0] . "" . $formatDate[1] . "" . $formatDate[2] . "_1600";

    return (new MinsalExport())->download($nameFile . ".xlsx", \Maatwebsite\Excel\Excel::XLSX, [
      'Content-Type' => 'application/vnd.ms-excel',
    ]);;
  }
}
