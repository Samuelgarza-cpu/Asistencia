<?php

namespace App\Http\Controllers\inside;

// use App\Models\Product;
use App\Models\Support;
use App\Models\Category;

use App\Models\SupportProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportProductController extends Controller
{
    public function index(){
        $supportProducts = SupportProduct::all();
        $supports =Support::where('active','=',1)->get();
        $categories = Category::all();
        foreach($supportProducts as $supportProduct)
        {
            $category = Category::find($supportProduct->categories_id);
            $support = Support::find($supportProduct->supports_id);
            
            $supportProduct->support = $support->name;
            $supportProduct->category = $category->name;
        }
        $datos = array('categories' => $categories,
        'supports' => $supports,
        'supportProducts' =>$supportProducts
        );
        return view('catalogs.supportProduct', $datos);
    }

    public function supportProducts(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $supportProducts = SupportProduct::all();
            $count = 1;
            foreach ($supportProducts as $supportProduct) 
            {
                $support = Support::find($supportProduct->supports_id);
                $category = Category::find($supportProduct->categories_id);
                $supportProduct->support = $support->name;
                $supportProduct->product = $category->name;
                $supportProduct->number = $count++;
                $supportProduct->status = $supportProduct->active == 1 ? 'Activo' : 'Inactivo';
                $supportProduct->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                            <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return  $supportProducts;
        break;
        case 'new':
            $supportProduct = SupportProduct::create([
                    'supports_id' => $request->supports_id,
                    'categories_id' => $request->categories_id,
                    'active'=> $request->active == "on" ? 1 : 0
            ]);
            $supportProduct->save();
            return redirect('productos_apoyos')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $supportProduct = SupportProduct::find($request->id);
            if($supportProduct != null && $supportProduct->count() > 0){
                $supportProduct->categories_id = $request->categories_id;
                $supportProduct->supports_id = $request->supports_id;
                $supportProduct->active = $request->active == "on" ? 1 : 0;

                $supportProduct->save();
                return redirect('productos_apoyos')->with('success','Tus datos fueron modificados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El producto que se trata de actualizar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('productos_apoyos')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'delete':
            $supportProduct = SupportProduct::find($request->registerId);
            if($supportProduct != null && $supportProduct->count() > 0){
                $supportProduct->active = 0;
                $supportProduct->save();
                return redirect('productos_apoyos')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El producto que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('productos_apoyos')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
            }
    }
}
