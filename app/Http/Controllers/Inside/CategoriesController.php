<?php

namespace App\Http\Controllers\inside;


use App\Models\Category;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    public function index(){
        return view('catalogs.categories');
    }
    public function categories(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $categories=Category::all();
            $count = 1;
            foreach ($categories as $value) 
            {
                $value->number = $count++;
                $value->status = $value->active == 1 ? 'Activo' : 'Inactivo';
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                            <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $categories;
        break;
        case 'new':
            $category = Category::create([
                    'name' => $request->name,
                    'active' => $request->active == "on" ? 1 : 0
            ]);
            $category->save();
            return redirect('categorias')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $category = Category::find($request->id);
            if($category != null && $category->count() > 0){
                $category->name = $request->name;
                $category->active = $request->active == "on" ? 1 : 0;       
                $category->save();
                return redirect('categorias')->with('success','Tus datos fueron modificados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "La categoria que se trata de modificar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('categorias')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $category = Category::find($request->registerId);
            if($category != null && $category->count() > 0){
                $category->active = 0;
                $category->save();
                return redirect('categorias')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "La categoria que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('categorias')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
