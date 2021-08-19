<?php

namespace App\Http\Controllers\Inside;

use App\Models\Employment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmploymentsController extends Controller
{
    public function index(){
        return view('catalogs.employments');
    }

    public function employments(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $employments=Employment::all();
            $count = 1;
            foreach ($employments as $value) 
            {
                $value->number = $count++;
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                                   <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $employments;
        break;
        case 'new':
            $employment = Employment::create([
                    'name' => $request->name
            ]);
            $employment->save();
            return redirect('ocupaciones')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $employment = Employment::find($request->id);
            if($employment != null && $employment->count() > 0){
                $employment->name = $request->name;
                $employment->save();
                return redirect('ocupaciones')->with('success','Tus datos fueron almacenados de forma satisfactoria.;');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "La ocupacion que se trata de actualizar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('ocupaciones')->with('error', 'No se pudo llevar acabo la acción ');
            } 
        break;
        case 'delete':
            $employment = Employment::find($request->registerId);
            if($employment != null && $employment->count() > 0){
                $employment->delete();
                return redirect('ocupaciones')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "La ocupacion que se trata de eliminar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('ocupaciones')->with('error', 'No se pudo llevar acabo la acción ');
            } 
        break;
        default:
            return array();
        break;
            }
    }
}
