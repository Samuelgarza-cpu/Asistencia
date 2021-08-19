<?php

namespace App\Http\Controllers\Inside;

use Illuminate\Http\Request;
use App\Models\Disabilities;
use App\Models\DisabilityCategories;
use App\Http\Controllers\Controller;

class DisabilitiesController extends Controller
{
    public function index(){

        $disabilitiesCategories = DisabilityCategories::all();
        
        $data = array('categories' => $disabilitiesCategories);
        return view('Catalogs.disabilities',$data);
   }

   public function data(Request $request){
    switch($request->input('action')){
        case "query":
            $disabilities = Disabilities::all();
            $count = 1;
            foreach ($disabilities as $disability) 
            {
                // $category = Disabilities::find($product->categories_id);
                $disability->number = $count++;
                $disabilityCategory = DisabilityCategories::find($disability->disabilitycategories_id);
                $disability->category = $disabilityCategory->name;
                $disability->status = $disability->active == 1 ? 'Activo' : 'Inactivo';
                $disability->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                            <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return  $disabilities;
        break;
        case 'new':
            $disability = Disabilities::create([
                'name' => $request->name,
                'disabilitycategories_id' => $request->categories_id,
                'active' => $request->active == "on" ? 1 : 0
            ]);
            $disability->save();

            return redirect('diagnostico')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $disability = Disabilities::find($request->id);
            if($disability != null && $disability->count() > 0){
                $disability->name = $request->name;
                $disability->disabilitycategories_id=$request->categories_id;
                $disability->active = $request->active == "on" ? 1 : 0;
                $disability->save();

                return redirect('diagnostico')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "La discapacidad que se trata de modificar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('diagnostico')->with('error', 'No se pudo llevar acabo la acción ');
            }   
        break;
        case 'delete':
            $disability = Disabilities::find($request->registerId);
            if($disability != null && $disability->count() > 0){
                $disability->active=0;
                $disability->save();
                return redirect('diagnostico')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "La discapacidad que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('diagnostico')->with('error', 'No se pudo llevar acabo la acción ');
            }  
        break;
        default:
            return array();
        break;
            }
    }       
}

