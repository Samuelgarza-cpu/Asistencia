<?php

namespace App\Http\Controllers\Inside;

use DateTime;
use App\Models\EmailLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailLogController extends Controller
{
    public function index(){

        $emailerrors=EmailLog::all();
        
        $data = array(
            'emailerrors' => $emailerrors,
            // 'chart' => $prueba
        );
        //dd($data);
        return view('catalogs.emaillog', $data);
    }

    public function emails(Request $request)
    {
        switch($request->input('action')){
            case "query":
                $emails=EmailLog::all();
                $count = 1;
                foreach ($emails as $value) 
                {
                    $value->number = $count++;
                    $date = new DateTime($value->created_at);
                    $value->date = $date->format('d-m-Y H:m:s');
                }
                return $emails;
            break;
            default:
            break;
        }
    }
}