<?php

namespace App\Http\Controllers\Inside;
use DateTime;
use App\Models\State;
use App\Models\Address;
use App\Models\Product;
use App\Models\Support;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Community;
use App\Models\InsDepSup;
use App\Models\ProductLog;
use App\Models\PhoneNumber;
use App\Models\Municipality;

use Illuminate\Http\Request;
use App\Models\SupportProduct;
use App\Models\AddressSupplier;
use App\Models\SupplierProduct;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierPhoneNumber;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Models\DepartmentInstituteSupportProduct;

class SuppliersController extends Controller
{
    public function index(){
        return view('catalogs.suppliers');
    }

    public function indexPP($id){
        if(is_numeric($id)){
            $insDepSup = InsDepSup::where('departmentsInstitutes_id','=', session('department_institute_id'))->get();
            $products = [];
            $supports = [];
            $categories = Category::all();
            $count = 0;
            $count2 = 0;
            foreach($insDepSup as $value){
                $support = Support::find($value->supports_id);
                $supportProduct = SupportProduct::where('supports_id', '=', $support->id)->get();
                foreach($supportProduct as $sp){
                    $category = Category::find($sp->categories_id);
                    $product = Product::where($category->products_id)->get();
                    $count = $product->count();
                    for($i = 0; $i<$count; $i++){
                        $products[$i] = $product[$i];
                    }
                }
                $supports[$count2] = $support;
                $count2++;
            }
            $data = array('supports' => $supports, 'products' => $products, 'categories' => $categories ,'id' => $id);
            // dd($data);
            return view('catalogs.suppliersProducts', $data);
        }
        else{
            return redirect($id);
        }
    }

    public function new(){
        $data = array('action' => 'new', 'title' => "Registrar nuevo proveedor");
        return view('catalogs.suppliersForm', $data);
    }

    public function updated(Request $request, $id){
        if(is_numeric($id)){
            $supplier = Supplier::find($id);
            $supplier->ismoral = strlen($supplier->RFC) == 13 ? 1 : 0;
            $communities = array();
            $phonenumbers_supplier = SupplierPhoneNumber::where('suppliers_id','=',$supplier->id)->get();
            $phoneNumbers = array();
            $countPhoneNumbers = $phonenumbers_supplier->count();
            for($i=0; $i<$countPhoneNumbers; $i++){
                $phonenumber_supplier = $phonenumbers_supplier[$i];
                $phoneNumber = PhoneNumber::find($phonenumber_supplier->phoneNumbers_id);
                $phoneNumbers['phoneNumber'.($i+1)] = $phoneNumber->number;
                $phoneNumbers['ext'.($i+1)] = $phonenumber_supplier->ext;
                $phoneNumbers['description'.($i+1)] = $phonenumber_supplier->description;
            }

            $supplier->countPhoneNumber = $countPhoneNumbers;
            $supplier->phonesNumbers = $phoneNumbers;

            $addresses_supplier = AddressSupplier::where('suppliers_id','=',$supplier->id)->get();
            $addresses= array();
            $countAddresses = $addresses_supplier->count();
            for($a=0; $a<$countAddresses;$a++){
                $address_supplier = $addresses_supplier[$a];
                $address = Address::find($address_supplier->addresses_id);
                $addresses['street'.($a+1)] = $address->street;
                $addresses['externalNumber'.($a+1)] = $address->externalNumber;
                $addresses['internalNumber'.($a+1)] = $address->internalNumber;
                $addresses['communities_id'.($a+1)] = $address->communities_id;
                $community = Community::find($address->communities_id);
                $addresses['postalCode'.($a+1)] = $community->postalCode;
                $municipality = Municipality::find($community->municipalities_id);
                $state = State::find($municipality->states_id);
                $addresses['municipalities_id'.($a+1)] = $municipality->id;
                $addresses['municipalities_name'.($a+1)] = $municipality->name;
                $addresses['states_id'.($a+1)] = $state->id;
                $addresses['states_name'.($a+1)] = $state->name;
                $communities = Community::where('postalCode','=',$community->postalCode)->get();
                $addresses['communities'.($a+1)] = $communities;
            }

            $supplier->countAddress = $countAddresses;
            $supplier->addresses = $addresses;
            $data = array('supplier' => $supplier,
                'action' => 'update',
                'communities' => $supplier['addresses']['communities1'],
                'title' => "Modificar proveedor"
            );

            return view('catalogs.suppliersForm', $data);
        }
        else{
            return redirect($id);
        }
    }

