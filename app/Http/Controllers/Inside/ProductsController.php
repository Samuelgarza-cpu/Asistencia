<?php

namespace App\Http\Controllers\Inside;

use App\Models\Product;
use App\Models\Department;
use App\Models\DepartmentInstitute;
use App\Models\Institute;
use App\Models\SupportProduct;
use App\Models\Support;
use App\Models\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $categories = Category::all();
        $data = array('categories' => $categories);
        return view('catalogs.products', $data);
    }
    public function products(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $products = Product::all();
            $count = 1;
            foreach ($products as $product) 
            {
                $category = Category::find($product->categories_id);
                $product->number = $count++;
                $product->category = $category->name;
                $product->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                            <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return  $products;
        break;
        case 'new':
            $code = substr($request->name, 0, 4);
            $product = Product::create([
                'name' => $request->name,
                'code' => $code,
                'categories_id' => $request->categories_id
            ]);
            $product->save();

            return redirect('productos')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;  
        case 'update':
            $code = substr($request->name, 0, 4);
            $product = Product::find($request->id);
            if($product != null && $product->count() > 0){
                $product->name = $request->name;
                $product->code = $code;
                $product->categories_id = $request->categories_id;
                $product->save();

                return redirect('productos')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El producto que se trata de actualizar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('productos')->with('error', 'No se pudo llevar acabo la acción ');
            }   
        break;
        case 'delete':
            $product = Product::find($request->registerId);
            if($product != null && $product->count() > 0){
                $product->delete();
                return redirect('productos')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El producto que se trata de eliminar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('productos')->with('error', 'No se pudo llevar acabo la acción ');
            }             
        break;
        default:
            return array();
        break;
            }
    }
}
