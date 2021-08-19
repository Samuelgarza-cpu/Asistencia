<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Luecano\NumeroALetras\NumeroALetras;

class numeroletracontroller extends Controller
{
    public function index(){
        $number= 5000;
        $currency = "pesos MXN";
        $formatter = NumeroALetras::convert($number, $currency, true);
        return $formatter;

    }

}
