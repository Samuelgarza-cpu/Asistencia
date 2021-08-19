<?php

namespace App\Http\Controllers\inside;

use App\Models\Support;
use App\Models\Institute;
use App\Models\Department;
use App\Models\InsDepSup;
use App\Models\DepartmentInstitute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportDepartmentController extends Controller
{
    public function index(){
        $insDepSupPro = InsDepSup::all();
        $departmentInstitutes =DepartmentInstitute::all();
        $supports = Support::all();
        
        foreach($departmentInstitutes as $departmentInstitute)
        {
            $department = Department::find($departmentInstitute->departments_id);
            $institute = Institute::find($departmentInstitute->institutes_id);
            
            $departmentInstitute->fullname = $department->name.','.$institute->name;
        }
        $datos = array('departmentSupports' => $insDepSupPro,
            'supports' => $supports,
            'departmentInstitutes' =>$departmentInstitutes
        );
        return view('catalogs.departmentSupport', $datos);
    }

    public function departmentSupports(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $departmentSupports = InsDepSup::all();
            $count = 1;
            foreach ($departmentSupports as $departmentSupport) 
            {
                $support = Support::find($departmentSupport->supports_id);
                $departmentInstitute = DepartmentInstitute::find($departmentSupport->departmentsInstitutes_id);
                
                $department = Department::find($departmentInstitute->departments_id);
                $institute = Institute::find($departmentInstitute->institutes_id);
                
                $departmentSupport->departmentInstitute = $department->name.', '.$institute->name;
                $departmentSupport->support = $support->name;
                $departmentSupport->number = $count++;
                $departmentSupport->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                                               <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return  $departmentSupports;
        break;
        case 'new':
            $departmentSupport = InsDepSup::create([
                    'supports_id' => $request->supports_id,
                    'departmentsInstitutes_id' => $request->departmentsInstitutes_id
            ]);
            $departmentSupport->save();
            return redirect('apoyos_departamento')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $departmentSupport = InsDepSup::find($request->id);
            if($departmentSupport != null && $departmentSupport->count() > 0){
                $departmentSupport->departmentsInstitutes_id = $request->departmentsInstitutes_id;
                $departmentSupport->supports_id = $request->supports_id;
                $departmentSupport->save();
                return redirect('apoyos_departamento')->with('success','Tus datos fueron modificados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El apoyo que se trata de actualizar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('apoyos_departamento')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $departmentSupport = InsDepSup::find($request->registerId);
            if($departmentSupport != null && $departmentSupport->count() > 0){
                $departmentSupport->delete();
                return redirect('apoyos_departamento')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El apoyo que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('apoyos_departamento')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
