<?php

namespace App\Http\Controllers\Inside;

use PDF;
use PDFMerger;
Use DateTime;
use App\Models\User;
use App\Models\State;
use App\Models\Status;
use App\Models\Address;
use App\Models\Product;

use App\Models\Service;
use App\Models\Support;
use App\Models\Category;
use App\Models\Document;
use App\Models\Supplier;
use App\Models\Community;
use App\Models\Furniture;
use App\Models\InsDepSup;
use App\Models\Institute;
use App\Models\Department;
use App\Models\Employment;
use App\Models\PhoneNumber;

use App\Models\Requisition;
use App\Models\Disabilities;
use App\Models\EconomicData;
use App\Models\Municipality;
use App\Models\PersonalData;
use Illuminate\Http\Request;
use App\Models\LifeCondition;
use App\Models\RequestService;
use App\Models\SupportProduct;
use App\Models\AddressSupplier;
use App\Models\ExtPersonalData;
use App\Models\FamilySituation;
use App\Models\RPDDisabilities;
use App\Models\SupplierProduct;
use App\Models\BuildingMaterial;
use App\Models\deliberypictures;
use App\Models\RequestFurniture;
use App\Mail\StatusSolicitudMail;
use App\Models\DepartmentInstitute;
use App\Models\RequestInsDepSupPro;
use App\Models\RequestPersonalData;
use App\Http\Controllers\Controller;
use App\Models\DisabilityCategories;
use Illuminate\Support\Facades\Mail;
use App\Models\RequestSupplierProduct;
use App\Models\vRequestSupplierProduct;
use App\Models\PhoneNumberPersonalData;
use App\Models\RequestBuildingMaterial;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use App\Models\DepartmentInstituteSupportProduct;
use App\Models\EmailLog;

class RequestsController extends Controller
{
    public function index(){
        return view('catalogs.requests');
    }

    public function new(){
        $employments = Employment::all();
        $catdisability=DisabilityCategories::all();
        $disability=Disabilities::all();
        $supports = [];
        $categories = [];
        $department_supports = InsDepSup::where('departmentsInstitutes_id','=',session('department_institute_id'))->get();
        $count_ds = $department_supports->count();
        $existSup = true;
        for($i = 0; $i < $count_ds; $i++)
        {
            $valueDS = $department_supports[$i];

            $support = Support::find($valueDS->supports_id);
            if($supports != null){
                foreach($supports as $valueSup){
                    if($support->id == $valueSup->id){
                        $existSup = true;
                        break;
                    }
                    else{
                        $existSup = false;
                    }
                }
            }
            else{
                array_push($supports, $support);
                $category = Category::find($valueDS->categories_id);
             }
            if(!$existSup){
                array_push($supports, $support);
                $category = Category::find($valueDS->categories_id);
            }
        }

        $furnitures = Furniture::all();
        $buildingMaterials = BuildingMaterial::all();
        $services = Service::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        $vRequestSupplierProduct=vRequestSupplierProduct::all();
        $furnitures = Furniture::all();
        $services = Service::all();
        $session = session('department_institute_id');

        $data = array(
            // 'communities' => $communities,
            // 'municipalities' => $municipalities,
            // 'states' => $states,

            'employments' => $employments,
            'furnitures' => $furnitures,
            'buildingMaterials' => $buildingMaterials,
            'services' => $services,
            'supports' => $supports,
            'suppliers' => $suppliers,
            'products' => $products,
            'categotydisability'=> $catdisability,
            'disabilities'=>$disability,
            'furnitures'=>$furnitures,
            'services'=>$services,
            'department_institute_id'=> $session,
            'vRequestSupplierProduct'=> $vRequestSupplierProduct,
            'action' => 'new'
            
            );
            // dd($data);

        return view('catalogs.RequestsForm', $data);
    }

    public function update($id){
        $states = State::all();
        $municipalities = Municipality::all();
        $communities = Community::all();
        $employments = Employment::all();
        $session = session('department_institute_id');

        $data = array(
            // 'communities' => $communities,
            // 'municipalities' => $municipalities,
            // 'states' => $states,
            'employments' => $employments,
            'furnitures' => $furnitures,
            'buildingMaterials' => $buildingMaterials,
            'services' => $services,
            'supports' => $supports,
            'suppliers' => $suppliers,
            'products' => $products,
            'categotydisability'=> $catdisability,
            'disabilities'=>$disability,
            'furnitures'=>$furnitures,
            'services'=>$services,
            'department_institute_id'=> $session,
            'action' => 'update'
        );

        return view('catalogs.RequestsForm', $data);
    }