    public function save(Request $request){
        switch($request->input('action')){
            case 'new':
                    // dd($request);
                $supplier = Supplier::create([
                    'companyname' => $request->companyname,
                    'RFC' => $request->RFC,
                    'email' => $request->email,
                    'active' => $request->active == "on" ? 1 : 0,
                    'description' =>$request->description,
                    'department' => session('department_institute_id')
                ]);
                $supplier->save();

                $countAddresses = $request->countAddress;
                $countPhoneNumbers = $request->countPhoneNumber;

                for($i = 1; $i <= $countAddresses; $i++){
                    if($request['street'.$i] != null){
                        $address = Address::create([
                            'street' => $request['street'.$i],
                            'externalNumber' => $request['externalNumber'.$i],
                            'internalNumber' => $request['internalNumber'.$i],
                            'communities_id' => $request['communities_id'.$i]
                        ]);
                        $address->save();
                        $addresses_suppliers = AddressSupplier::create([
                            'addresses_id' => $address->id,
                            'suppliers_id' => $supplier->id
                        ]);
                        $addresses_suppliers->save();
                    }
                }
                for($a = 1; $a <= $countPhoneNumbers; $a++){
                    if($request['phonenumber'.$a] != null){
                        $phonenumber = PhoneNumber::create([
                            'number' => $request['phonenumber'.$a]
                        ]);
                        $phonenumber->save();
                        $suppliers_phone_numbers = SupplierPhoneNumber::create([
                            'phoneNumbers_id' => $phonenumber->id,
                            'suppliers_id' => $supplier->id,
                            'ext' => $request['ext'.$a],
                            'description' => $request['description'.$a]
                        ]);
                        $suppliers_phone_numbers->save();
                    }
                }
            return redirect('proveedores')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
            break;
            case 'update':

                $supplier = Supplier::find($request->id);
                if($supplier != null && $supplier->count() > 0){
                    $supplier->companyname = $request->companyname;
                    $supplier->RFC = $request->RFC;
                    $supplier->email = $request->email;
                    $supplier->active = $request->active == "on" ? 1 : 0;
                    $supplier->description = $request->description;
                    $supplier->save();

                    $suppliers_phone_numbers = SupplierPhoneNumber::where('suppliers_id','=',$supplier->id)->get();
                    $qtyPhoneNumbers = $suppliers_phone_numbers->count();
                    $countPhoneNumbers = $request->countPhoneNumber;
                    $totalFPhoneNumbers = $request->countTotalPN;

                    for($i = 1; $i<= $countPhoneNumbers; $i++){
                        if($request['phonenumber'.$i] != null){
                            if($i <= $qtyPhoneNumbers){
                                $supplierPhoneNumber = $suppliers_phone_numbers[$i-1];
                                $supplierPhoneNumber->ext = $request['ext'.$i];
                                $supplierPhoneNumber->description = $request['description'.$i];
                                $supplierPhoneNumber->save();
                                $phoneNumber = PhoneNumber::find($supplierPhoneNumber->phoneNumbers_id);
                                $phoneNumber->number = $request['phonenumber'.$i];
                                $phoneNumber->save();

                            }
                            else{
                                $phonenumber = PhoneNumber::create([
                                    'number' => $request['phonenumber'.$i]
                                ]);
                                $phonenumber->save();
                                $new_suppliers_phone_numbers = SupplierPhoneNumber::create([
                                    'phoneNumbers_id' => $phonenumber->id,
                                    'suppliers_id' => $supplier->id,
                                    'ext' => $request['ext'.$i],
                                    'description' => $request['description'.$i]
                                ]);
                                $new_suppliers_phone_numbers->save();
                            }
                        }
                        else{
                            if($i <= $totalFPhoneNumbers && isset($suppliers_phone_numbers[$i-1])){
                                $phoneNumberSupplier = PhoneNumber::find($suppliers_phone_numbers[$i-1]->phoneNumbers_id);
                                $suppliers_phone_numbers[$i-1]->delete();
                                $phoneNumberSupplier->delete();
                            }
                        }
                    }
                    $addresses_suppliers = AddressSupplier::where('suppliers_id','=',$supplier->id)->get();
                    $qtyAddresses = $addresses_suppliers->count();
                    $countAddresses = $request->countAddress;
                    $countTotalA = $request->countTotalA;

                    for($a = 1; $a<= $countAddresses; $a++){
                        if($request['street'.$a] != null){
                            if($a <= $qtyAddresses){
                                $supplierAddress = $addresses_suppliers[$a-1];
                                $address = Address::find($supplierAddress->addresses_id);
                                $address->street = $request['street'.$a];
                                $address->externalNumber = $request['externalNumber'.$a];
                                $address->internalNumber = $request['internalNumber'.$a];
                                $address->communities_id = $request['communities_id'.$a];
                                $address->save();
                            }
                            else{
                                $address = Address::create([
                                    'street' => $request['street'.$a],
                                    'externalNumber' => $request['externalNumber'.$a],
                                    'internalNumber' => $request['internalNumber'.$a],
                                    'communities_id' => $request['communities_id'.$a]
                                ]);
                                $address->save();
                                $new_addresses_suppliers = AddressSupplier::create([
                                    'addresses_id' => $address->id,
                                    'suppliers_id' => $supplier->id
                                ]);
                                $new_addresses_suppliers->save();
                            }
                        }
                        else{
                            if($a <= $countTotalA && isset($addresses_suppliers[$a-1])){
                                $addressSupplier = Address::find($addresses_suppliers[$a-1]->addresses_id);
                                $addresses_suppliers[$a-1]->delete();
                                $addressSupplier->delete();
                            }
                        }
                    }

                    return redirect('proveedores')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
                }
                else{
                    $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El proveedor que se trata de actualizar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                    return redirect('proveedores')->with('error', 'No se pudo llevar acabo la acción ');
                }
            break;
            case 'getData':
                $communities = Community::where('postalCode','=',$request->postalCode)->get();
                $data = array();
                if($communities->count() != 0){
                    foreach($communities as $community)
                    {
                        $municipalities = Municipality::find($community->municipalities_id);
                        $states = State::find($municipalities->states_id);
                    }
                    $data = array('communities' => $communities,
                    'municipalities' => $municipalities,
                    'states' => $states
                    );
                }
                return $data;
            break;
        }
        return array();
    }

