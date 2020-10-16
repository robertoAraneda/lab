<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Exports\MinsalExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadFileController extends Controller
{
    public function export(){
        return (new MinsalExport())->download('minsal_export.csv', \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);;
    }
}
