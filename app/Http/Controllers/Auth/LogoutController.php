<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /**
         * Cerramos la sessión y automaticamente se eliminan las variables de sessión
         * lo redireccionamos al login
         */
        Auth::logout();
        return redirect()->intended('/');
    }
}
