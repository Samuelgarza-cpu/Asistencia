<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class CacheController extends Controller
{
    public function setCookie($ecript = ''){
        //  $cokiename=response()->cookie('CName','SOY LA EL NOMBRE',5);
        //  $cokiepass=response()->cookie('CPass','SOY LA CONTRASEÑA',5);

        return redirect('home')->cookie('CName',session('nameuser'),5)->cookie('CPass',$ecript,5);

    }
    public function getCookie(Request $request){
        //$cookie_leida = $request->cookie('cookie1');
        $data = array(
            'CName' => $request->cookie('CName'),
            'CPass' => $request->cookie('CPass')
        );
        //dd($data);

    }
}
