<?php

namespace App\Http\Controllers\ControllerManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticsCovidController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
  
    public function page()
    {
  
      return view('management.statisticsCovid');
    }
}
