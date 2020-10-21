<?php

namespace App\Http\Controllers\ControllerStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function page()
    {

        return view('store.dashboard');
    }
}
