<?php

namespace App\Http\Controllers\Inside;

use App\Models\Status;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(){
        return view('catalogs.status');
    }
    public function status(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $status=Status::all();
            $count = 1;
            foreach ($status as $value) 
            {
                $value->number = $count++;
                $value->status = $value->active == 1 ? 'Activo' : 'Inactivo';
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                            <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $status;
        break;
        case 'new':
            $code = substr($request->name, 0, 4);            
            $status = Status::create([
                    'name' => $request->name,
                    'code' => $code,
                    'color' => $request->color,
                    'active' => $request->active == "on" ? 1 : 0
            ]);
            $status->save();
            return redirect('estados_solicitud')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $status = status::find($request->id);
            if($status != null && $status->count() > 0){
                $status->name = $request->name;
                $status->code = substr($request->name, 0, 4);
                $status->color = $request->color;
                $status->active = $request->active == "on" ? 1 : 0;       
                $status->save();
                return redirect('estados_solicitud')->with('success','Tus datos fueron modificados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El estatus que se trata de actualizar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('estados_solicitud')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $status = status::find($request->registerId);
            if($status != null && $status->count() > 0){
                $status->active = 0;
                $status->save();
                return redirect('estados_solicitud')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El estatus que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('estados_solicitud')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
