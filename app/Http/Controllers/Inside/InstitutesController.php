<?php

namespace App\Http\Controllers\Inside;

use App\Models\Institute;
use App\Models\ActivityLog;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class InstitutesController extends Controller
{
    public function index(){
        return view('catalogs.institutes');
    }
    public function institutes(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $institutes=Institute::all();
            $count = 1;
            foreach ($institutes as $value) 
            {
                $value->number = $count++;
                $value->status = $value->active == 1 ? 'Activo' : 'Inactivo';
                $value->actions = '<a class="update" id="update" title="Modificar" > <i class="fas fa-edit"></i></a> 
                                   <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $institutes;
        break;
        case 'new':
            $institute = Institute::create([
                    'name' => $request->name,
                    'active' => $request->active == "on" ? 1 : 0
            ]);
            $activiyLog = ActivityLog::create([
                'users_id' => session('user_id'),
                'owner' => session('user'),
                'description' => 'Se creo un Instituto con el ID: '.$institute->id
            ]);
            $institute->save();
            return redirect('institutos')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $institute = Institute::find($request->id);
            if($institute != null && $institute->count() > 0){
                $institute->name = $request->name;
                $institute->active = $request->active == "on" ? 1 : 0;
                $institute->save();
                $activiyLog = ActivityLog::create([
                    'users_id' => session('user_id'),
                    'owner' => session('user'),
                    'description' => 'Se modificó un Instituto con el ID: '.$institute->id
                ]);
                return redirect('institutos')->with('success','Tus datos fueron modificados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El instituto que se trata de actualizar no existe o esta erróneo -ID: ".$request->id,
                        'owner' => session('user')
                    ]);
                return redirect('institutos')->with('error', 'No se pudo llevar acabo la acción ');
            } 
        break;
        case 'delete':
            $institute = Institute::find($request->registerId);
            if($institute != null && $institute->count() > 0){
                $institute->active = 0;
                $institute->save();
                $activiyLog = ActivityLog::create([
                    'users_id' => session('user_id'),
                    'owner' => session('user'),
                    'description' => 'Se desactivo un Instituto con el ID: '.$institute->id
                ]);
                return redirect('institutos')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El instituto que se trata de eliminar no existe o esta erróneo -ID: ".$request->registerId,
                        'owner' => session('user')
                    ]);
                return redirect('institutos')->with('error', 'No se pudo llevar acabo la acción ');
            }    
        break;
        default:
            return array();
        break;
            }
    }
}