    public function save(Request $request){
            switch($request->input('action')){

                case 'saveWOR':
                    $requestCount = Requisition::all()->count();
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString='';
                    for ($i = 0; $i < 7; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }

                    $folio = 'R'.$randomString.$requestCount;

                    if($request->curpPetitioner1 != "" && $request->curpPetitioner1 != null){
                        $curpPetitioner = strtoupper($request->curpPetitioner1);
                    }
                    else{
                        $curpPetitioner = "";
                    }

                    $userAuth = User::where('roles_id', '=', 6)->first();
                    $today = New Datetime();

                    $requests = Requisition::find($request->id);
                    $updateReq = 'SI';
                    if ($requests != null) {
                        $folio = $request->folio;

                        //$requests->folio = $folio != null && $folio != "" ? $folio : '',
                        $requests->petitioner = $request->petitioner != null && $request->petitioner != "" ? $request->petitioner : '';
                        $requests->curpPetitioner = $curpPetitioner != null && $curpPetitioner != "" ? $curpPetitioner : '';
                        $requests->beneficiary = $request->countBeneficiary;
                        $requests->type = $request->type != null && $request->type != "" ? $request->type : '';
                        $requests->supports_id = $request->supports_id != null && $request->supports_id != "" ? $request->supports_id : 0;
                        $requests->categories_id = $request->categories_id != null && $request->categories_id != "" ? $request->categories_id : 0;
                        $requests->description = $request->reason != null && $request->reason != "" ? $request->reason : '';
                        $requests->image = $request->petitionerImage; //!= null && $request->petitionerImage != "" && $request->petitionerImage != $requests->image ? $request->petitionerImage : $requests->image;
                        $requests->users_id = session('user_id');
                        $requests->usersAuth_id = $userAuth != null && $userAuth != "" ? $userAuth: session('user_id');
                        //$requests->status_id = 8;
                        $requests->date = $request->date != "" && $request->date != null ? $request->date : $today;
                        $requests->departments_institutes_id = session('department_institute_id');
                        $requests->area = $request->area != "" && $request->area != null ? $request->area : '' ;
                    }
                    else {
                        $requests = Requisition::create([
                            'folio' => $folio != null && $folio != "" ? $folio : '',
                            'petitioner' => $request->petitioner != null && $request->petitioner != "" ? $request->petitioner : '',
                            'curpPetitioner' => $curpPetitioner != null && $curpPetitioner != "" ? $curpPetitioner : '',
                            'beneficiary' => $request->countBeneficiary,
                            'type' => $request->type != null && $request->type != "" ? $request->type : '',
                            'supports_id' => $request->supports_id != null && $request->supports_id != "" ? $request->supports_id : 0,
                            'categories_id' => $request->categories_id != null && $request->categories_id != "" ? $request->categories_id : 0,
                            'description' => $request->reason != null && $request->reason != "" ? $request->reason : '',
                            'image' => $request->petitionerImage,   //!= null && $request->petitionerImage != "" ? $request->petitionerImage : "",
                            'users_id' => session('user_id'),
                            'usersAuth_id' => $userAuth != null && $userAuth != "" ? $userAuth: session('user_id'),
                            'status_id' => 6,
                            'date' => $request->date != "" && $request->date != null ? $request->date : $today,
                            'departments_institutes_id' => session('department_institute_id'),
                            'area' => $request->area != "" && $request->area != null ? $request->area : ''
                        ]);
                        $updateReq = 'NO';
                    }
                    $requests->save();

                    // //if($request->file('petitionerImage') != ''){
                    //     $petitionerImageFile = $request->file('petitionerImage');
                    //     $imageName = 'solicitante-'.$petitionerImageFile->getClientOriginalName();
                    //     Storage::disk('local')->put($imageName,  \File::get($petitionerImageFile));
                    //     $requests->image = $petitionerImageFile->getClientOriginalName();
                    //     $requests->save();
                    // }

                    $countProducts = $request->countProduct;
                    for($i = 1; $i <= $countProducts; $i++)
                    {
                         if ($request->type == "ts") {
                             $requestInsDepSupPro = RequestInsDepSupPro::where('requests_id', '=',$request->id)->where('products_id', '=', $request['products_id'.$i])->first();
                             if ($requestInsDepSupPro != null)
                             {
                                 //$requestInsDepSupPro->requests_id => $requests->id != null ? $requests->id : 0;
                                 $requestInsDepSupPro->products_id =  $request['products_id'.$i] != null && $request['products_id'.$i] != "" ? $request['products_id'.$i] : 0;
                                 $requestInsDepSupPro->qty =  $request['qty'.$i] != null && $request['qty'.$i] != "" ? $request['qty'.$i] : 0;
                                 $requestInsDepSupPro->price = $request['unitPrice'.$i] != null && $request['unitPrice'.$i] != "" ? $request['unitPrice'.$i] : 0;
                             }
                            else
                             {
                                  $requestInsDepSupPro = RequestInsDepSupPro::create([
                                 'requests_id' => $requests->id != null ? $requests->id : 0,
                                 'products_id'=> $request['products_id'.$i] != null && $request['products_id'.$i] != "" ? $request['products_id'.$i] : 0,
                                 'qty' => $request['qty'.$i] != null && $request['qty'.$i] != "" ? $request['qty'.$i] : 0,
                                     'price' => $request['unitPrice'.$i] != null && $request['unitPrice'.$i] != "" ? $request['unitPrice'.$i] : 0
                                 ]);
                             }
                             $requestInsDepSupPro->save();

                             $requestSuppliersProducts = RequestSupplierProduct::where('requests_id', '=',$request->id)->get();
                             foreach($requestSuppliersProducts as $itemrequestSuppliersProducts) {
                                 $itemrequestSuppliersProducts->delete();
                             }
                         }
                         else
                         {
                            if($request['suppliers_id'.$i] != 0)
                            {
                                $supplierProducts = SupplierProduct::where('products_id','=',$request['products_id'.$i])->where('suppliers_id','=',$request['suppliers_id'.$i])->first();
                                $requestSuppliersProducts = RequestSupplierProduct::where('requests_id', '=',$request->id)->where('suppliersProducts_id', '=', $supplierProducts->id)->first();
                                if ($requestSuppliersProducts != null) 
                                {
                                    //$requestSuppliersProducts->requests_id => $requests->id != null ? $requests->id : 0;
                                    $requestSuppliersProducts->suppliersProducts_id = $supplierProducts->id != null ? $supplierProducts->id :0;
                                    $requestSuppliersProducts->qty = $request['qty'.$i] != null ? $request['qty'.$i] : 0;
                                }
                                else
                                {
                                    $requestSuppliersProducts = RequestSupplierProduct::create([
                                        'requests_id' => $requests->id != null ? $requests->id : 0,
                                        'suppliersProducts_id' => $supplierProducts->id != null ? $supplierProducts->id :0,
                                        'qty' => $request['qty'.$i] != null ? $request['qty'.$i] : 0
                                    ]);
                                }
                                $requestSuppliersProducts->save();

                                $requestInsDepSupPro = RequestInsDepSupPro::where('requests_id', '=',$request->id)->get();
                                foreach($requestInsDepSupPro as $itemrequestInsDepSupPro) {
                                    $itemrequestInsDepSupPro->delete();
                                }
                            }
                         }
                    }

                    if ($request->addressesid != "" && $request->addressesid != "0") {
                        $address = Address::find($request->addressesid);
                        $address->street = $request->street != null && $request->street != "" ? $request->street : "";
                        $address->externalNumber = $request->externalNumber != null && $request->externalNumber != "" ? $request->externalNumber : "";
                        $address->internalNumber = $request->internalNumber != null && $request->internalNumber != "" ? $request->internalNumber : "";
                        $address->communities_id = $request->communities_id1 != null && $request->communities_id1 != "" ? $request->communities_id1 :  0;
                    }
                    else {
                        $address = Address::create([
                            'street' => $request->street != null && $request->street != "" ? $request->street : "",
                            'externalNumber' => $request->externalNumber != null && $request->externalNumber != "" ? $request->externalNumber : "",
                            'internalNumber' => $request->internalNumber != null && $request->internalNumber != "" ? $request->internalNumber : "",
                            'communities_id' => $request->communities_id1 != null && $request->communities_id1 != "" ? $request->communities_id1 : 0
                        ]);
                    }
                    $address->save();

                    $countBeneficiaries = $request->countBeneficiary;
                    $Beneficiaries = RequestPersonalData::where('requests_id','=',$request->id)->get();
                    $countBeneficiariesBD = $Beneficiaries->count();
                    for($i = 1; $i <= $countBeneficiaries; $i++){
                        if ($request['namebeneficiary'.$i] != null && $request['namebeneficiary'.$i] != "") {
                            $curp = strtoupper($request['curpbeneficiary'.$i]);
                            $personalData = PersonalData::where('curp', '=', $curp)->first();
                            if ($personalData != null) {
                                $personalData->name = $request['namebeneficiary'.$i] != null && $request['namebeneficiary'.$i] != "" ? $request['namebeneficiary'.$i] : "" ;
                                $personalData->lastName = $request['lastNamebeneficiary'.$i] != null && $request['lastNamebeneficiary'.$i] != null ? $request['lastNamebeneficiary'.$i] : "";
                                $personalData->secondLastName = $request['secondLastNamebeneficiary'.$i] != null && $request['secondLastNamebeneficiary'.$i] != "" ? $request['secondLastNamebeneficiary'.$i] : "";
                                $personalData->addresses_id = $address->id != null && $address->id != "" ? $address->id : 0;
                                $personalData->curp = $curp != null && $curp != "" ? $curp : "";
                                $personalData->age = $request['agebeneficiary'.$i] != null && $request['agebeneficiary'.$i] != "" ? $request['agebeneficiary'.$i] : "" ;
                            }else {
                                $personalData = PersonalData::create([
                                    'name' => $request['namebeneficiary'.$i] != null && $request['namebeneficiary'.$i] != "" ? $request['namebeneficiary'.$i] : "" ,
                                    'lastName' => $request['lastNamebeneficiary'.$i] != null && $request['lastNamebeneficiary'.$i] != null ? $request['lastNamebeneficiary'.$i] : "",
                                    'secondLastName' => $request['secondLastNamebeneficiary'.$i] != null && $request['secondLastNamebeneficiary'.$i] != "" ? $request['secondLastNamebeneficiary'.$i] : "",
                                    'addresses_id' => $address->id != null && $address->id != "" ? $address->id : 0,
                                    'curp' => $curp != null && $curp != "" ? $curp : "",
                                    'age' => $request['agebeneficiary'.$i] != null && $request['agebeneficiary'.$i] != "" ? $request['agebeneficiary'.$i] : ""
                                ]);
                            }
                            $personalData->save();

                            $extPersonalData = ExtPersonalData::where('personal_data_id', '=', $personalData->id)->first();
                            if ($extPersonalData != null) {
                                $extPersonalData->civilStatus = $request['civilStatusbeneficiary'.$i] != null && $request['civilStatusbeneficiary'.$i] != "" ? $request['civilStatusbeneficiary'.$i] : "";
                                $extPersonalData->scholarShip = $request['scholarShipbeneficiary'.$i] != null && $request['scholarShipbeneficiary'.$i] != "" ? $request['scholarShipbeneficiary'.$i] : "";
                                $extPersonalData->number = $request['phonenumber'.$i] != null && $request['phonenumber'.$i] != "" ? $request['phonenumber'.$i] : "";
                                $extPersonalData->employments_id = $request['employments_idbeneficiary'.$i] != null && $request['employments_idbeneficiary'.$i] != "" ? $request['employments_idbeneficiary'.$i] : 0;
                                $extPersonalData->personal_data_id = $personalData->id != null && $personalData->id != "" ? $personalData->id : 0;
                            }
                            else {
                                $extPersonalData = ExtPersonalData::create([
                                    'civilStatus' => $request['civilStatusbeneficiary'.$i] != null && $request['civilStatusbeneficiary'.$i] != "" ? $request['civilStatusbeneficiary'.$i] : "",
                                    'scholarShip' => $request['scholarShipbeneficiary'.$i] != null && $request['scholarShipbeneficiary'.$i] != "" ? $request['scholarShipbeneficiary'.$i] : "",
                                    'number' => $request['phonenumber'.$i] != null && $request['phonenumber'.$i] != "" ? $request['phonenumber'.$i] : "",
                                    'employments_id' => $request['employments_idbeneficiary'.$i] != null && $request['employments_idbeneficiary'.$i] != "" ? $request['employments_idbeneficiary'.$i] : 0,
                                    'personal_data_id' => $personalData->id != null && $personalData->id != "" ? $personalData->id : 0
                                ]);

                            }
                            $extPersonalData->save();

                            $requestPersonalData = RequestPersonalData::where('requests_id','=',$request->id)->where('personalData_id', '=', $personalData->id)->first();
                            if ($requestPersonalData != null) {
                                $requestPersonalData->familiar = $i == 0 ? 0: 1;
                                $requestPersonalData->personalData_id = $personalData->id != null && $personalData->id != "" ? $personalData->id : 0;
                                $requestPersonalData->requests_id = $requests->id != null && $requests->id != "" ? $requests->id : 0;
                            }
                            else {
                                $requestPersonalData = RequestPersonalData::create([
                                    'familiar' => $i == 0 ? 0: 1,
                                    'personalData_id' => $personalData->id != null && $personalData->id != "" ? $personalData->id : 0,
                                    'requests_id' => $requests->id != null && $requests->id != "" ? $requests->id : 0
                                ]);
                            }
                            $requestPersonalData->save();

                            $countDB = $request['countDiagnosticBeneficiary'.$i];
                            $rpddisabilities2 = RPDDisabilities::where('requestsPersonalData_id','=',$personalData->id)->get();
                            $countDBBD = $rpddisabilities2->count();
                            $rpddisabilitiesArray = array();
                            for($x = 1; $x <= $countDB; $x++)
                            {
                                if ($request['disabilitycategories'.$i.'_'.$x] != null && $request['disabilitycategories'.$i.'_'.$x] != "") {
                                    $rpddisabilities = RPDDisabilities::where('disability_id', '=', $request['disability'.$i.'_'.$x] )
                                                                    ->where('disabilitycategories_id', '=', $request['disabilitycategories'.$i.'_'.$x])
                                                                    ->where('requestsPersonalData_id', '=', $personalData->id)->first();

                                    if($rpddisabilities != null && $rpddisabilities->count() > 0){
                                        $rpddisabilities->disability_id = $request['disability'.$i.'_'.$x] != null && $request['disability'.$i.'_'.$x] != "" ? $request['disability'.$i.'_'.$x] : "" ;
                                        $rpddisabilities->disabilitycategories_id = $request['disabilitycategories'.$i.'_'.$x] != null && $request['disabilitycategories'.$i.'_'.$x] != "" ? $request['disabilitycategories'.$i.'_'.$x] : "" ;
                                        $rpddisabilities->requestsPersonalData_id =  $requestPersonalData->id != null && $requestPersonalData->id != "" ? $requestPersonalData->id : 0;
                                    }
                                    else {
                                        if($request['disabilitycategories'.$i.'_'.$x] != null){
                                            $rpddisabilities= RPDDisabilities::create([
                                                'disability_id'=> $request['disability'.$i.'_'.$x] != null && $request['disability'.$i.'_'.$x] != "" ? $request['disability'.$i.'_'.$x] : "" ,
                                                'disabilitycategories_id'=>$request['disabilitycategories'.$i.'_'.$x] != null && $request['disabilitycategories'.$i.'_'.$x] != "" ? $request['disabilitycategories'.$i.'_'.$x] : "" ,
                                                'requestsPersonalData_id'=> $requestPersonalData->id != null && $requestPersonalData->id != "" ? $requestPersonalData->id : 0
                                                ]);
                                        }
                                        else{
                                            if($i <= $countDBBD && isset($rpddisabilities[$x-1]))
                                            {
                                                $rpddisabilities[$x-1]->delete();
                                            }
                                        }
                                    }
                                    $rpddisabilities->save();
                                    array_push($rpddisabilitiesArray, $rpddisabilities->id);
                                }
                            }
                            $rpddisabilities2x = RPDDisabilities::where('requestsPersonalData_id','=',$personalData->id)
                                                        ->whereNotIn('id', $rpddisabilitiesArray)
                                                        ->get();
                            foreach($rpddisabilities2x as $row){
                                $row->delete();
                            }
                        }
                    }

                    $countMHs = $request->countMH;
                    $familySituations = FamilySituation::where('requests_id','=',$request->id)->get();
                    $countMHsBD = $familySituations->count();
                    $ConditionsFamilyArray = array();

                    for($i = 1; $i <= $countMHs; $i++){
                        if ($request['name'.$i] != null && $request['name'.$i] != "") {
                            $familysituations = FamilySituation::find($request['ConditionsFamilyid'.$i]);
                            if($familysituations != null && $familysituations->count() > 0){
                                $familysituations->name = $request['name'.$i] != null && $request['name'.$i] != "" ? $request['name'.$i] : "";
                                $familysituations->lastname = $request['lastName'.$i] != null && $request['lastName'.$i] != "" ? $request['lastName'.$i] : "";
                                $familysituations->secondlastname = $request['secondLastName'.$i] != null && $request['secondLastName'.$i] != "" ? $request['secondLastName'.$i] : "";
                                $familysituations->age = $request['age'.$i] != null && $request['age'.$i] != "" ? $request['age'.$i] : "";
                                $familysituations->relationship = $request['relationship'.$i] != null && $request['relationship'.$i] != "" ? $request['relationship'.$i] : "";
                                $familysituations->civilStatus = $request['civilStatus'.$i] != null && $request['civilStatus'.$i] != "" ? $request['civilStatus'.$i] : "";
                                $familysituations->scholarship = $request['scholarShip'.$i] != null && $request['scholarShip'.$i] != "" ? $request['scholarShip'.$i] : "";
                                $familysituations->employments_id = $request['employments_id'.$i];
                                //$familysituations->requests_id => $requests->id
                            }
                            else{
                                if($request['name'.$i] != null){
                                    $familysituations = FamilySituation::create([
                                        'name' => $request['name'.$i] != null && $request['name'.$i] != "" ? $request['name'.$i] : "",
                                        'lastname' => $request['lastName'.$i] != null && $request['lastName'.$i] != "" ? $request['lastName'.$i] : "",
                                        'secondlastname' => $request['secondLastName'.$i] != null && $request['secondLastName'.$i] != "" ? $request['secondLastName'.$i] : "",
                                        'age' => $request['age'.$i] != null && $request['age'.$i] != "" ? $request['age'.$i] : "0",
                                        'relationship' => $request['relationship'.$i] != null && $request['relationship'.$i] != "" ? $request['relationship'.$i] : "",
                                        'civilStatus' => $request['civilStatus'.$i] != null && $request['civilStatus'.$i] != "" ? $request['civilStatus'.$i] : "",
                                        'scholarship' => $request['scholarShip'.$i] != null && $request['scholarShip'.$i] != "" ? $request['scholarShip'.$i] : "",
                                        'employments_id' => $request['employments_id'.$i],
                                        'requests_id' => $requests->id
                                    ]);
                                }
                                else{
                                    if($i <= $countMHsBD && isset($familySituations[$i-1]))
                                    {
                                        $familySituations[$i-1]->delete();
                                    }
                                }
                            }
                            $familysituations->save();
                            array_push($ConditionsFamilyArray, $familysituations->id);
                        }
                    }

                    $familySituations2 = FamilySituation::where('requests_id','=',$request->id)
                                                        ->whereNotIn('id', $ConditionsFamilyArray)
                                                        ->get();
                    foreach($familySituations2 as $row){
                        $row->delete();
                    }

                    $lifeConditions = LifeCondition::where('requests_id','=',$request->id)->first();
                    if ($lifeConditions != null) {
                        $lifeConditions->typeHouse = $request->typeHouse != null && $request->typeHouse != "" ? $request->typeHouse : "";
                        $lifeConditions->number_rooms = $request->number_rooms != null && $request->number_rooms != "" ? $request->number_rooms : 0;
                        $lifeConditions->requests_id = $requests->id != null && $requests->id != "" ? $requests->id : 0;
                    }
                    else {
                        $lifeConditions = LifeCondition::create([
                            'typeHouse' => $request->typeHouse != null && $request->typeHouse != "" ? $request->typeHouse : "",
                            'number_rooms' => $request->number_rooms != null && $request->number_rooms != "" ? $request->number_rooms : 0,
                            'requests_id' => $requests->id != null && $requests->id != "" ? $requests->id : 0
                        ]);
                    }
                    $lifeConditions->save();

                    $countFurnitures = $request->countFurniture;
                    $requestFurniture = RequestFurniture::where('requests_id','=',$request->id)->get();
                    $countFurnituresBD = $requestFurniture->count();
                    $RequestFurnitureArray = array();
                    for($i = 1; $i <= $countFurnitures; $i++){
                        if ($request['furnitures_id'.$i] != null && $request['furnitures_id'.$i] != "") {
                            $requestFurnitures = RequestFurniture::find($request['furnitureid'.$i]);
                            if($requestFurnitures != null && $requestFurnitures->count() > 0) {
                                $requestFurnitures->furnitures_id = $request['furnitures_id'.$i] != null && $request['furnitures_id'.$i] != "" ? $request['furnitures_id'.$i] : 0;
                                //$requestFurnitures->requests_id = $requests->id != null && $requests->id != "" ? $requests->id : 0;
                            }
                            else {
                                if($request['furnitures_id'.$i] != null){
                                    $requestFurnitures = RequestFurniture::create([
                                        'furnitures_id' => $request['furnitures_id'.$i] != null && $request['furnitures_id'.$i] != "" ? $request['furnitures_id'.$i] : 0,
                                        'requests_id' => $requests->id != null && $requests->id != "" ? $requests->id : 0
                                    ]);
                                }
                                else{
                                    if($i <= $countFurnituresBD && isset($requestFurniture[$i-1])) {
                                        $requestFurniture[$w-1]->delete();
                                    }
                                }
                            }
                            $requestFurnitures->save();
                            array_push($RequestFurnitureArray, $requestFurnitures->id);
                        }
                    }
                    $requestFurniture2 = RequestFurniture::where('requests_id','=',$request->id)
                                                        ->whereNotIn('id', $RequestFurnitureArray)
                                                        ->get();
                    foreach($requestFurniture2 as $row){
                        $row->delete();
                    }

                    $countBuildingMaterials = $request->countBuildingMaterial;
                    $requestBuildingMaterial = RequestBuildingMaterial::where('requests_id','=',$request->id)->get();
                    $countBuildingMaterialsBD = $requestFurniture->count();
                    $requestBuildingMaterialArray = array();
                    for($i = 1; $i <= $countBuildingMaterials; $i++){
                        if ($request['buildingMaterials_id'.$i] != null && $request['buildingMaterials_id'.$i] != "") {
                            $requestBuildingMaterials = RequestBuildingMaterial::find($request['buildingmaterialid'.$i]);
                            if($requestBuildingMaterials != null && $requestBuildingMaterials->count() > 0){
                                $requestBuildingMaterials->buildingMaterials_id = $request['buildingMaterials_id'.$i] != null && $request['buildingMaterials_id'.$i] != "" ? $request['buildingMaterials_id'.$i] : 0;
                                //$requestBuildingMaterials->requests_id = $requests->id != null && $requests->id != "" ? $requests->id : 0;
                            }
                            else {
                                if($request['buildingMaterials_id'.$i] != null){
                                    $requestBuildingMaterials = RequestBuildingMaterial::create([
                                        'buildingMaterials_id' => $request['buildingMaterials_id'.$i] != null && $request['buildingMaterials_id'.$i] != "" ? $request['buildingMaterials_id'.$i] : 0,
                                        'requests_id' => $requests->id != null && $requests->id != "" ? $requests->id : 0
                                    ]);
                                }
                                else{
                                    if($i <= $countBuildingMaterialsBD && isset($requestBuildingMaterial[$i-1])) {
                                        $requestBuildingMaterial[$i-1]->delete();
                                    }
                                }
                            }
                            $requestBuildingMaterials->save();
                            array_push($requestBuildingMaterialArray, $requestBuildingMaterials->id);
                        }
                    }
                    $requestBuildingMaterial2 = RequestBuildingMaterial::where('requests_id','=',$request->id)
                                                        ->whereNotIn('id', $requestBuildingMaterialArray)
                                                        ->get();
                    foreach($requestBuildingMaterial2 as $row){
                        $row->delete();
                    }

                    $countServices = $request->countService;
                    $requestService = RequestService::where('requests_id','=',$request->id)->get();
                    $countServicesBD = $requestService->count();
                    $requestServiceArray = array();
                    for($i = 1; $i <= $countServices; $i++){
                        if ($request['services_id'.$i] != null && $request['services_id'.$i] != "") {
                            $requestServices = RequestService::find($request['servicesid'.$i]);
                            if($requestServices != null && $requestServices->count() > 0){
                                $requestServices->services_id = $request['services_id'.$i] != null && $request['services_id'.$i] != "" ? $request['services_id'.$i] : 0;
                                //$requestServices->requests_id = $requests->id != null && $requests->id != "" ? $requests->id : 0;
                            }
                            else {
                                if($request['services_id'.$i] != null){
                                    $requestServices = RequestService::create([
                                        'services_id' => $request['services_id'.$i] != null && $request['services_id'.$i] != "" ? $request['services_id'.$i] : 0,
                                        'requests_id' => $requests->id != null && $requests->id != "" ? $requests->id : 0
                                    ]);
                                }
                                else{
                                    if($i <= $countServicesBD && isset($requestService[$i-1])) {
                                        $requestService[$i-1]->delete();
                                    }
                                }

                            }
                            $requestServices->save();
                            array_push($requestServiceArray, $requestServices->id);
                        }
                    }
                    $requestServices2 = RequestService::where('requests_id','=',$request->id)
                                                        ->whereNotIn('id', $requestServiceArray)
                                                        ->get();
                    foreach($requestServices2 as $row){
                        $row->delete();
                    }

                    $economicData = EconomicData::where('requests_id','=',$request->id)->first();
                    if ($economicData != null) {
                        $economicData->income = $request->income != null &&  $request->income != "" ? $request->income : "";
                        $economicData->expense = $request->expense != null && $request->expense != "" ? $request->expense : "";
                        //$economicData->requests_id = $requests->id != null && $requests->id != "" ? $requests->id : 0;
                    }
                    else {
                        $economicData = EconomicData::create([
                            'income' => $request->income != null &&  $request->income != "" ? $request->income : "",
                            'expense' => $request->expense != null && $request->expense != "" ? $request->expense : "",
                            'requests_id' => $requests->id != null && $requests->id != "" ? $requests->id : 0
                        ]);
                    }
                    $economicData->save();

                return redirect('solicitudes');
                    break;

                case 'saveWORUpdate':
                    return "si entra a savework";
                    break;

                case 'update':
            
                    // if($request->file('petitionerImage') != ''){
                    //     $petitionerImageFile = $request->file('petitionerImage');
                    //     $imageName = 'solicitante-'.$petitionerImageFile->getClientOriginalName();
                    //     Storage::disk('local')->put($imageName,  \File::get($petitionerImageFile));
                    // }

                    if($request->file('petitionerImage') != '')
                    {
                        $petitionerImageFile = $request->file('petitionerImage');
                        $imageName = $petitionerImageFile->getClientOriginalName();
                        Storage::disk('local')->put($imageName,  \File::get($petitionerImageFile));
                    }
                    
                    $applicant=Requisition::find($request->id);
                    $applicant->type=$request->type;
                    $applicant->description=$request->reason;
                    $applicant->petitioner=$request->petitioner;
                    //dd($request->lblpetitionerImage);
                    //$applicant->image = $request->lblpetitionerImage;
                    $applicant->image = $request->petitionerImage != null && $request->petitionerImage != "" && $request->petitionerImage != $applicant->image ? $request->petitionerImage : $applicant->image;
                    $applicant->users_id=session('user_id');
                    $applicant->categories_id=$request->categories_id;
                    $applicant->supports_id=$request->supports_id;
                    $applicant->curpPetitioner=$request->curpPetitioner1;
                    $applicant->date=$request->date;
                    $applicant->area=$request->area;
                    $applicant->status_id=1;
                    $applicant->save();

                    if ($request->type == "ts")
                    {
                        $products = RequestInsDepSupPro::where('requests_id', '=',$request->id)->first();
                        $priceProduct = $products->price;
                    }
                    else
                    {
                        $products = RequestSupplierProduct::where('requests_id','=',$request->id)->first();
                        $priceProduct = SupplierProduct::where('id','=',$products->suppliersProducts_id )->first();
                        $priceProduct->products_id = $request->products_id1;
                        $priceProduct->suppliers_id = $request->suppliers_id1;
                        $priceProduct->save();
                    }
                    $products->qty = $request->qty1;
                    $products->save();

                    $personalDataR=RequestPersonalData::where('requests_id','=',$request->id)->get();
                    $countPDR =  $personalDataR->count();
                    $arrayPersonalDataR = array();
                    $countPersonalDataInput = $request->countBeneficiary;

                    for($g = 1; $g<=$countPersonalDataInput; $g++){
                        if($request['namebeneficiary'.$g] != null){
                            if($g <= $countPDR){
                                $SaveFamilySituations= $personalDataR[$g-1];
                                $SaveFamilySituations1 = PersonalData::find($SaveFamilySituations->personalData_id);
                                $SaveFamilySituations1->curp = $request['curpbeneficiary'.$g];
                                $SaveFamilySituations1->name  = $request['namebeneficiary'.$g];
                                $SaveFamilySituations1->lastName  = $request['lastNamebeneficiary'.$g];
                                $SaveFamilySituations1->secondLastName  = $request['secondLastNamebeneficiary'.$g];
                                $SaveFamilySituations1->age  = $request['agebeneficiary'.$g];
                                $SaveFamilySituations1->save();

                                $address = Address::find($SaveFamilySituations1->addresses_id);
                                $address->id = $SaveFamilySituations1->addresses_id;
                                $address->street = $request->street;
                                $address->internalNumber=$request->internalNumber;
                                $address->externalNumber=$request->externalNumber;
                                $address->communities_id=$request->communities_id1;
                                $address->save();

                                $extPersonalData= ExtPersonalData::where('personal_data_id','=', $SaveFamilySituations->id)->first();
                                $extPersonalData->civilStatus = $request['civilStatusbeneficiary'.$g];
                                $extPersonalData->scholarShip = $request['scholarShipbeneficiary'.$g];
                                $extPersonalData->number = $request['phonenumber'.$g];
                                $extPersonalData->employments_id = $request['employments_idbeneficiary'.$g];
                                $extPersonalData->save();

                                $qtyCountDiagnostic = $request['countDiagnosticBeneficiary'.$g];
                                $disabilities = RPDDisabilities::where('requestsPersonalData_id','=', $SaveFamilySituations->id)->get();
                                $countRPD= $disabilities->count();
                                for($f = 1; $f<=$qtyCountDiagnostic; $f++){
                                    if($request['disabilitycategories'.$g.'_'.$f] != null){
                                        if($f<=$countRPD){
                                            $disabilities[$f-1]->disability_id = $request['disability'.$g.'_'.$f];
                                            $disabilities[$f-1]->disabilitycategories_id = $request['disabilitycategories'.$g.'_'.$f];
                                            $disabilities[$f-1]->save();
                                        }else{
                                            $personalDataR1=RequestPersonalData::where('requests_id','=',$request->id)->get();
                                            $SaveFamilySituations12= $personalDataR1[$g-1];
                                            $insertRPD = RPDDisabilities::create([
                                                'disability_id' => $request['disability'.$g.'_'.$f],
                                                'disabilitycategories_id'=> $request['disabilitycategories'.$g.'_'.$f],
                                                'requestsPersonalData_id'=> $SaveFamilySituations12->personalData_id
                                               ]);

                                            }
                                    }
                                    else{
                                        if($f <= $countRPD && isset($disabilities[$f-1])){
                                            $disabilities[$f-1]->delete();
                                        }

                                    }
                                }
                            }else{
                                $personalDataR=RequestPersonalData::where('requests_id','=',$request->id)->first();
                                $SaveFamilySituations1 = PersonalData::find($personalDataR->personalData_id);
                                        $insertarConditionFamily = PersonalData::create([
                                    'curp'=>$request['curpbeneficiary'.$g],
                                    'name'=>$request['namebeneficiary'.$g],
                                    'lastName'=>$request['lastNamebeneficiary'.$g],
                                    'secondLastName'=>$request['secondLastNamebeneficiary'.$g],
                                    'age'=>$request['agebeneficiary'.$g],
                                    'addresses_id'=>$SaveFamilySituations1->addresses_id
                                ]);
                                $insertarConditionFamily->save();

                                $insertExtPersonalData = ExtPersonalData::create([
                                    'civilStatus'=>$request['civilStatusbeneficiary'.$g],
                                    'scholarShip'=>$request['scholarShipbeneficiary'.$g],
                                    'number'=>$request['phonenumber'.$g],
                                    'personal_data_id'=> $insertarConditionFamily->id,
                                    'employments_id'=>$request['employments_idbeneficiary'.$g],

                                ]);
                                $insertExtPersonalData->save();

                                $insertRPD = RequestPersonalData::create([
                                    'requests_id'=>$request->id,
                                    'personalData_id'=>$insertarConditionFamily->id,
                                    'familiar' => '1'
                                ]);
                                $insertRPD->save();

                                $countDisa = $request->countDiagnosticBeneficiary.$g;
                                for($r=1 ; $r <=$countDisa; $r++){
                                    $insertDisabilties = RPDDisabilities::create([
                                        'disability_id'=>$request['disabilitycategories'.$g.'_'.$r],
                                        'disabilitycategories_id'=>$request['disability'.$g.'_'.$r],
                                        'requestsPersonalData_id'=>$insertRPD->id
                                    ]);
                                    $insertDisabilties->save();
                                }
                           }
                        }
                        else{
                            if($g <= $countPersonalDataInput && isset($personalDataR[$g-1])) {
                                $phoneNumberSupplier = RequestPersonalData::find($personalDataR[$g-1]->id);
                                $SaveFamilySituations1 = PersonalData::find($phoneNumberSupplier->personalData_id);
                                $insertDisabilties = RPDDisabilities::where('requestsPersonalData_id','=', $phoneNumberSupplier->id);
                                $insertExtPersonalData = ExtPersonalData::where('personal_data_id','=',$SaveFamilySituations1->id);
                                $insertDisabilties->delete();
                                $insertExtPersonalData->delete();
                                $SaveFamilySituations1->delete();
                                $phoneNumberSupplier->delete();

                            }
                        }
                    }

                    $familySituations = FamilySituation:: where('requests_id','=',$request->id)->get();
                  
                    $qtyFamily = $familySituations->count();
                    $countFamily = $request->countMH;

                    for($i = 1; $i<=$countFamily; $i++){
                        if($request['name'.$i] != null){
                            if($i <= $qtyFamily) {
                                $SaveFamilySituations= $familySituations[$i-1];
                                $SaveFamilySituations1 = FamilySituation::find($SaveFamilySituations->id);
                                $SaveFamilySituations1->id = $SaveFamilySituations->id;
                                $SaveFamilySituations1->name = $request['name'.$i];
                                $SaveFamilySituations1->lastname  = $request['lastName'.$i];
                                $SaveFamilySituations1->secondlastname  = $request['secondLastName'.$i];
                                $SaveFamilySituations1->age  = $request['age'.$i];
                                $SaveFamilySituations1->relationship  = $request['relationship'.$i];
                                $SaveFamilySituations1->civilStatus  = $request['civilStatus'.$i];
                                $SaveFamilySituations1->scholarship  = $request['scholarShip'.$i];
                                $SaveFamilySituations1->employments_id  = $request['employments_id'.$i];
                                $SaveFamilySituations1->save();
                            }
                            else{
                                $insertarConditionFamily = FamilySituation::create([
                                    'name'=>$request['name'.$i],
                                    'lastname'=>$request['lastName'.$i],
                                    'secondlastname'=>$request['secondLastName'.$i],
                                    'age'=>$request['age'.$i],
                                    'relationship'=>$request['relationship'.$i],
                                    'civilStatus'=>$request['civilStatus'.$i],
                                    'scholarship'=>$request['scholarShip'.$i],
                                    'employments_id'=>$request['employments_id'.$i],
                                    'requests_id'=>$request->id

                                ]);
                                $insertarConditionFamily->save();
                            }
                        }
                        else{
                            if($i <= $countFamily && isset($familySituations[$i-1])) {
                                $phoneNumberSupplier = FamilySituation::find($familySituations[$i-1]->id);
                                $phoneNumberSupplier->delete();
                            }
                        }
                    }
                    $MueblesRequest = RequestFurniture::where('requests_id','=',$request->id)->get();
                    $qtyMueblesRequest = $MueblesRequest->count();
                    $CountMueblesIn= $request->countFurniture;

                    for($z = 1; $z<=$CountMueblesIn; $z++){
                        if($request['furnitures_id'.$z] != null){
                            if($z <= $qtyMueblesRequest){
                                $SaveMuebles= $MueblesRequest[$z-1];
                                $SaveMuebles1 = RequestFurniture::find( $SaveMuebles->id);
                                $SaveMuebles1->id = $MueblesRequest[$z-1]->id;
                                $SaveMuebles1->furnitures_id = $request['furnitures_id'.$z];

                                $SaveMuebles1->save();
                            }else{
                                $MueblesCreate = RequestFurniture::create([
                                    'requests_id' => $request->id,
                                    'furnitures_id' => $request['furnitures_id'.$z]
                                ]);
                                $MueblesCreate->save();
                            }
                        }else{
                            if($z <= $CountMueblesIn && isset($MueblesRequest[$z-1])){
                                $phoneNumberSupplier = RequestFurniture::find($MueblesRequest[$z-1]->id);
                                $phoneNumberSupplier->delete();
                            }
                        }
                    }

                    $MaterialRequest = RequestBuildingMaterial::where('requests_id','=',$request->id)->get();
                    $qtyMaterialRequest = $MaterialRequest->count();
                    $CountmaterialIn= $request->countBuildingMaterial;

                    for($q = 1; $q<=$CountmaterialIn; $q++){
                        if($request['buildingMaterials_id'.$q] != null){
                            if($q <= $qtyMaterialRequest){
                                    $SaveMaterial= $MaterialRequest[$q-1];
                                    $SaveMaterial1 = RequestBuildingMaterial::find( $SaveMaterial->id);
                                    $SaveMaterial1->id = $MaterialRequest[$q-1]->id;
                                    $SaveMaterial1->buildingMaterials_id = $request['buildingMaterials_id'.$q];

                                    $SaveMaterial1->save();
                            }else{
                                $MueblesCreate = RequestBuildingMaterial::create([
                                    'requests_id' => $request->id,
                                    'buildingMaterials_id' => $request['buildingMaterials_id'.$q]
                                ]);
                                $MueblesCreate->save();
                            }
                        }
                        else{
                            if($q <= $CountmaterialIn && isset($MaterialRequest[$q-1])){
                                $phoneNumberSupplier = RequestBuildingMaterial::find($MaterialRequest[$q-1]->id);
                                $phoneNumberSupplier->delete();

                            }
                        }
                    }

                    $ServicesRequest = RequestService::where('requests_id','=',$request->id)->get();
                    $qtyServicesRequest = $ServicesRequest->count();
                    $CountServicesIn= $request->countService;

                    for($w = 1; $w<=$CountServicesIn; $w++){
                        if($request['services_id'.$w] != null){
                            if($w <=  $qtyServicesRequest){
                                $SaveMaterial= $ServicesRequest[$w-1];
                                $SaveMaterial1 = RequestService::find( $SaveMaterial->id);
                                $SaveMaterial1->id = $ServicesRequest[$w-1]->id;
                                $SaveMaterial1->services_id = $request['services_id'.$w];

                                $SaveMaterial1->save();
                            }else{
                                $MueblesCreate = RequestService::create([
                                    'requests_id' => $request->id,
                                    'services_id' => $request['services_id'.$w]
                                ]);
                                $MueblesCreate->save();
                            }
                        }else{
                            if($w <= $CountServicesIn && isset($ServicesRequest[$w-1])){
                                $phoneNumberSupplier = RequestService::find($ServicesRequest[$w-1]->id);
                                $phoneNumberSupplier->delete();
                            }
                        }
                    }

                    $economicData = EconomicData::where('requests_id','=',$request->id)->first();
                    $economicData->income = $request->income;
                    $economicData->expense= $request->expense;
                    $economicData->requests_id=$request->id;
                    $economicData->save();

                    return redirect('solicitudes');
                break;

                case 'new':

                    $requestCount = Requisition::all()->count();
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString='';
                    for ($i = 0; $i < 7; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }

                    $folio = 'R'.$randomString.$requestCount;

                    if($request->file('petitionerImage') != ''){
                        $petitionerImageFile = $request->file('petitionerImage');
                        $imageName = 'solicitante-'.$petitionerImageFile->getClientOriginalName();
                        Storage::disk('local')->put($imageName,  \File::get($petitionerImageFile));
                    }

                    $curpPetitioner = strtoupper($request->curpPetitioner1);
                    $requests = Requisition::create([
                        'folio' => $folio,
                        'petitioner' => $request->petitioner,
                        'curpPetitioner' => $curpPetitioner,
                        'beneficiary' => 0,
                        'type' => $request->type,
                        'supports_id' => $request->supports_id,
                        'categories_id' => $request->categories_id,
                        'description' => $request->reason,
                        'image' => $request->petitionerImage,
                        'users_id' => session('user_id'),
                        'usersAuth_id' => session('user_id'),
                        'status_id' => 1,
                        'date' => $request->date,
                        'departments_institutes_id' => session('department_institute_id'),
                        'area' => $request->area
                    ]);
                    $requests->save();

                    $countProducts = $request->countProduct;

                    for($i = 1; $i <= $countProducts; $i++){
                        if($request['suppliers_id'.$i] != 0){
                            $supplierProducts = SupplierProduct::where('products_id','=',$request['products_id'.$i])->where('suppliers_id','=',$request['suppliers_id'.$i])->first();

                            $requestSuppliersProducts = RequestSupplierProduct::create([
                                'requests_id' => $requests->id,
                                'suppliersProducts_id' => $supplierProducts->id,
                                'qty' => $request['qty'.$i]
                            ]);
                            $requestSuppliersProducts->save();
                        } else{
                            $requestInsDepSupPro = RequestInsDepSupPro::create([
                                'requests_id' => $requests->id,
                                'products_id'=> $request['products_id'.$i],
                                'qty' => $request['qty'.$i],
                                'price' => $request['unitPrice'.$i]
                            ]);
                            $requestInsDepSupPro->save();
                        }
                    }

                    $address = Address::create([
                        'street' => $request->street,
                        'externalNumber' => $request->externalNumber,
                        'internalNumber' => $request->internalNumber,
                        'communities_id' => $request->communities_id1
                    ]);
                    $address->save();

                    $countBeneficiaries = $request->countBeneficiary;

                    for($i = 1; $i <= $countBeneficiaries; $i++){
                        if($request['namebeneficiary'.$i] != null){
                            $curp = strtoupper($request['curpbeneficiary'.$i]);
                            $personalData = PersonalData::create([
                                'name' => $request['namebeneficiary'.$i],
                                'lastName' => $request['lastNamebeneficiary'.$i],
                                'secondLastName' => $request['secondLastNamebeneficiary'.$i],
                                'addresses_id' => $address->id,
                                'curp' => $curp,
                                'age' => $request['agebeneficiary'.$i]
                            ]);
                            $personalData->save();

                            $extPersonalData = ExtPersonalData::create([
                                'civilStatus' => $request['civilStatusbeneficiary'.$i],
                                'scholarShip' => $request['scholarShipbeneficiary'.$i],
                                'number' => $request['phonenumber'.$i],
                                'employments_id' => $request['employments_idbeneficiary'.$i],
                                'personal_data_id' => $personalData->id
                            ]);
                            $extPersonalData->save();

                            if($i == 0){
                                $requestPersonalData = RequestPersonalData::create([
                                    'familiar' => 0,
                                    'personalData_id' => $personalData->id,
                                    'requests_id' => $requests->id
                                ]);
                                $requestPersonalData->save();
                            }
                            else{
                                $requestPersonalData = RequestPersonalData::create([
                                    'familiar' => 1,
                                    'personalData_id' => $personalData->id,
                                    'requests_id' => $requests->id
                                ]);
                                $requestPersonalData->save();
                            }

                            $countTBD= $request['countDiagnosticBeneficiary'.$i];

                            for($x = 1; $x <= $countTBD; $x++)
                            {
                                if($request['disability'.$i.'_'.$x] != null){
                                    $rpddisabilities= RPDDisabilities::create([
                                        'disability_id'=> $request['disability'.$i.'_'.$x] != null && $request['disability'.$i.'_'.$x] != "" ? $request['disability'.$i.'_'.$x] : "" ,
                                        'disabilitycategories_id'=>$request['disabilitycategories'.$i.'_'.$x] != null && $request['disabilitycategories'.$i.'_'.$x] != "" ? $request['disabilitycategories'.$i.'_'.$x] : "" ,
                                        'requestsPersonalData_id'=> $requestPersonalData->id != null && $requestPersonalData->id != "" ? $requestPersonalData->id : 0
                                        ]);
                                    $rpddisabilities->save();
                                }
                            }
                        }
                    }

                    $countMHs = $request->countMH;

                    for($i = 1; $i <= $countMHs; $i++){
                        if($request['name'.$i] != null){
                            $familysituations = FamilySituation::create([
                                'name' => $request['name'.$i],
                                'lastname' => $request['lastName'.$i],
                                'secondlastname' => $request['secondLastName'.$i],
                                'age' => $request['age'.$i],
                                'relationship' => $request['relationship'.$i],
                                'civilStatus' => $request['civilStatus'.$i],
                                'scholarship' => $request['scholarShip'.$i],
                                'employments_id' => $request['employments_id'.$i],
                                'requests_id' => $requests->id
                            ]);
                            $familysituations->save();
                        }
                    }

                    $lifeConditions = LifeCondition::create([
                        'typeHouse' => $request->typeHouse,
                        'number_rooms' => $request->number_rooms,
                        'requests_id' => $requests->id
                    ]);
                    $lifeConditions->save();

                    $countFurnitures = $request->countFurniture;

                    for($i = 1; $i <= $countFurnitures; $i++){
                        if($request['furnitures_id'.$i] != null){
                            $requestFurnitures = RequestFurniture::create([
                                'furnitures_id' => $request['furnitures_id'.$i],
                                'requests_id' => $requests->id
                            ]);
                            $requestFurnitures->save();
                        }
                    }

                    $countBuildingMaterials = $request->countBuildingMaterial;

                    for($i = 1; $i <= $countBuildingMaterials; $i++){
                        if($request['buildingMaterials_id'.$i] != null){
                            $requestBuildingMaterial = RequestBuildingMaterial::create([
                                'buildingMaterials_id' => $request['buildingMaterials_id'.$i],
                                'requests_id' => $requests->id
                            ]);
                            $requestBuildingMaterial->save();
                        }
                    }

                    $countServices = $request->countService;

                    for($i = 1; $i <= $countServices; $i++){
                        if($request['services_id'.$i] != null){
                            $requestServices = RequestService::create([
                                'services_id' => $request['services_id'.$i],
                                'requests_id' => $requests->id
                            ]);
                            $requestServices->save();
                        }
                    }
                    $economicData = EconomicData::create([
                        'income' => $request->income,
                        'expense' => $request->expense,
                        'requests_id' => $requests->id
                    ]);
                    $economicData->save();

                    return redirect('/solicitudes');
                    // return redirect('generardocumento/'.$requests->id);
                break;

                case 'checkCurp':
                    $countRrequi = 0;
                    if($request->curpbeneficiary != null){
                        $curp = strtoupper($request->curpbeneficiary);
                        $data = array();
                        $datosGenerales = array();
                        $dataFull = array();
                        $exist = false;
                        $today = New Datetime();
                        $lastMonth = $today->modify('-1 month');
                        $now = New Datetime();
                        $lastMonth = date_format($lastMonth, 'Y-m-d');
                        $now = date_format($now, 'Y-m-d');

                        $session = session('department_institute_id');
                                               
                        $requisition = Requisition::leftJoin('requests_personal_data as rPD','requests.id','=','rPD.requests_id')
                                                 ->join('personalData as PD', 'rPD.personalData_id','PD.id')
                                                 ->join('vrequests_suppliersproducts as rSP','requests.id','rSP.requests_id')
                                                 //->join('suppliers_products as sP', 'rSP.suppliersProducts_id','sP.id')
                                                 ->join('products as P','rsP.products_id','P.id')
                                                 ->join('departments_institutes as dI','requests.departments_institutes_id','dI.id')
                                                 ->join('institutes as I','dI.institutes_id','I.id')
                                                 ->where('requests.curpPetitioner','=',$curp)
                                                 ->where('requests.date','>=', $lastMonth)
                                                 ->where('requests.date','<=', $now)
                                                 //->distinct()
                                                 ->get();       

                         //dd($requisition);
                        if(isset($requisition) && $requisition->count() > 0)
                        {
                            foreach($requisition as $key=>$value)
                            {
                                $today = New Datetime();
                                $fecha1 = new DateTime($value->date);
                                $interval = $fecha1->diff($today);
                              //$requestid = $value->id;
                                $requestid = $value->requests_id;
                                $petitioner = $value->petitioner;
                                $findRPersonalData = RequestPersonalData::where('personalData_id','=',$requestid)->first();
                                $findPersonalData= PersonalData::where('id','=',$findRPersonalData->personalData_id)->first();
                                $addresses= Address::where('id','=',$findPersonalData->addresses_id)->first();
                                $community = Community::where('id','=',$addresses->communities_id)->first();
                                $municipality = Municipality::where('id','=',$community->municipalities_id)->first();
                                $states =  State::where('id','=',$municipality->states_id)->first();
                                $area = $value->area;
                                $findExtPersonalData= ExtPersonalData::where('personal_data_id','=',$findPersonalData->id)->first();
                              //$requestSupplier = vRequestSupplierProduct::where('requests_id','=',$requestid)->first();
                                $vRequestSupplierProduct = vRequestSupplierProduct::where('requests_id','=',$requestid)->first();
                              //dd($vRequestSupplierProduct);                                 
                              //$SupplierProductID = SupplierProduct::where('id','=',$requestSupplier->suppliersProducts_id)->first();
                              // $SupplierProductID = SupplierProduct::where('id','=',$vRequestSupplierProduct->suppliersProducts_id)->first();
                                $products = Product::where('id','=', $vRequestSupplierProduct->products_id)->first();
                                $departamentid = $value->departments_institutes_id;
                                $instituteID = DepartmentInstitute::find($departamentid);
                                $instituteName = Institute::find($instituteID->institutes_id);
                                $departmentName = Department::find($instituteID->departments_id);
                                
                                //dd($departmentName);
                                if($interval->y >= 1 )
                                {
                                    $exist = false;
                                }
                                elseif($interval->m < 1) 
                                {
                                    // array_push($datosGenerales,$findPersonalData);
                                    // array_push($datosGenerales,$products->name);
                                    // array_push($datosGenerales,$fecha1);
                                    // array_push($datosGenerales,$petitioner);
                                    // array_push($datosGenerales,$instituteName,);
                                    // array_push($datosGenerales,$departmentName);
                                    // $data['DatosGenerales'] = $datosGenerales;
                                    
                                    $data['requisition0']=$requestid;
                                    $data['requisition1']=$requestid;
                                    $data['Usuario'.$key]=$petitioner;
                                    $data['CualSolicitante'.$key]=$curp;
                                    $data['Apoyo'.$key]= $products->name;
                                    $data['date'.$key] = date_format($fecha1,'Y-m-d');
                                    $data['institute'.$key]=$instituteName->name;
                                    $data['Departament'.$key]=$departmentName->name;
                                    $data['EdadBeneficiario'.$key]=$findPersonalData->age;
                                    $data['TelBeneficiario'.$key]=$findExtPersonalData->number;
                                    $data['NomBeneficiario'.$key]=$findPersonalData->name;
                                    $data['APBeneficiario'.$key]=$findPersonalData->lastName;
                                    $data['SLNBeneficiario'.$key]=$findPersonalData->secondLastName;
                                    $data['calle'.$key]=$addresses->street;
                                    $data['numext'.$key]=$addresses->externalNumber;
                                    $data['numint'.$key]=$addresses->internalNumber;
                                    $data['EcivilBeneficiario'.$key]=$findExtPersonalData->civilStatus;
                                    $data['EscBeneficiario'.$key]=$findExtPersonalData->scholarShip;
                                    $data['OcuBeneficiario'.$key]=$findExtPersonalData->employments_id;
                                    $data['CPBeneficiario'.$key]=$community->postalCode;
                                    $data['idColBen'.$key]=$community->id;
                                    $data['ColBeneficiario'.$key]=$community->name;
                                    $data['idMpioBen'.$key]=$municipality->id;
                                    $data['MpioBeneficiario'.$key]=$municipality->name;
                                    $data['idStateBen'.$key]=$states->id;
                                    $data['StateBeneficiario'.$key]=$states->name;
                                    $data['areaBeneficiario'.$key]=$area;
                                    $countRrequi++;
                                    $exist = true;
                                    
                                }
                            }
                        }else
                        {
                            $personalData = PersonalData::where('curp','=', $curp)->get();
                            if(isset($personalData) && $personalData->count() > 0)
                            {
                                //$data['personalData'] = $personalData[0];
                                foreach($personalData as $keys=>$value)
                                {
                                    $requisitionPersonalData = RequestPersonalData::where('personalData_id','=',$value->id)->get();
                                    if(isset($requisitionPersonalData) && $requisitionPersonalData->count() > 0)
                                    {
                                        foreach($requisitionPersonalData as $keysis=>$element)
                                        {
                                            $requisition = Requisition::find($element->requests_id);
                                            if(isset($requisition))
                                            {
                                                $today = New Datetime();
                                                $fecha1 = new DateTime($requisition->date);
                                                $interval = $fecha1->diff($today);
                                                $requestid1 = $requisition->id;
                                                $petitioner = $requisition->petitioner;
                                                $instituteID = DepartmentInstitute::find($requisition->departments_institutes_id);
                                                $instituteName = Institute::find($instituteID->institutes_id);
                                                $departmentName = Department::find($instituteID->departments_id);
                                                $findRPersonalData = RequestPersonalData::where('personalData_id','=',$requestid1)->first();
                                                if ($requisition->type = 'ts')
                                                {
                                                    $requestinsdepsuppro = RequestInsDepSupPro::where('requests_id','=',$findRPersonalData->requests_id)->first();
                                                    $products = Product::where('id','=',$requestinsdepsuppro->products_id)->first();
                                                }
                                                else
                                                {
                                                    $requestSupplier = RequestSupplierProduct::where('requests_id','=',$findRPersonalData->requests_id)->first();
                                                    $SupplierProductID = SupplierProduct::where('id','=',$requestSupplier->suppliersProducts_id)->first();
                                                    $products = Product::where('id','=',$SupplierProductID->products_id)->first();
                                                }
                                                if($interval->y >= 1)
                                                {
                                                    $exist = false;
                                                }
                                                elseif($interval->m < 1)
                                                {
                                                    $data['requisition0']=$requestid1;
                                                    $data['requisition1']=$requestid1;
                                                    $data['Usuario'.$keysis]=$petitioner;
                                                    $data['CualSolicitante'.$keysis]=$curp;  //$requisition->curpPetitioner;
                                                    $data['Apoyo'.$keysis]= $products->name;
                                                    $data['date'.$keysis] =date_format($fecha1,'Y-m-d');                                                    
                                                    $data['institute'.$keysis]=$instituteName->name;
                                                    $data['Departament'.$keysis]=$departmentName->name;
                                                 
                                                    $countRrequi++;
                                                    $exist = true;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if($exist)
                        {
                            $text = 'Este usuario ya recibio un apoyo dentro del mes';
                            $id = 1;
                            $message = array('text' => $text, 'exist' => $id);
                            $data['message'] = $message;
                            $data['cantidad']= $countRrequi;
                            array_push($dataFull,$data);
                        }
                        else
                        {
                            $text = 'Este usuario NO ha recibido un apoyo dentro del mes';
                            $id = 0;
                            $message = array('text' => $text, 'exist' => $id);
                            $data['message'] = $message;
                            array_push($dataFull,$data);
                        }
                        
                        //dd($data);

                        return $dataFull;
                    }
                    break;

                case 'uploadImage':
                    $folderPath = public_path('assets/img/petitioners/');
                    $image_parts = explode(";base64,", $request->image);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);

                    $imageName = $request->nameImage;

                    $imageFullPath = $folderPath.$imageName;

                    file_put_contents($imageFullPath, $image_base64);
                    return "hola";
                    break;

                case 'getData':
                    $communities = Community::where('postalCode','=',$request->postalCode)->get();
                    $data = array();
                    if($communities->count() != 0){
                        foreach($communities as $community) {
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

                case 'getCategories':
                    $supportProducts = SupportProduct::where('supports_id', '=', $request->support)->get();
                    $categories = [];
                    foreach($supportProducts as $value){
                        $category = Category::find($value->categories_id);
                        array_push($categories, $category);
                    }
                    return $categories;
                break;

                case 'getSuppliers':
                    $products = Product::where('categories_id', '=', $request->category)->get();
                    $suppliers= [];
                    $existSup = true;
                     if($request->type != 'ts'){
                        if($products->count() > 0){
                            foreach($products as $value){
                                $supportProducts = SupplierProduct::where('products_id', '=', $value->id)->get();
                                if($supportProducts->count()>0){
                                    foreach($supportProducts as $sPdts){
                                        $supplier = Supplier::find($sPdts->suppliers_id);
                                        if($suppliers != null){
                                            if($supplier != null){
                                                foreach($suppliers as $valueSup){
                                                    if($supplier->id == $valueSup->id){
                                                        $existSup = true;
                                                        break;
                                                    }
                                                    else{
                                                        $existSup = false;
                                                    }

                                                }
                                            }
                                        }
                                        else{
                                            if($supplier != null)
                                                array_push($suppliers,$supplier);
                                        }
                                        if(!$existSup){
                                            array_push($suppliers,$supplier);
                                        }
                                    }
                                }
                            }
                        }
                     }
                    return $suppliers;
                break;

                case 'getDisabilities':
                    if($request->categoryDisability != "" && $request->categoryDisability != null){
                        $disabilities = Disabilities::where('disabilitycategories_id','=',$request->categoryDisability)->get();
                    }
                    return $disabilities;
                break;

                case "getProducts":
                    if($request->supplier == "0"){
                        $products = Product::where('categories_id','=',$request->category)->get();
                    }
                    else{
                        $products = [];
                        $supplierProducts = SupplierProduct::where('suppliers_id', '=', $request->supplier)->get();
                        foreach($supplierProducts as $supplierProduct){
                            $product = Product::find($supplierProduct->products_id);
                            if($product->categories_id == $request->category){
                                array_push($products, $product);
                            }
                        }
                    }
                    return $products;
                break;

                case "getPrice":
                    $price = "";
                    if($request->supplier != "0"){
                        $supplierProducts = SupplierProduct::where('products_id','=',$request->product)->where('suppliers_id','=',$request->supplier)->first();
                        $price = $supplierProducts->price;
                    }
                    return $price;
                break;

                case 'getFurnitures':
                    $furnitures = Furniture::all();
                    return $furnitures;
                break;

                case 'getEmployments':
                    $Employments = Employment::all();
                    return $Employments;
                break;

                case 'getBuildingMaterials':
                    $buildingMaterials = BuildingMaterial::all();
                    return $buildingMaterials;
                break;

                case 'getServices':
                    $services = Service::all();
                    return $services;
                break;
                
                case 'getInformation':
                    $employments = Employment::all();
                    $categoryDisabilities = DisabilityCategories::all();

                    $data = array(
                        'employments' => $employments,
                        'categoryDisabilities' => $categoryDisabilities
                    );
                    return $data;
                    break;
                case 'newProduct':

                    break;

            }
            return array();
    }

    public function statusChange($folio = null){
        $statusreq = Status::find($folio);
        $status = $statusreq->name;
        return $status;
    }

    public function requests(Request $request)
    {   
        switch($request->input('action'))
        {
        case "query":
          $requests = Requisition::where('departments_institutes_id','=', session('department_institute_id'))->where('users_id','=', session ('user_id'))->get();
          $count = 1;
             foreach ($requests as $value)
            {
                 if($value->users_id == session ('user_id'))
                // dd($value->users_id);
                {
                     $requestPersonalData = RequestPersonalData::where('requests_id', '=', $value->id)->get();
                     $requestCount = $requestPersonalData->count();
                     $beneficiariesName = "";
                     $beneficiariesCurp = "";
                     $beneficiariesPhones = "";
                     $address="";

                     for($i = 1; $i <= $requestCount; $i++)
                     {
                         if($i == 1)
                         {
                           $personalData = PersonalData::find($requestPersonalData[$i-1]->personalData_id);
                           if ($personalData != null)
                           {
                              $fullName = $personalData->name.' '. $personalData->lastName.' '.$personalData->secondLastName;
                              $beneficiariesName = $fullName.'/'.'<br/>';
                              $beneficiariesCurp = $personalData->curp.'/'.'<br/>';
                              $extpersonalData = ExtPersonalData::where('personal_data_id','=',$personalData->id)->first();

                              if ($extpersonalData != null) 
                              {
                                  $beneficiariesPhones = $extpersonalData->number.'/'.'<br/>';
                              }
                           }
                         }
                         if($i > 1 && $i != $requestCount)
                         {
                             $personalData = PersonalData::find($requestPersonalData[$i-1]->personalData_id);
                             if ($personalData != null) 
                             {
                               $fullName = $personalData->name.' '. $personalData->lastName.' '.$personalData->secondLastName;
                               $beneficiariesName = $beneficiariesName.$fullName.'/'.'<br/>';
                               $beneficiariesCurp = $beneficiariesCurp.$personalData->curp.'/'.'<br/>';
                               $extpersonalData = ExtPersonalData::where('personal_data_id','=',$personalData->id)->first();
                               if ($extpersonalData != null) 
                               {
                                  $beneficiariesPhones = $beneficiariesPhones.$extpersonalData->number.'/'.'<br/>';
                               }
                             }
                         }
                         else
                         {
                             $personalData = PersonalData::find($requestPersonalData[$i-1]->personalData_id);

                             if ($personalData != null)
                             {
                              $fullName = $personalData->name.' '. $personalData->lastName.' '.$personalData->secondLastName;
                              $beneficiariesCurp = $personalData->curp;
                              $beneficiariesName = $fullName;
                              $extpersonalData = ExtPersonalData::where('personal_data_id','=',$personalData->id)->first();
                              if ($extpersonalData != null) 
                                 {
                                 $beneficiariesPhones = $extpersonalData->number;
                                 }
                             }

                             $addresses = Address::find($personalData->addresses_id); 

                             if ($addresses != null) 
                             {
                               $address_id = $personalData->addresses_id;
                             }
                             $community = Community::find($addresses->communities_id);

                             $communityname = "";
                             $municipalityname = "";
                             $statename = "";
                             if ($community != null) 
                                 {
                                     $communityname = $community->name;

                                     $municipality = Municipality::find($community->municipalities_id);

                                     if ($municipality != null) 
                                     {
                                         $municipalityname = $municipality->name;
                                         $state = State::find($municipality->states_id);
                                         if ($state != null) 
                                         {
                                             $statename = $state->name;
                                         }
                                     }
                                 }
                             $address = $addresses->street.' #'.$addresses->externalNumber.' '.$addresses->internalNumber.' '.$communityname.' ,'.$municipalityname.' ,'.$statename;

                         }       
                     
                     }
             
                     if ($value->type == "ts") 
                     {
                         $requests_idsp = RequestInsDepSupPro::select("requests_ins_dep_sup_pro.requests_id", "products.id", "products.name", "categories.name AS categoryname", "requests_ins_dep_sup_pro.qty", "products.categories_id")
                                                             ->join("products", "requests_ins_dep_sup_pro.products_id", "=", "products.id")
                                                             ->join("categories", "products.categories_id", "=", "categories.id")
                                                             ->where('requests_id','=', $value->id)->get();

                         foreach ($requests_idsp as $elem) 
                         {
                             $products = $elem->qty.' '.$elem->name.'<br>';
                         }
     
                     }
                     else
                     {
                         $requests_sp = RequestSupplierProduct::select("requests_suppliersProducts.requests_id", "products.id", "products.name", "categories.name AS categoryname", "requests_suppliersProducts.qty","products.categories_id")
                                                                 ->join("suppliers_products", "requests_suppliersProducts.suppliersProducts_id", "=", "suppliers_products.id")
                                                                 ->join("products", "suppliers_products.products_id", "=", "products.id")
                                                                 ->join("categories", "products.categories_id", "=", "categories.id")
                                                                 ->where('requests_id','=', $value->id)->get();

                         foreach ($requests_sp as $elem)
                         {
                              $products = $elem->qty.' '.$elem->name.'<br>';
                         }
                     } 

                     if ($value->type == "ts1") 
                         {
                             $value->typerequest = "Trabajo Social";
                         }
                     else 
                     {
                         $value->typerequest = $value->type;
                     }
                     $value->beneficiaries = $beneficiariesName;
                     $value->beneficiariesCurp = $beneficiariesCurp;
                     $value->beneficiariesNumber = $beneficiariesPhones;
                     $value->address = $address;
                     $value->products = $products;
                     $value->number = $count;

                     switch($value->status_id)
                     {
                     case 1:
                         $value->status = "Pendiente Anexo Archivos";
                         if(session('user_agent') != 'DirGen'&& session('user_agent') != 'SuperAsSo' && session('user_agent') != 'Regi' && session('user_agent') != 'Asis')
                         {
                             $value->actions = '
                             <a class="addDocument" id="addDocument" title="Anexar Documento"> <i class="fas fa-paperclip"></i></a>
                             <a class="generatePDF" id="generatePDF" title="Generar Documentos"> <i class="fas fa-file"></i></a>
                             <a class="update" id="update" title="Modificar Documentos"> <i class="far fa-edit"></i></a>';
                         }
                         else
                         {
                             $value->actions ='<a class="cancel" id="cancel" title="Cancelar"> <i class="fas fa-times-circle"></i></a>
                             <a class="update" id="update" title="Modificar Documentos"> <i class="far fa-edit"></i></a>';  
                         }
                         break;
                     case 2:
                         $value->status = "Autorización - Pendiente Verificación";
                         if(session('user_agent') != 'Admin' && session('user_agent') != 'DirGen'&& session('user_agent') != 'SuperAsSo')
                         {
                             $value->actions = '
                             <a class="showDocument" id="showDocument" title="VerDocumento"> <i class="fas fa-eye"></i></a>';
                         }
                         else
                         {
                             $value->actions = '
                                 <a class="showDocument" id="showDocument" title="VerDocumento"> <i class="fas fa-eye"></i></a>
                                 <a class="auth" id="auth" title="Autorizar"> <i class="fas fa-check-circle"></i></a>
                                 <a class="nauth" id="nauth" title="Rechazar"> <i class="fas fa-times-circle"></i></a>
                                 <a class="cancel" id="cancel" title="Cancelar"> <i class="fas fa-times-circle"></i></a>';
                         }
                         break;
                     case 3:
                         $value->status = "Autorización - Pendiente Factura";
                         if(session('user_agent') != 'Admin' && session('user_agent') != 'DirGen' && session('user_agent') != 'CoordiAsSo'&& session('user_agent') != 'SuperAsSo')
                         {
                             $value->actions = '
                             <a class="showDocument" id="showDocument" title="VerDocumento"> <i class="fas fa-eye"></i></a>';
                         }
                         else
                         {
                             $value->actions = '
                             <a class="showDocument"id="showDocument" title="VerDocumento"> <i class="fas fa-eye"></i></a>
                             <a class="auth" id="auth" title="Autorizar"> <i class="fas fa-check-circle"></i></a>
                             <a class="nauth" id="nauth" title="Rechazar"> <i class="fas fa-times-circle"></i></a>
                             <a class="cancel" id="cancel" title="Cancelar"> <i class="fas fa-times-circle"></i></a>';
                         }
                         break;
                     case 4:
                         $value->status = "Rechazada";
                         $value->actions = '<a class="showDocument" id="showDocument" title="VerDocumento"> <i class="fas fa-eye"></i></a>';
                         break;
                     case 5:
                         $value->status = "Finalizada";
                         $value->actions = '<a class="showDocument" id="showDocument" title="VerDocumento"> <i class="fas fa-eye"></i></a>';
                         break;
                     case 6:
                         $value->status = "Incompleta";
                         if(session('user_agent') != 'DirGen')
                         {
                             $value->actions = '<a class="update" id="update" title="Modificar Documentos"> <i class="far fa-edit"></i></a>';
                         } 
                         else
                         {
                             $value->actions ='<a class="cancel" id="cancel" title="Cancelar"> <i class="fas fa-times-circle"></i></a>';
                         }
                         break;
                     case 7:
                         $value->status = "Cancelada";
                         $value->actions = '-';
                         break;
                     default:
                     break;
                     }
                 $count++;
                }
            }
        return $requests;
        break;
        case 'addDocument':
            $stampfile=[];
            $requisition = Requisition::find($request->registerId);
            if($requisition->count() > 0)
            {
                if($request->file('document') != '')
                {
                   $stampFile = $request->file('document');
                   //dd($stampFile);
                   $i=0;
                   foreach($stampFile as $qdoc => $docu)
                   {
                       //dd($docu);
                       $stampName = 'document-'.$i.$requisition->folio.'.PDF';
                       $document = Document::create([
                        'name' => $stampName,
                        'requests_id' => $requisition->id
                       ]);
                       $document->save();
                       Storage::disk('local')->put($stampName,  \File::get($stampFile[$i]));
                       $i++;
                    }  
                }     

                    $status = $request->active == "on" ? 1 : 0;

                    if($request->file('deliveryImage') != '' && $request->file('deliveryImage') != null)
                    {
                     $stampFile = $request->file('deliveryImage');
                     $stampName = 'imagenEntrega-'.$requisition->folio.'.jpg';

                     $deliveryImage = deliberypictures::create([
                           'name' => $stampName,
                          'requests_id' => $requisition->id
                     ]);
                     $deliveryImage->save();

                     Storage::disk('local')->put($stampName,  \File::get($stampFile));
                     }

                    //Storage::disk('local')->put($stampName,  \File::get($stampFile));

                    $requisition->status_id = $status == 1 ? 2 : 3;
                    $requisition->save();
                    $status = $this->statusChange($requisition->status_id);
                    $folio=array('folio'=>$requisition->folio, 'status' => $status);

                    //Mail::to('cuentabusiness50@gmail.com')->send(new StatusSolicitudMail($folio));

                    //$emailLog = EmailLog::create([
                    //    'sender' => env('MAIL_FROM_ADDRESS'),
                    //    'recipient' => env('MAIL_FROM_ADDRESS'),
                    //    'status' => 'Enviado',
                    //    'descriptionStatus' => 'Se ha añadido un documento a la solicitud '.$requisition->folio
                    //]);
                    //$emailLog->save();

                    return redirect('solicitudes')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
            }
                return redirect('solicitudes')->with('error','Tus datos no fueron almacenados de forma satisfactoria.');
            
         return redirect('solicitudes')->with('error','Tus datos no fueron almacenados de forma satisfactoria.');
         break;
          
        case 'autorizar':
            $requisition = Requisition::find($request->registerId);

            if($requisition->status_id == 2)
                $requisition->status_id = 3;

            if($requisition->status_id == 3)
                $requisition->status_id = 5;

            $requisition->save();
            $status = $this->statusChange($requisition->status_id);
            $folio=array('folio'=>$requisition->folio, 'status' => $status);


            // Mail::to('cuentabusiness50@gmail.com')->send(new StatusSolicitudMail($folio));

            // $emailLog = EmailLog::create([
            //    'sender' => env('MAIL_FROM_ADDRESS'),
            //   'recipient' => env('MAIL_FROM_ADDRESS'),
            //    'status' => 'Enviado',
            //    'descriptionStatus' => 'Se envio correo de modificación de estatus de solicitud folio '.$requisition->folio
            //]);
            //$emailLog->save();

            return redirect('solicitudes')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;
        case 'rechazar':
            $requisition = Requisition::find($request->registerId);
            $requisition->status_id = 4;
            $requisition->save();
            $status = $this->statusChange($requisition->status_id);
            $folio=array('folio'=>$requisition->folio, 'status' => $status);

            //Mail::to('cuentabusiness50@gmail.com')->send(new StatusSolicitudMail($folio));

            //$emailLog = EmailLog::create([
            //    'sender' => env('MAIL_FROM_ADDRESS'),
            //    'recipient' => env('MAIL_FROM_ADDRESS'),
            //    'status' => 'Enviado',
            //    'descriptionStatus' => 'Se envio correo de que se rechazo la solicitud folio '.$requisition->folio
            //]);
            //$emailLog->save();

            return redirect('solicitudes')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;
        case 'cancelar':
            $requisition = Requisition::find($request->registerId);
            $requisition->status_id = 7;
            $requisition->save();
            $status = $this->statusChange($requisition->status_id);
            $folio=array('folio'=>$requisition->folio, 'status' => $status);

            //Mail::to('cuentabusiness50@gmail.com')->send(new StatusSolicitudMail($folio));

            //$emailLog = EmailLog::create([
            //   'sender' => env('MAIL_FROM_ADDRESS'),
            //    'recipient' => env('MAIL_FROM_ADDRESS'),
            //    'status' => 'Enviado',
            //    'descriptionStatus' => 'Se envio correo de que se cancelo la solicitud folio '.$requisition->folio
            //]);
            //$emailLog->save();

            return redirect('solicitudes')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;
        case 'finalizar':
            $requisition = Requisition::find($request->registerId);
            $requisition->status_id = 5;
            $requisition->save();
            $status = $this->statusChange($requisition->status_id);
            $folio=array('folio'=>$requisition->folio, 'status' => $status);

            // Mail::to('cuentabusiness50@gmail.com')->send(new StatusSolicitudMail($folio));

            //$emailLog = EmailLog::create([
            //    'sender' => env('MAIL_FROM_ADDRESS'),
            //    'recipient' => env('MAIL_FROM_ADDRESS'),
            //    'status' => 'Enviado',
            //    'descriptionStatus' => 'Se envio correo de que se finalizo la solicitud folio '.$requisition->folio
            //]);
            //$emailLog->save();

            return redirect('solicitudes')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
        break;
        case 'getDocument':
            $requisition = Requisition::find($request->id);
            if($requisition->count() > 0){
                $document = Document::where('requests_id','=',$requisition->id)->first();
                if($document->count() > 0){
                    $file = storage_path('app/public').'/'.$document->name;
                    $headers = array(
                       'Content-Type: application/pdf',
                      );
                    return response()->file($file, $headers);
                    // return $document;
                }
                return 'oa';
            }
            break;
        default:
            return array();
        break;
            }
    }

    public function showDoc($id){
        $requisition = Requisition::find($id);
        if($requisition->count() > 0){
            $document = Document::where('requests_id','=',$requisition->id)->first();
            if($document != null && $document->count() > 0){
                $file = storage_path('app/public').'/'.$document->name;
                $headers = array(
                   'Content-Type: application/pdf',
                  );
                return response()->file($file, $headers);
            }
            return redirect()->back();
        }
    }
    
    public function updated(Request $request, $id){
   
        if(is_numeric($id)){
            $requisition = Requisition::find($id);
            $requisition->imageSRC = '/assets/img/petitioners/'.$requisition->image;
            //dd($requisition->imageSRC);
            $requisition->petitionerImage = $requisition->imageSRC;
            $requisition->lblpetitionerImage = $requisition->image;
            $supports = [];
            $categories = [];
            $products = [];
            $department_supports = InsDepSup::where('departmentsInstitutes_id','=',session('department_institute_id'))->get();
            $count_ds = $department_supports->count();
            $supportProducts = SupportProduct::where('supports_id', '=', $request->support)->get();
            $existSup = true;

            $session = session('department_institute_id');

            for($i = 0; $i < $count_ds; $i++)
            {
                $valueDS = $department_supports[$i];

                $support = Support::find($valueDS->supports_id);
                if($supports != null){
                    foreach($supports as $valueSup){
                        if($support->id == $valueSup->id){
                            $existSup = true;
                            break;
                        }
                        else{
                            $existSup = false;
                        }
                    }
                }
                else{
                    array_push($supports, $support);
                }
                if(!$existSup){
                    array_push($supports, $support);
                }
            }

            $supportProducts = SupportProduct::where('supports_id', '=', $requisition->supports_id)->get();
            foreach($supportProducts as $value){
                $category = Category::find($value->categories_id);
                array_push($categories, $category);
            }

            if($requisition->type != 'ts'){
                $suppliers = [];
                $rSupPro = RequestSupplierProduct::where('requests_id', '=', $requisition->id)->get();
                $existSup = true;
                foreach($rSupPro as $element){
                    $supProd = SupplierProduct::find($element->suppliersProducts_id);
                    $product = Product::find($supProd->products_id);
                    $products = Product::where('categories_id', '=', $product->categories_id)->get();
                    if($products->count() > 0){
                        foreach($products as $value){
                            $supportProducts = SupplierProduct::where('products_id', '=', $value->id)->get();
                            if($supportProducts->count()>0){
                                foreach($supportProducts as $sPdts){
                                    $supplier = Supplier::find($sPdts->suppliers_id);
                                    if($suppliers != null){
                                        if($supplier != null){
                                            foreach($suppliers as $valueSup){
                                                if($supplier->id == $valueSup->id){
                                                    $existSup = true;
                                                    break;
                                                }
                                                else{
                                                    $existSup = false;
                                                }

                                            }
                                        }
                                    }
                                    else{
                                        if($supplier != null)
                                            array_push($suppliers,$supplier);
                                    }
                                    if(!$existSup){
                                        array_push($suppliers,$supplier);
                                    }
                                }
                            }
                        }
                    }
                    $requisition->suppliers_id = $supProd->suppliers_id;
                    $requisition->products_id = $supProd->products_id;
                    $requisition->price = $supProd->price;
                    $requisition->qty = $element->qty;
                    $requisition->total = $requisition->price * $requisition->qty;
                }
                $supplierProducts = SupplierProduct::where('suppliers_id', '=', $request->supplier)->get();
                foreach($supplierProducts as $supplierProduct){
                    $product = Product::find($supplierProduct->products_id);
                    if($product->categories_id == $request->category){
                        array_push($products, $product);
                    }
                }
            }
            else 
            {
                $rIDSP = RequestInsDepSupPro::where('requests_id','=',$requisition->id)->get();;
                $requisition->suppliers_id = 0;
                $existSup = true;
                foreach($rIDSP as $element) 
                {
                    $product = Product::find($element->products_id);
                    $products = Product::where('categories_id', '=', $product->categories_id)->get();
                    $requisition->products_id = $element->products_id;
                    $requisition->price = $element->price;
                    $requisition->qty = $element->qty;
                    $requisition->total = $requisition->price * $requisition->qty;
                }
             }

            $requestPersonalData = RequestPersonalData::where('requests_id','=', $requisition->id)->get();
            $countPersonalD = $requestPersonalData->count();
            $requisition->countPersonalD = $countPersonalD;
            $communities = "";
            foreach($requestPersonalData as $key => $element){
                $personalData = PersonalData::find($element->personalData_id);
                if ($personalData != null) {
                    $requisition->address = $address = Address::find($personalData->addresses_id);
                    $requisition['address']->id = $personalData->addresses_id;
                    $requisition['address']->community = $community = Community::find($address->communities_id);
                    $communities = Community::where('postalCode', '=', $community->postalCode)->get();
                    $requisition['address']->municipalities = $municipality = Municipality::find($community->municipalities_id);
                    $requisition['address']->states = State::find($municipality->states_id);
                    $extPersonalData = ExtPersonalData::where('personal_data_id', '=', $personalData->id)->first();
                    $personalData->ext = $extPersonalData;
                    $requisition['beneficiary'.($key + 1)] = $personalData;
                }


                $rpdDisabilities = RPDDisabilities::where('requestsPersonalData_id','=',$element->id)->get();
     
                foreach($rpdDisabilities as $index => $value){
                    $catDisabilities = DisabilityCategories::find($value->disabilitycategories_id);
                    $disabilities = Disabilities::where('disabilitycategories_id','=',$catDisabilities->id)->get();

                    $requisition['beneficiary'.($key + 1)]['disabilities_id'.($index+1)] = $value->disability_id;
                    $requisition['beneficiary'.($key + 1)]['catDisabilities_id'.($index+1)] = $value->disabilitycategories_id;
                    $requisition['beneficiary'.($key + 1).'Disabilities'.($index + 1)] = $disabilities;
                    $requisition['beneficiary'.($key + 1).'Disabilitiesid'.($index + 1)] = $value->id;
                    $requisition['countDiagnosticBeneficiary'.($key + 1)] = $rpdDisabilities->count();

                }
            }
    
            $catDisabilities = DisabilityCategories::all();
            $employments = Employment::all();
            $familySituation = FamilySituation::where('requests_id','=', $requisition->id)->get();
         
            $requisition->CountConditionsFamily = $familySituation->count();
            foreach($familySituation as $key => $element){
                $requisition['ConditionsFamily'.($key + 1)] = $element;
            }
          
            $economicData = EconomicData::where('requests_id','=', $requisition->id)->first();
            $lifeConditions = LifeCondition::where('requests_id','=',$requisition->id)->first();

            $furnitures = Furniture::all();
            $services = Service::all();
            $buildingMaterials = BuildingMaterial::all();

            $requestFurniture = RequestFurniture::where('requests_id','=',$requisition->id)->get();
            $requisition->CountForniture = $requestFurniture->count();
            foreach($requestFurniture as $key => $value){
                $requisition['furniture'.($key + 1)] = $value;
            }

            $requestServices = RequestService::where('requests_id','=',$requisition->id)->get();
            $requisition->CountServis = $requestServices->count();
            foreach($requestServices as $key => $value){
                $requisition['services'.($key + 1)] = $value;
            }

            $requestBuildingMaterial = RequestBuildingMaterial::where('requests_id','=',$requisition->id)->get();
            $requisition->CountMaterial = $requestBuildingMaterial->count();
            foreach($requestBuildingMaterial as $key => $value){
                $requisition['buildingMaterial'.($key + 1)] = $value;
            }

            $data=array(
                'requisition'=>$requisition,
                'supports' => $supports,
                'categories' => $categories,
                'products' => $products,
                'employments' => $employments,
                'communities' => $communities,
                'economicData'=>$economicData,
                'lifeConditions'=>$lifeConditions,
                'furnitures' => $furnitures,
                'services' => $services,
                'buildingMaterials' => $buildingMaterials,
                'catDisabilities' => $catDisabilities,
                'department_institute_id'=> $session,
                'action'=>'update'
            );
       
            if($requisition->type != 'ts'){
                $data['suppliers'] = $suppliers;
            }
            return view ('Catalogs.requestsForm',$data);
        }
        else{
            return redirect($id);
        }
    }

    public function document(Request $request, $id){

        $requests = Requisition::find($id);

        if(isset($requests) && $requests->count() > 0){
            $folderPath = public_path('assets/img/petitioners/');
            $requests->public_path = $folderPath;
            $requests->mainPublic_path= public_path('storage/');
            $requests->images_path = public_path('assets/img/');
            $date = date_format($requests->created_at, 'd/m/Y');
            $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            $day = date_format($requests->created_at, 'd');
            $month = date_format($requests->created_at, 'm');
            $year = date_format($requests->created_at, 'Y');
            $requests->date = $day.'/'.$months[$month-1].'/'.$year;

            $today = New Datetime();
            $daytoday = date_format($today, 'd');
            $monthtoday = date_format($today, 'm');
            $yeartoday = date_format($today, 'Y');
            $monthtodayletter = $months[$monthtoday-1];

            $status = Status::find($requests->status_id);
            $requests->status = $status->name;


            $userAuth = User::find($requests->usersAuth_id);
            $departmentsInstitutes = DepartmentInstitute::find($userAuth->departments_institutes_id);
            $userAuth->stamp = $departmentsInstitutes->stamp;
            $user = User::find($requests->users_id);

            $requestSupplierProducts = RequestSupplierProduct::where('requests_id','=',$requests->id)->first();

            $requestServices = RequestService::where('requests_id','=',$requests->id)->get();
            $requestFurnitures = RequestFurniture::where('requests_id','=',$requests->id)->get();
            $requestBuildingMaterial = RequestBuildingMaterial::where('requests_id','=',$requests->id)->get();
            $requestPersonalData = RequestPersonalData::where('requests_id','=',$requests->id)->get();
            $requestProducts = RequestInsDepSupPro::where('requests_id','=',$requests->id)->get();

            $lifeCondition = LifeCondition::where('requests_id','=',$requests->id)->get();
            $economicData = EconomicData::where('requests_id','=',$requests->id)->get();
            $familySituation = FamilySituation::where('requests_id','=',$requests->id)->get();

            if($familySituation != null){
                foreach($familySituation as $value){
                    $employments = Employment::find($value->employments_id);
                    $value->employmentName = $employments->name;
                }
            }
            if($requests->type == "foliado" || $requests->type == "responsiva" ){
                $supplierProducts = SupplierProduct::find($requestSupplierProducts->suppliersProducts_id);
                $products = Product::find($supplierProducts->products_id);
                $categories = Category::find($products->categories_id);
                $categoryName = $categories->name;
            }
            else{  //especie
                $requestProducts = RequestInsDepSupPro::where('requests_id','=',$requests->id)->first();
                $products = Product::find($requestProducts->products_id);
                $categories = Category::find($products->categories_id);
                $categoryName = $categories->name;
            }


            $address = [];
            $products = [];

            if($requestSupplierProducts != null){
                $supplierProduct = SupplierProduct::find($requestSupplierProducts->suppliersProducts_id);

                $product = Product::find($supplierProduct->products_id);
                $supplier = Supplier::find($supplierProduct->suppliers_id);

                $addresssupplier = AddressSupplier::where('suppliers_id','=',$supplier->id)->first();
                $address = Address::find($addresssupplier->addresses_id);
                $community = Community::find($address->communities_id);

                $requestSupplierProducts->productName = $product->name;
                $requestSupplierProducts->companyName = $supplier->companyname;
                $requestSupplierProducts->companyAddress = $address->street.' # '.$address->externalNumber;
                $requestSupplierProducts->companyColoni = $community->name;
                $requestSupplierProducts->RFC = $supplier->RFC;
                $requestSupplierProducts->email = $supplier->email;
                $requestSupplierProducts->description = $supplier->description;
                $requestSupplierProducts->price = $supplierProduct->price;
                $requestSupplierProducts->total = $supplierProduct->price * $requestSupplierProducts->qty;

            }

            if($requestServices != null){
                foreach($requestServices as $value){
                    $service = Service::find($value->services_id);
                    $value->name = $service->name;
                }
            }

            if($requestFurnitures != null){
                foreach($requestFurnitures as $value){
                    $furniture = Furniture::find($value->furnitures_id);
                    $value->name = $furniture->name;
                }
            }


            if($requestBuildingMaterial != null){
                foreach($requestBuildingMaterial as $value){
                    $bM = BuildingMaterial::find($value->buildingMaterials_id);
                    $value->name = $bM->name;
                }
            }

            if($requestPersonalData != null){
                foreach($requestPersonalData as $value)
                {
                    $personalData = PersonalData::find($value->personalData_id);
                    $extPersonalData = ExtPersonalData::where('personal_data_id','=',$personalData->id)->first();
                    $employments = Employment::find($extPersonalData->employments_id);
                    $address = Address::find($personalData->addresses_id);
                    $community = Community::find($address->communities_id);
                    $municipality = Municipality::find($community->municipalities_id);
                    $state = State::find($municipality->states_id);
                    $value->curp = $personalData->curp;
                    $value->name = $personalData->name;
                    $value->lastName = $personalData->lastName;
                    $value->secondLastName = $personalData->secondLastName;
                    $value->age = $personalData->age;
                    $value->familiar = $personalData->familiar;
                    $value->civilStatus = $extPersonalData->civilStatus;
                    $value->scholarShip = $extPersonalData->scholarShip;
                    $value->number = $extPersonalData->number;
                    $value->employmentName = $employments->name;
                    $address->community = $community;
                    $address->municipality = $municipality;
                    $address->state = $state;
                }
            }


             $formatter = NumeroALetras::convert($requestSupplierProducts != null ? $requestSupplierProducts->total : "0", "pesos MXN", true);

            $data = array(
                'address' => $address,
                'requestPersonalData' => $requestPersonalData,
                'extPersonalData' => $extPersonalData,
                'requestBuildingMaterial' => $requestBuildingMaterial,
                'requestSupplierProducts' =>  $requestSupplierProducts == null ? "" : $requestSupplierProducts,
                'requestFurnitures' => $requestFurnitures,
                'requestServices' => $requestServices,
                'userAuth' => $userAuth,
                'user' => $user,
                'status' => $status,
                'lifeCondition' => $lifeCondition,
                'economicData' => $economicData,
                'familySituation' => $familySituation,
                'requisition' => $requests,
                'requestProducts' => $requestProducts,
                'total' => $requestSupplierProducts == null ? "" : $requestSupplierProducts->total ,
                'apoyo' => $requestServices[0]->name,
                'totalletter' => $formatter ,
                'daytoday' => $daytoday,
                'yeartoday' => $yeartoday,
                'monthtodayletter' => $monthtodayletter,
                'categoria' =>  $categoryName
            );

            $pdf = PDF::loadView('PDF.requestsDocument', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('pdf_file.pdf');
        }
        else
            return redirect()->back();
        //  return view('PDF.requestsDocument', $data);
    }
}
