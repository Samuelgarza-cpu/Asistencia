<?php

namespace App\Http\Controllers\Errors;

use DateTime;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorsLogController extends Controller
{
    public function index(){

        $errors=ErrorLog::all();
        
        $data = array(
            'errors' => $errors,
            // 'chart' => $prueba
        );
        //dd($data);
        return view('errors.errorslog', $data);
    }

    public function errors(Request $request)
    {
        switch($request->input('action')){
            case "query":
                $errors=ErrorLog::all();
                $count = 1;
                foreach ($errors as $value) 
                {
                    $value->number = $count++;
                    $date = new DateTime($value->created_at);
                    $value->date = $date->format('d-m-Y H:m:s');
                }
                return $errors;
            break;
            default:
            break;
        }
    }
}
