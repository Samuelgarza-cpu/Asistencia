<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if(session('user_agent')=='TrSo')
            return redirect('solicitudes');
        elseif(session('user_agent')=='Soport')
            return redirect('muebles');
        else
            return redirect('dashboard');
    }
}
