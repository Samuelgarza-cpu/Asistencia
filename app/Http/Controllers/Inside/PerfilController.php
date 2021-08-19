<?php

namespace App\Http\Controllers\inside;

use App\Models\Role;
use App\Models\User;
use App\Models\Institute;
use App\Models\Department;
use App\Models\DepartmentInstitute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    public function index($id){
        if(is_numeric($id)){
            $generalData = User::find($id);
            if($generalData != null && $generalData->count() > 0){
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El usuario no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('catalogs.perfil')->with('error', 'No se pudo llevar acabo la acción ');
            }

            $department_institute = DepartmentInstitute::find($generalData->departments_institutes_id);
            if($department_institute != null && $department_institute->count() > 0){
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "La relacion departamento - instituto no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('catalogs.perfil')->with('error', 'No se pudo llevar acabo la acción ');
            }

            $department = Department::find($department_institute->departments_id);
            if($department != null && $department->count() > 0){
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El departamento no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('catalogs.perfil')->with('error', 'No se pudo llevar acabo la acción ');
            }

            $institute = Institute::find($department_institute->institutes_id);
            if($institute != null && $institute->count() > 0){
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El instituto no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('catalogs.perfil')->with('error', 'No se pudo llevar acabo la acción ');
            }

            $role = Role::find($generalData->roles_id);
            if($role != null && $role->count() > 0){
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El rol no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('catalogs.perfil')->with('error', 'No se pudo llevar acabo la acción ');
            }

            $generalData->department = $department->name;
            $generalData->institute = $institute->name;
            $generalData->role = $role->name;
            $generalData->stamp = $department_institute->stamp;
            $generalData->image = $department_institute->image;
            
            $data = array('generalData' => $generalData);
            return view('catalogs.perfil', $data);
        }
        else{
            return redirect($id);
        }
    }
}
