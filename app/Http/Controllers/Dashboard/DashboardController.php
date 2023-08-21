<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Requisition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if(session('user_agent') == "Admin"){
            $requests = Requisition::all();
            $sPAA = $requests->where('status_id', '=',1)->count();
            $sAPV = $requests->where('status_id','=',2)->count();
            $sAPF = $requests->where('status_id','=',3)->count();
            $sR = $requests->where('status_id','=',4)->count();
            $sF = $requests->where('status_id','=',5)->count();
            $sC = $requests->where('status_id','=',7)->count();
            

            $sT = $requests->count();
            $sT1 = $requests->where('type','=','ts')->count();
            $sT2 = $requests->where('type','=','responsiva')->count();        
            $sT3 = $requests->where('type','=','foliado')->count();        
            $sT4 = $requests->where('type','=','solicitud')->count();        
        }
        else{
            $requests = Requisition::where('departments_institutes_id','=', session('department_institute_id'))->get();
            if($requests != null && $requests->count() > 0){
                $sPAA = $requests->where('status_id', '=',1)->count();
                $sAPV = $requests->where('status_id','=',2)->count();
                $sAPF = $requests->where('status_id','=',3)->count();
                $sR = $requests->where('status_id','=',4)->count();
                $sF = $requests->where('status_id','=',5)->count();
                $sC = $requests->where('status_id','=',7)->count();
                
                $sT = $requests->count();
                $sT1 = $requests->where('type','=','ts')->count();
                $sT2 = $requests->where('type','=','responsiva')->count();        
                $sT3 = $requests->where('type','=','foliado')->count();       
                $sT4 = $requests->where('type','=','solicitud')->count();       
            }
            else{
                $sPAA = 0;
                $sAPV = 0;
                $sAPF = 0;
                $sR = 0;
                $sF = 0;
                $sC = 0;

                $sT = 0;
                $sT1 = 0;
                $sT2 = 0;
                $sT3 = 0;
                $sT4 = 0;
            }
        }
        $data = array(
            'sPAA' => $sPAA,
            'sAPV' => $sAPV,
            'sAPF' => $sAPF,
            'sR' => $sR,
            'sF' => $sF,
            'sC' => $sC,
            'sT' => $sT,
            'sT1' => $sT1,
            'sT2' => $sT2,
            'sT3' => $sT3,
            'sT4' => $sT4
        );
        return view('catalogs.dashboard', $data);
    }
}
