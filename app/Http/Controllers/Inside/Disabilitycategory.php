<?php

namespace App\Http\Controllers\Inside;

use Illuminate\Http\Request;
use App\Models\DisabilityCategories;
use App\Http\Controllers\Controller;

class Disabilitycategory extends Controller
{
    public function index(){
    
        $disabilityCategories = DisabilityCategories::all();

        $data = array('categories' => $disabilityCategories);
        return view('Catalogs.categorydisabilities', $data);        
   }

   public function products(Request $request)
   {
       switch($request->input('action')){
       case "query":
           $disabilityCategories = DisabilityCategories::all();
          
           $count = 1;
           foreach ($disabilityCategories as $disabilityCategory) 
           {
               $disabilityCategory->number = $count++;
               $disabilityCategory->status = $disabilityCategory->active == 1 ? 'Activo' : 'Inactivo';
               $disabilityCategory->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                                               <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
               
           }
           return  $disabilityCategories;
       break;
       case 'new':
           $code = substr($request->name, 0, 4);
           $disabilityCategory = DisabilityCategories::create([
               'name' => $request->name,
               'active' => $request->active == "on" ? 1 : 0
           ]);
           $disabilityCategory->save();

           return redirect('categoria-diagnostico')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
       break;  
       case 'update':
      
           $disabilityCategory = DisabilityCategories::find($request->id);
           if($disabilityCategory != null && $disabilityCategory->count() > 0){
                $disabilityCategory->name = $request->name;
                $disabilityCategory->active = $request->active == "on" ? 1 : 0;
                $disabilityCategory->save();

                return redirect('categoria-diagnostico')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
           }
           else{
            $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "La categoria de discapacidad que se trata de actualizar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('categoria-diagnostico')->with('error', 'No se pudo llevar acabo la acción ');
            } 
       break;
       case 'delete':
            $disabilityCategory = DisabilityCategories::find($request->registerId);
            if($disabilityCategory != null && $disabilityCategory->count() > 0){
                $disabilityCategory->active=0;
                $disabilityCategory->save();
                return redirect('categoria-diagnostico')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "La categoria de discapacidad que se trata de eliminar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                    return redirect('categoria-diagnostico')->with('error', 'No se pudo llevar acabo la acción ');
            }           
       break;
       default:
           return array();
       break;
           }
   }  
}
