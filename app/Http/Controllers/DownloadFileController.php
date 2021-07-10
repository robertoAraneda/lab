<?php

namespace App\Http\Controllers;

use App\Exports\AnalyteExport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DownloadFileController extends Controller
{
    public function export()
    {

        $date = Carbon::now()->format('d-m-Y');

        $formatDate = explode("-", $date);

        $nameFile = "LABORATORIOHOSPITALHERNANHENRIQUEZARAVENA_EXAMENES_" . $formatDate[0] . "" . $formatDate[1] . "" . $formatDate[2];

        return (new AnalyteExport())->download($nameFile . ".xlsx", \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }

}
