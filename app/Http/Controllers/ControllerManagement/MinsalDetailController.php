<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use App\ModelManagement\MinsalDetail;
use Illuminate\Http\Request;

class MinsalDetailController extends Controller
{
  public function index()
  {
    return response()->json(MinsalDetail::where('processing_laboratory_name', 'LABORATORIO HHHA')->get());
  }
}
