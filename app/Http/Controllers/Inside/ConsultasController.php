<?php

namespace App\Http\Controllers\Inside;
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


class ConsultasController extends Controller
{
    public function index()
    {
        return view('catalogs.consultacurp');
    }
    public function consultas(Request $request)
    {
        
        switch($request->input('action'))
        {
            case 'checkCurp':
                $countRrequi = 0;
                if($request->curpbeneficiary != null)
                {
                    $curp = strtoupper($request->curpbeneficiary);
                    $data = array();
                    $datosGenerales = array();
                    $dataFull = array();
                    $exist = false;
                    $today = New Datetime();
                    $lastMonth = $today->modify('-1 month');
                    $now = New Datetime();
                    $lastMonth = date_format($lastMonth, 'Y-m-d');
                    //dd($lastMonth);
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
                                             ->where('status_id','!=','7')
                                             //->distinct()s
                                             ->get();       

                    // dd($requisition);
                    if(isset($requisition) && $requisition->count() > 0)
                    {
                        foreach($requisition as $key=>$value)
                        {
                            $today = New Datetime();
                            $fecha1 = new DateTime($value->date);
                            $interval = $fecha1->diff($today);
                           //$requestid = $value->id;
                            $requestid = $value->requests_id;
                            //dd($requestid);
                            $petitioner = $value->petitioner;
                            $findRPersonalData = RequestPersonalData::where('requests_id','=',$requestid)->first();
                            //dd($findRPersonalData);
                            $findPersonalData= PersonalData::where('id','=',$findRPersonalData->personalData_id)->first();
                            //dd($findPersonalData);
                            //$addresses= Address::where('id','=',$findPersonalData->addresses_id)->first();
                            //$community = Community::where('id','=',$addresses->communities_id)->first();
                            //$municipality = Municipality::where('id','=',$community->municipalities_id)->first();
                            //$states =  State::where('id','=',$municipality->states_id)->first();
                            //$area = $value->area;
                            //$findExtPersonalData= ExtPersonalData::where('personal_data_id','=',$findPersonalData->id)->first();
                            //$requestSupplier = vRequestSupplierProduct::where('requests_id','=',$requestid)->first();
                            $vRequestSupplierProduct = vRequestSupplierProduct::where('requests_id','=',$requestid)->first();
                            //dd($vRequestSupplierProduct);                                 
                            //$SupplierProductID = SupplierProduct::where('id','=',$requestSupplier->suppliersProducts_id)->first();
                            // $SupplierProductID = SupplierProduct::where('id','=',$vRequestSupplierProduct->suppliersProducts_id)->first();
                            $products = Product::where('id','=', $vRequestSupplierProduct->products_id)->first();
                            $suppliers = Supplier::where('id','=', $vRequestSupplierProduct->supplier_id)->first();
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
                                //$data['Departament'.$key]=$departmentName->name;
                                $data['Departament'.$key]=$suppliers->companyname;
                              //  $data['EdadBeneficiario'.$key]=$findPersonalData->age;
                              //  $data['TelBeneficiario'.$key]=$findExtPersonalData->number;
                              //  $data['NomBeneficiario'.$key]=$findPersonalData->name;
                              //  $data['APBeneficiario'.$key]=$findPersonalData->lastName;
                              //  $data['SLNBeneficiario'.$key]=$findPersonalData->secondLastName;
                              //  $data['calle'.$key]=$addresses->street;
                              //  $data['numext'.$key]=$addresses->externalNumber;
                              //  $data['numint'.$key]=$addresses->internalNumber;
                              //  $data['EcivilBeneficiario'.$key]=$findExtPersonalData->civilStatus;
                              //  $data['EscBeneficiario'.$key]=$findExtPersonalData->scholarShip;
                              //  $data['OcuBeneficiario'.$key]=$findExtPersonalData->employments_id;
                              //  $data['CPBeneficiario'.$key]=$community->postalCode;
                              //  $data['idColBen'.$key]=$community->id;
                              //  $data['ColBeneficiario'.$key]=$community->name;
                              //  $data['idMpioBen'.$key]=$municipality->id;
                              //  $data['MpioBeneficiario'.$key]=$municipality->name;
                              //  $data['idStateBen'.$key]=$states->id;
                              //  $data['StateBeneficiario'.$key]=$states->name;
                              //  $data['areaBeneficiario'.$key]=$area;
                                $countRrequi++;
                                $exist = true;
                                
                            }
                        }
                    }else
                    {
                        $personalData = PersonalData::where('curp','=', $curp)->get();
                        //dd($personalData);
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
                                        //dd($requisition);
                                        if(isset($requisition))
                                        {
                                            $today = New Datetime();
                                            $fecha1 = new DateTime($requisition->date);
                                            $interval = $fecha1->diff($today);
                                            //dd($interval);
                                            $requestid1 = $requisition->id;
                                            $petitioner = $requisition->petitioner;
                                            $instituteID = DepartmentInstitute::find($requisition->departments_institutes_id);
                                            $instituteName = Institute::find($instituteID->institutes_id);
                                            $departmentName = Department::find($instituteID->departments_id);
                                            $findRPersonalData = RequestPersonalData::where('personalData_id','=',$requestid1)->first();
                                            $requestid2 = $findRPersonalData->requests_id;

                                            //dd($requestid2);
                                            if ($requisition->type == 'ts')
                                            {
                                                $requestinsdepsuppro = RequestInsDepSupPro::where('requests_id','=',$findRPersonalData->requests_id)->first();
                                                $products = Product::where('id','=',$requestinsdepsuppro->products_id)->first();
                                            }
                                            else
                                            {
                                              //$requestSupplier = RequestSupplierProduct::where('requests_id','=',$findRPersonalData->requests_id)->first();
                                              //$SupplierProductID = SupplierProduct::where('id','=',$requestSupplier->suppliersProducts_id)->first();
                                              //$products = Product::where('id','=',$SupplierProductID->products_id)->first();
                                              //$suppliers = Supplier::where('id','=',$requestSupplier->supplier_id)->first();
                                                $vRequestSupplierProduct = vRequestSupplierProduct::where('requests_id','=',$requestid1)->first();
                                                $products = Product::where('id','=', $vRequestSupplierProduct->products_id)->first();
                                                $suppliers = Supplier::where('id','=', $vRequestSupplierProduct->supplier_id)->first();
                                            }
                                      
                                            if($interval->y >= 1)
                                            {
                                                $exist = false;
                                            }
                                            elseif($interval->m <= 1)
                                            {
                                                $data['requisition0']=$requestid1;
                                                $data['requisition1']=$requestid1;
                                                $data['Usuario'.$keysis]=$petitioner;
                                                $data['CualSolicitante'.$keysis]=$curp;  //$requisition->curpPetitioner;
                                                $data['Apoyo'.$keysis]= $products->name;
                                                $data['date'.$keysis] =date_format($fecha1,'Y-m-d');                                                    
                                                $data['institute'.$keysis]=$instituteName->name;
                                                //$data['Departament'.$keysis]=$departmentName->name;
                                                $data['Departament'.$keysis]=$suppliers->companyname;                                                 
                                                $countRrequi++;
                                                $exist = true;
                                            }    
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //dd($exist);
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

                    return $dataFull;
                }
                else
                {
                    $data = array();
                    $dataFull = array();
                    $exist = false;

                    //$text = 'Debe Proporcionar el CURP del solicitante';
                    $text = '';
                    $id = 0;
                    $message = array('text' => $text, 'exist' => $id);
                    $data['message'] = $message;
                    array_push($dataFull,$data);

                    return $dataFull;
                }
                //break;
                
             case 'checkCurp2':
                $countRrequi = 0;
                if($request->curpbeneficiary != null)
                {
                    $curp = strtoupper($request->curpbeneficiary);
                    $data = array();
                    $datosGenerales = array();
                    $dataFull = array();
                    $exist = false;
                    $today = New Datetime();
                    $lastMonth = $today->modify('-1 month');
                    $now = New Datetime();
                    $lastMonth = date_format($lastMonth, 'Y-m-d');
                    //dd($lastMonth);
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
                                             ->where('requests.date','<=', $now)
                                             ->where('status_id','!=','7')
                                             //->distinct()
                                             ->get();       

                                             //->where('requests.date','>=', $lastMonth)

                    //dd($requisition->count());
                    if(isset($requisition) && $requisition->count() > 0)
                    {
                        foreach($requisition as $key=>$value)
                        {
                            $today = New Datetime();
                            $fecha1 = new DateTime($value->date);
                            //dd($fecha1);
                            $interval = $fecha1->diff($today);
                            //dd($interval);
                           //$requestid = $value->id;
                            $requestid = $value->requests_id;
                            //dd($requestid);
                            $petitioner = $value->petitioner;
                            $findRPersonalData = RequestPersonalData::where('requests_id','=',$requestid)->first();
                            //dd($findRPersonalData);
                            $findPersonalData= PersonalData::where('id','=',$findRPersonalData->personalData_id)->first();
                            //dd($findPersonalData);
                            //$addresses= Address::where('id','=',$findPersonalData->addresses_id)->first();
                            //$community = Community::where('id','=',$addresses->communities_id)->first();
                            //$municipality = Municipality::where('id','=',$community->municipalities_id)->first();
                            //$states =  State::where('id','=',$municipality->states_id)->first();
                            $area = $value->area;
                            $findExtPersonalData= ExtPersonalData::where('personal_data_id','=',$findPersonalData->id)->first();
                            //$requestSupplier = vRequestSupplierProduct::where('requests_id','=',$requestid)->first();
                            $vRequestSupplierProduct = vRequestSupplierProduct::where('requests_id','=',$requestid)->first();
                            //dd($vRequestSupplierProduct);                                 
                            //$SupplierProductID = SupplierProduct::where('id','=',$requestSupplier->suppliersProducts_id)->first();
                            // $SupplierProductID = SupplierProduct::where('id','=',$vRequestSupplierProduct->suppliersProducts_id)->first();
                            $products = Product::where('id','=', $vRequestSupplierProduct->products_id)->first();
                            $suppliers = Supplier::where('id','=', $vRequestSupplierProduct->supplier_id)->first();
                            $departamentid = $value->departments_institutes_id;
                            $instituteID = DepartmentInstitute::find($departamentid);
                            $instituteName = Institute::find($instituteID->institutes_id);
                            $departmentName = Department::find($instituteID->departments_id);
                            
                            //dd($departmentName);
                            if($interval->y >= 1 )
                            {
                                $exist = false;
                            }
                            elseif($interval->m >= 1) 
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
                                //$data['Departament'.$key]=$departmentName->name;
                                $data['Departament'.$key]=$suppliers->companyname;
                                //$data['EdadBeneficiario'.$key]=$findPersonalData->age;
                                //$data['TelBeneficiario'.$key]=$findExtPersonalData->number;
                                //$data['NomBeneficiario'.$key]=$findPersonalData->name;
                                //$data['APBeneficiario'.$key]=$findPersonalData->lastName;
                                //$data['SLNBeneficiario'.$key]=$findPersonalData->secondLastName;
                                //$data['calle'.$key]=$addresses->street;
                                //$data['numext'.$key]=$addresses->externalNumber;
                                //$data['numint'.$key]=$addresses->internalNumber;
                                //$data['EcivilBeneficiario'.$key]=$findExtPersonalData->civilStatus;
                                //$data['EscBeneficiario'.$key]=$findExtPersonalData->scholarShip;
                                //$data['OcuBeneficiario'.$key]=$findExtPersonalData->employments_id;
                                //$data['CPBeneficiario'.$key]=$community->postalCode;
                                //$data['idColBen'.$key]=$community->id;
                                //$data['ColBeneficiario'.$key]=$community->name;
                                //$data['idMpioBen'.$key]=$municipality->id;
                                //$data['MpioBeneficiario'.$key]=$municipality->name;
                                //$data['idStateBen'.$key]=$states->id;
                                //$data['StateBeneficiario'.$key]=$states->name;
                                //$data['areaBeneficiario'.$key]=$area;
                                $countRrequi++;
                                $exist = true;
                                
                            }
                        }
                    }else
                    {
                        $personalData = PersonalData::where('curp','=', $curp)->get();
                        //dd($personalData);
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
                                        //dd($requisition);
                                        if(isset($requisition))
                                        {
                                            $today = New Datetime();
                                            $fecha1 = new DateTime($requisition->date);
                                            $interval = $fecha1->diff($today);
                                            //dd($interval);
                                            $requestid1 = $requisition->id;
                                            $petitioner = $requisition->petitioner;
                                            $instituteID = DepartmentInstitute::find($requisition->departments_institutes_id);
                                            $instituteName = Institute::find($instituteID->institutes_id);
                                            $departmentName = Department::find($instituteID->departments_id);
                                            $findRPersonalData = RequestPersonalData::where('personalData_id','=',$requestid1)->first();
                                            $requestid2 = $findRPersonalData->requests_id;

                                            //dd($requestid2);
                                            if ($requisition->type == 'ts')
                                            {
                                                $requestinsdepsuppro = RequestInsDepSupPro::where('requests_id','=',$findRPersonalData->requests_id)->first();
                                                $products = Product::where('id','=',$requestinsdepsuppro->products_id)->first();
                                            }
                                            else
                                            {
                                              //$requestSupplier = RequestSupplierProduct::where('requests_id','=',$findRPersonalData->requests_id)->first();
                                              //$SupplierProductID = SupplierProduct::where('id','=',$requestSupplier->suppliersProducts_id)->first();
                                              //$products = Product::where('id','=',$SupplierProductID->products_id)->first();
                                              //$suppliers = Supplier::where('id','=',$requestSupplier->supplier_id)->first();
                                                $vRequestSupplierProduct = vRequestSupplierProduct::where('requests_id','=',$requestid1)->first();
                                                $products = Product::where('id','=', $vRequestSupplierProduct->products_id)->first();
                                                $suppliers = Supplier::where('id','=', $vRequestSupplierProduct->supplier_id)->first();
                                            }
                                      
                                            if($interval->y >= 1)
                                            {
                                                $exist = false;
                                            }
                                            elseif($interval->m >= 1)
                                            {
                                                $data['requisition0']=$requestid1;
                                                $data['requisition1']=$requestid1;
                                                $data['Usuario'.$keysis]=$petitioner;
                                                $data['CualSolicitante'.$keysis]=$curp;  //$requisition->curpPetitioner;
                                                $data['Apoyo'.$keysis]= $products->name;
                                                $data['date'.$keysis] =date_format($fecha1,'Y-m-d');                                                    
                                                $data['institute'.$keysis]=$instituteName->name;
                                                //$data['Departament'.$keysis]=$departmentName->name;
                                                $data['Departament'.$keysis]=$suppliers->companyname;                                                 
                                                $countRrequi++;
                                                $exist = true;
                                            }    
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //dd($exist);
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

                    return $dataFull;
                }
                else
                {
                    $data = array();
                    $dataFull = array();
                    $exist = false;

                    //$text = 'Debe Proporcionar el CURP del solicitante';
                    $text = '';
                    $id = 0;
                    $message = array('text' => $text, 'exist' => $id);
                    $data['message'] = $message;
                    array_push($dataFull,$data);

                    return $dataFull;
                }

                //break;    
        }
    }
}
