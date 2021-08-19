<?php

namespace App\Http\Controllers\Inside;

use App\Events\Postevent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\recuperarcontraseña;
use App\Mail\solicitudcreada;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class emailcontroller extends Controller
{
    public function create(){

        Mail::to('cuentabusiness50@gmail.com')->send(new solicitudcreada());
        return redirect()->back()->with('mensaje','SE ENVIO EL MENSAJE');

    }
    public function notificaciones(){
     
      Mail::to('cuentabusiness50@gmail.com')->send(new solicitudcreada());
      $usuarios=User::all();
      event(new Postevent($usuarios));
      return redirect('solicitudes')->with('message','SE NOTIFICO');

    }

    public function recuperarcontraseña(){
      Mail::to('cuentabusiness50@gmail.com')->send(new recuperarcontraseña());

    }
}
