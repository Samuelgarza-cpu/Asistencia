<?php

namespace App\Http\Controllers\Inside;

use App\Models\Department;
use App\Models\DepartmentInstitute;
use App\Models\Institute;
use App\Models\ActivityLog;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index(){
        return view('catalogs.departments');
    }
    public function departments(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $departments = Department::all();
            $count = 1;
            foreach ($departments as $department) 
            {
                $department->number = $count++;
                $department->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                            <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return  $departments;
        break;
        case 'new':
            $code = substr($request->name, 0, 4);
            $department = Department::create([
                    'name' => $request->name,
                    'code' => $code
            ]);
            $department->save();
            $activiyLog = ActivityLog::create([
                'users_id' => session('user_id'),
                'owner' => session('user'),
                'description' => 'Se creo un departamento con el ID: '.$department->id
            ]);
            return redirect('departamentos')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $department = Department::find($request->id);
            if($department != null && $department->count() > 0){
                $department->name = $request->name;
                $department->code = substr($request->name, 0, 4);
                $department->save();
                $activiyLog = ActivityLog::create([
                    'users_id' => session('user_id'),
                    'owner' => session('user'),
                    'description' => 'Se modifico un departamento con el ID: '.$department->id
                ]);
                return redirect('departamentos')->with('success','Tus datos fueron modificados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El departamento que se trata de actualizar no existe o esta erróneo -ID: ".$request->id,
                    'owner' => session('user')
                ]);
                return redirect('departamentos')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $department = Department::find($request->registerId);
            if($department != null && $department->count() > 0){
                $activiyLog = ActivityLog::create([
                    'users_id' => session('user_id'),
                    'owner' => session('user'),
                    'description' => 'Se eliminó un departamento con el ID: '.$department->id
                ]);
                $department->delete();
                return redirect('departamentos')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El departamento que se trata de eliminar no existe o esta erróneo -ID: ".$request->registerId,
                    'owner' => session('user')
                ]);
                return redirect('departamentos')->with('error', 'No se pudo llevar acabo la acción ');
            }    
        break;
        default:
            return array();
        break;
            }
    }
}