    public function suppliers(Request $request){
        switch($request->input('action')){
        case "query": 
            $suppliers = Supplier::join('addresses_suppliers as aS','suppliers.id', 'aS.suppliers_id')
                                    ->join('addresses as A', 'aS.addresses_id', 'A.id')
                                    ->join('communities as C', 'A.communities_id', 'C.id')
                                    ->join('municipalities as M', 'C.municipalities_id', 'M.id')
                                    ->join('states as S', 'M.states_id', 'S.id')
                                    ->select('suppliers.*',DB::raw("CONCAT(A.street,' #',A.externalNumber,' ', IFNULL(A.internalNumber, ''),' ',C.name,' , C.P. ',C.postalCode,', ',M.name,', ',S.name) AS fulladdress"))
                                    ->groupBy('suppliers.id')
                                    ->get();
            foreach ($suppliers as $key=> $value)
            {
                $value->number = $key+1;
                $supplier_phonenumber = SupplierPhoneNumber::where('suppliers_id','=',$value['id'])->get();
                $countPhones = $supplier_phonenumber->count();
                $countPN = 1;
                $phonenumbers = "";
                foreach($supplier_phonenumber as $spn)
                {
                    if($countPN < $countPhones){
                        $phonenumber = PhoneNumber::find($spn['phoneNumbers_id']);
                        $phonenumbers = $phonenumbers.$phonenumber['number'].'/'.'</br>';
                        $countPN++;
                    }
                    else{
                        $phonenumber = PhoneNumber::find($spn['phoneNumbers_id']);
                        $phonenumbers = $phonenumbers.$phonenumber['number'];
                    }
                }
                $value->phones = $phonenumbers;
                $value->status = $value->active == 1 ? "Activo" : "Inactivo";
                $value->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a>
                <a class="addProduct" id="addProduct" title="Agregar Productos"><i class="fas fa-plus-square"></i></a>
                            <a class="remove" id="remove" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $suppliers;
        break;

        case 'delete':
            $supplier = Supplier::find($request->registerId);
            if($supplier != null && $supplier->count() > 0){
                $supplier->active = 0;
                $supplier->save();
                return redirect('proveedores')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'), 
                    'description' => "El proveedor que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('proveedores')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        case 'newCommunity':
            switch($request->input('communityZone')){
                case "urbana":
                        $request->localities_id = 1;
                break;
                case "rural":
                    $request->locality = $request->communityName;
                    $locality = Locality::where('name','like', $request->locality)->first();
                    if($locality != null && $locality->count() > 0){
                        $request->localities_id = $locality->id;
                    }
                    else{
                        $locality = Locality::create([
                            'name' => $request->locality,
                            'municipalities_id' => 288
                        ]);
                        $locality->save();
                        $request->localities_id = $locality->id;
                    }
                break;
                case "Semiurbana":
                    $request->localities_id = 1;
                break;
            }

            $community = Community::create([
                'name' => $request->communityName,
                'postalCode' => $request->communityPostalCode,
                'type' => $request->communityType,
                'zone' => $request->communityZone,
                'localities_id' => $request->localities_id
            ]);
            $community->save();
            return $community;
        break;
        default:
            return array();
        break;
            }
    }

    public function productsSuppliers(Request $request, $id){
        switch($request->input('action')){
            case "query":
                $supplier_products = SupplierProduct::where('suppliers_id','=',$id)->get();
                $count = 1;
                foreach($supplier_products as $supplier_product){
                    $product = Product::find($supplier_product->products_id);
                    $supplier_product->product = $product->name;
                    $supplier_product->code = $product->code;
                    $supplier_product->cost = '$'.$supplier_product->price;
                    $supplier_product->number = $count++;
                    $supplier_product->status = $supplier_product->active == 1 ? "Activo" : "Inactivo";
                    $supplier_product->created_date = date_format($supplier_product->created_at,"d/m/Y");
                    $supplier_product->updated_date = date_format($supplier_product->updated_at,"d/m/Y");
                    $supplier_product->actions = '<a class="update" id="updateProduct" title="Modificar"> <i class="fas fa-edit"></i></a>
                                <a class="remove" id="deleteProduct" title="Eliminar"><i class="fas fa-trash"></i></a>';
                }
                return $supplier_products;
            break;
            case 'new':
                $supplierProduct = SupplierProduct::create([
                        'price' => $request->price,
                        'active' => $request->active == "on" ? 1 : 0,
                        'products_id' => $request->products_id,
                        'suppliers_id' => $id
                ]);
                $supplierProduct->save();

                $product = Product::find($request->products_id);
                $supplier = Supplier::find($id);
                $productLog = ProductLog::create([
                    'suppliersProducts_id' => $supplierProduct->id,
                    'price' => $request->price,
                    'productName' => $product->name,
                    'supplierName' => $supplier->companyname

                ]);
                $productLog->save();
                return redirect('/productosdelproveedor/'.$id)->with('success','Tus datos fueron almacenados de forma satisfactoria.');
            break;
            case 'newProduct':
                $code = substr($request->nameProduct, 0, 4);
                // $status = $request->active == "on" ? 1 : 0;
                $product = Product::create([
                    'name' => $request->nameProduct,
                    'code' => $code,
                    'categories_id' => $request->categories_id
                ]);

                $product->save();

                $supportProduct = SupportProduct::create([
                    'supports_id' => $request->supports_id,
                    'active' => 1,
                    'categories_id'=> $request->categories_id
                ]);
                $supportProduct->save();
                return $product;
            break;
            case 'update':
                $supplierProduct = SupplierProduct::find($request->id);
                if($supplierProduct != null && $supplierProduct->count() > 0){
                    $supplierProduct->price = $request->price;
                    $supplierProduct->products_id = $request->products_id;
                    $supplierProduct->suppliers_id = $id;
                    $supplierProduct->active = $request->active == "on" ? 1 : 0;
                    $supplierProduct->save();

                    $product = Product::find($request->products_id);
                    $supplier = Supplier::find($id);
                    $productLog = ProductLog::create([
                        'suppliersProducts_id' => $supplierProduct->id,
                        'price' => $request->price,
                        'productName' => $product->name,
                        'supplierName' => $supplier->companyname

                    ]);
                    $productLog->save();
                    return redirect('/productosdelproveedor/'.$id)->with('success','Tus datos fueron almacenados de forma satisfactoria.');
                }
                else{
                    $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El producto del proveedor que se trata de actualizar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                    return redirect('productosdelproveedor')->with('error', 'No se pudo llevar acabo la acción ');
                }
            break;
            case 'delete':
                $supplierProduct = SupplierProduct::find($request->registerId);
                if($supplierProduct != null && $supplierProduct->count() > 0){
                    $supplierProduct->active = 0;
                    $supplierProduct->save();
                    return redirect('/productosdelproveedor/'.$id)->with('success','Tus datos fueron almacenados de forma satisfactoria.');
                }
                else{
                    $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "El producto del proveedor que se trata de eliminar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                    return redirect('productosdelproveedor')->with('error', 'No se pudo llevar acabo la acción ');
                }
            break;
            default:
                return array();
            break;
        }
    }
}
