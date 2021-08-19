<?php

namespace App\Http\Controllers\inside;

use App\Models\BuildingMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuildingMaterialsController extends Controller
{
    public function index(){
        return view('catalogs.buildingMaterial');
    }
    public function buildingMaterials(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $buildingMaterials=BuildingMaterial::all();
            $count = 1;
            foreach ($buildingMaterials as $value) 
            {
                $value->number = $count++;
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                                   <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $buildingMaterials;
        break;
        case 'new':
            $buildingMaterial = BuildingMaterial::create([
                    'name' => $request->name
            ]);
            $buildingMaterial->save();
            return redirect('materialesConstruccion')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $buildingMaterial = BuildingMaterial::find($request->id);
            if($buildingMaterial != null && $buildingMaterial->count() > 0){
                $buildingMaterial->name = $request->name;
                $buildingMaterial->save();
                return redirect('materialesConstruccion')->with('success','Tus datos fueron almacenados de forma satisfactoria.;');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El material que se trata de modificar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('materialesConstruccion')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $buildingMaterial = BuildingMaterial::find($request->registerId);
            if($buildingMaterial != null && $buildingMaterial->count() > 0){
                $buildingMaterial->delete();
                return redirect('materialesConstruccion')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El material que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('materialesConstruccion')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
