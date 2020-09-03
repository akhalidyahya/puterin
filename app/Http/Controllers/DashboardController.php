<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bigmenu = 'dashboard';
        return view('pages/dashboard',[
            'sidebar'=>'dashboard',
            'bigmenu'=>$bigmenu
        ]);
    }
}
