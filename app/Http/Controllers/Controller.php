<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function indexSettings()
    {
       return view('settings');
    }

}
