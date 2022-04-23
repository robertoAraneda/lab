<?php

namespace App\Http\Controllers;

use App\Analyte;
use App\Exports\AnalyteExport;
use App\Exports\SampleExport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DownloadFileController extends Controller
{
    public function export()
    {

        $date = Carbon::now()->format('d-m-Y');

        $formatDate = explode("-", $date);

        $nameFile = "LABORATORIOHOSPITALHERNANHENRIQUEZARAVENA_EXAMENES_VERSION_GLOBAL_" . $formatDate[0] . "" . $formatDate[1] . "" . $formatDate[2];

        return (new AnalyteExport())->download($nameFile . ".xlsx", \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }
    

    public function exportSampleAnalyte()
    {

        $date = Carbon::now()->format('d-m-Y');

        $formatDate = explode("-", $date);

        $nameFile = "LABORATORIOHOSPITALHERNANHENRIQUEZARAVENA_EXAMENES_VERSION_TM_" . $formatDate[0] . "" . $formatDate[1] . "" . $formatDate[2];

        return (new SampleExport())->download($nameFile . ".xlsx", \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);

    }

}
