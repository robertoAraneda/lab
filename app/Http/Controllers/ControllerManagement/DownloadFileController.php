<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Exports\MinsalExport;
use App\Exports\PresidencyConsolidateExport;
use App\Http\Controllers\Controller;
use App\ModelManagement\PresidencyConsolidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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

    $nameFile = "LABORATORIOHOSPITALHERNANHENRIQUEZARAVENA_" . $formatDate[0] . "" . $formatDate[1] . "" . $formatDate[2] . "_1900";

    return (new MinsalExport())->download($nameFile . ".xlsx", \Maatwebsite\Excel\Excel::XLSX, [
      'Content-Type' => 'application/vnd.ms-excel',
    ]);
  }

  public function exportPresidency()
  {
    $date = Carbon::now();

    $formatDate = explode("-", $date->format('d-m-y'));

    $nameFile = "Reporte_Presidencia_LAB_HHHA_" . $formatDate[0] . "_" . $formatDate[1] . "_" . $formatDate[2];

    return (new PresidencyConsolidateExport($date->format('Y-m-d')))->download($nameFile . ".xlsx", \Maatwebsite\Excel\Excel::XLSX, [
      'Content-Type' => 'application/vnd.ms-excel',
    ]);
  }
}
