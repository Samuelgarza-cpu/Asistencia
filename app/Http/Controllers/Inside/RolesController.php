<?php

namespace App\Http\Controllers\Inside;

use App\Models\Role;
use App\Models\ErrorLog;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index(){
        return view('catalogs.roles');
    }
    public function roles(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $roles=Role::all();
            $count = 1;
            foreach ($roles as $value)
            {
                $value->number = $count++;
                $value->status = $value->active == 1 ? 'Activo' : 'Inactivo';
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a>
                                   <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $roles;
        break;
        case 'new':
            $code = substr($request->name, 0, 4);
            $role = Role::create([
                    'name' => $request->name,
                    'code' => $code,
                    'active' => $request->active == "on" ? 1 : 0
            ]);
            $role->save();
            $activiyLog = ActivityLog::create([
                'users_id' => session('user_id'),
                'owner' => session('user'),
                'description' => 'Se creo un rol con el ID: '.$role->id
            ]);
            $activiyLog->save();
            return redirect('roles')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;
        case 'update':
            $role = Role::find($request->id);
            if($role != null && $role->count() > 0){
                $role->name = $request->name;
                $role->code = substr($request->name, 0, 4);
                $role->active = $request->active == "on" ? 1 : 0;
                $role->save();
                $activiyLog = ActivityLog::create([
                    'users_id' => session('user_id'),
                    'owner' => session('user'),
                    'description' => 'Se modifico un rol con el ID: '.$role->id
                ]);
                return redirect('roles')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'),
                    'description' => "El rol que se trata de modificar no existe o esta erróneo -ID: ".$request->id,
                    'owner' => session('user')
                ]);
                return redirect('roles')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $role = Role::find($request->registerId);
            if($role != null && $role->count() > 0){
                $role->active = 0;
                $role->save();
                $activiyLog = ActivityLog::create([
                    'users_id' => session('user_id'),
                    'owner' => session('user'),
                    'description' => 'Se desactivo un rol con el ID: '.$role->id
                ]);
                return redirect('roles')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else {
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'),
                    'description' => "El rol que se trata de eliminar no existe o esta erróneo -ID: ".$request->registerId,
                    'owner' => session('user')
                ]);
                return redirect('roles')->with('error', 'No se pudo llevar acabo la acción');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
