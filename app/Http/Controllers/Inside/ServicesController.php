<?php

namespace App\Http\Controllers\inside;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    public function index(){
        return view('catalogs.services');
    }
    public function services(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $services= Service::all();
            $count = 1;
            foreach ($services as $value) 
            {
                $value->number = $count++;
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                                   <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $services;
        break;
        case 'new':
            $service = Service::create([
                    'name' => $request->name
            ]);
                $service->save();
                return redirect('servicios')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $service = Service::find($request->id);
            if($service != null && $service->count() > 0){
                $service->name = $request->name;
                $service->save();
                return redirect('servicios')->with('success','Tus datos fueron almacenados de forma satisfactoria.;');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El servicio que se trata de modificar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('servicios')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $service = Service::find($request->registerId);
            if($service != null && $service->count() > 0){
                $service->delete();
                return redirect('servicios')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El servicio que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('servicios')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
