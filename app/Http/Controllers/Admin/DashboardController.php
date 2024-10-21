<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('index_admin');
    }
    public function unath_403(){
        return view('errors.unoth');
    }
  
}
