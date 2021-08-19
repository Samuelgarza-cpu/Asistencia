<?php

namespace App\Http\Controllers\inside;


use App\Models\Furniture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FurnituresController extends Controller
{
    public function index(){
        return view('catalogs.furnitures');
    }

    public function furnitures(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $furnitures=Furniture::all();
            $count = 1;
            foreach ($furnitures as $value) 
            {
                $value->number = $count++;
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                                   <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $furnitures;
        break;
        case 'new':
            $furniture = Furniture::create([
                    'name' => $request->name
            ]);
                $furniture->save();
                return redirect('muebles')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $furniture = Furniture::find($request->id);
            if($furniture != null && $furniture->count() > 0){
                $furniture->name = $request->name;
                $furniture->save();
                return redirect('muebles')->with('success','Tus datos fueron almacenados de forma satisfactoria.;');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El mueble que se trata de actualizar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('muebles')->with('error', 'No se pudo llevar acabo la acción ');
            } 
        break;
        case 'delete':
            $furniture = Furniture::find($request->registerId);
            if($furniture != null && $furniture->count() > 0){
                $furniture->delete();
                return redirect('muebles')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El mueble que se trata de eliminar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('muebles')->with('error', 'No se pudo llevar acabo la acción ');
            } 
        break;
        default:
            return array();
        break;
            }
    }
}
