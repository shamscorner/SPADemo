<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    /**
    * Author: shamscorner
    * DateTime: 30/September/2019 - 02:34:00
    *
    * view the page spa
    *
    */
    public function index()
    {
        return view('spa');
    }
}
