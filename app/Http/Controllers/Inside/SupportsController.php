<?php

namespace App\Http\Controllers\Inside;

use App\Models\Support;
use App\Models\Department;
use App\Models\DepartmentInstitute;
use App\Models\Institute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportsController extends Controller
{
    public function index(){
        // $institutes = Institute::all();
        // foreach($institutes as $institute)
        // {
        //     $departmentInstitute = DepartmentInstitute::where('institutes_id','=',$institute->id)->first();
        //     $department=Department::find($departmentInstitute->departments_id);
        //     $institute->fullname = $institute->name.', '.$department->name;
        //     $institute->department_institute_id = $departmentInstitute->id;
        // }
        // $datos = array('institutes' => $institutes
        // );
        // return view('catalogs.supports',$datos);
        return view('catalogs.supports');
    }
    public function supports(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $supports=Support::all();
            $count = 1;
            foreach ($supports as $value) 
            {
                // $department_institute = DepartmentInstitute::find($value['departments_institutes_id']);
                // $institute = Institute::find($department_institute['institutes_id']);
                // $department = Department::find($department_institute['departments_id']);
                // $value->institute = $institute->name.', '.$department->name;           
                $value->number = $count++;
                $value->status = $value->active == 1 ? 'Activo' : 'Inactivo';
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                            <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $supports;
        break;
        case 'new':
            $code = substr($request->name, 0, 4);            
            $support = Support::create([
                    'name' => $request->name,
                    'code' => $code,
                    'active' => $request->active == "on" ? 1 : 0
                    // 'departments_institutes_id' => $request->departments_institutes_id
            ]);
            $support->save();
            return redirect('apoyos')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $support = Support::find($request->id);
            if($support != null && $support->count() > 0){
                $support->name = $request->name;
                $support->code = substr($request->name, 0, 4);  
                $support->active = $request->active == "on" ? 1 : 0;
                $support->save();
                return redirect('apoyos')->with('success','Tus datos fueron almacenados de forma satisfactoria.;');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El apoyo que se trata de actualizar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('apoyos')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $support = Support::find($request->registerId);
            if($support != null && $support->count() > 0){
                $support->active = 0;
                $support->save();
                return redirect('apoyos')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El apoyo que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('apoyos')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
