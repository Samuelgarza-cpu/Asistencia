<?php

namespace App\Http\Controllers\Inside;

use App\Models\State;
use App\Models\Address;
use App\Models\Community;

use App\Models\Institute;
use App\Models\Department;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\DepartmentInstitute;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class InstitutesDepartmentsController extends Controller
{
    public function index(){
        return view('catalogs.departmentInstitute');
    }

    public function new(){
        $departmentInstitutes = DepartmentInstitute::all();
        $departments =Department::all();
        $institutes = Institute::all();

        $data = array('departments' => $departments,
        'institutes' => $institutes,
        'departmentInstitutes' =>$departmentInstitutes,
        'action' => 'new'
        );
        return view('catalogs.departmentInstituteForm', $data);
    }

    public function updated(Request $request, $id){
        if(is_numeric($id)){
            $departmentInstitute = DepartmentInstitute::find($request->id);
            if($departmentInstitute != null && $departmentInstitute->count() > 0)
            {
                $departments = Department::all();
                $institutes = Institute::all();

                if(isset($departmentInstitute->stamp))
                    $departmentInstitute->stampSRC = '../storage/'.$departmentInstitute->stamp;

                if(isset($departmentInstitute->image))
                    $departmentInstitute->imageSRC = '../storage/'.$departmentInstitute->image;
                
                $address = Address::find($departmentInstitute->addresses_id);
                $community = Community::find($address->communities_id);
                $communities = Community::where('postalCode', '=', $community->postalCode)->get();
                $municipality = Municipality::find($community->municipalities_id);
                $states = State::find($municipality->states_id);

                $data = array('departments' => $departments,
                    'institutes' => $institutes,
                    'department_institute' =>$departmentInstitute,
                    'action' => 'update',
                    'address' => $address,
                    'communities' => $communities,
                    'municipalities' => $municipality,
                    'states' => $states,
                    'community' => $community
                );
                // dd($data);
                return view('catalogs.departmentInstituteForm', $data);
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "La relacion departamento - instituto que se trata de eliminar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('catalogs.departmentInstituteForm')->with('error', 'No se pudo llevar acabo la acción ');
            } 
        }
        else{
            return redirect($id);
        }
    }

    public function save(Request $request){
        switch($request->input('action')){
            case 'new':
                    // dd($request);
                if($request->file('stamp') != ''){
                    $stampFile = $request->file('stamp');
                    $stampName = 'sello-departamento-'.$stampFile->getClientOriginalName(); 
                }
    
                if($request->file('image') != ''){
                    $imageFile = $request->file('image');
                    $imageName = 'departamento-'.$imageFile->getClientOriginalName();                 
                }
                $address = Address::create([
                    'street' => $request->street,
                    'externalNumber' => $request->externalNumber,
                    'internalNumber' => $request->internalNumber,
                    'communities_id' => $request->communities_id
                ]);
                $address->save();

                $departmentInstitute = DepartmentInstitute::create([
                    'departments_id' => $request->departments_id,
                    'institutes_id' => $request->institutes_id,
                    'stamp'=> $stampName,
                    'image'=> $imageName,
                    'addresses_id' => $address->id
                ]);
                $departmentInstitute->save();
    
                \Storage::disk('local')->put($stampName,  \File::get($stampFile));
                \Storage::disk('local')->put($imageName,  \File::get($imageFile));
                return redirect('instituto_departamento')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
            break;
            case 'update':
                $departmentInstitute = DepartmentInstitute::find($request->id);
                if($departmentInstitute != null && $departmentInstitute->count() > 0){                
                    if($request->file('stamp') != ''){
                        $stampFile = $request->file('stamp');
                        $stampName = 'sello-departamento-'.$stampFile->getClientOriginalName(); 
                        $departmentInstitute->stamp = $stampName;
                        \Storage::disk('local')->put($stampName,  \File::get($stampFile));
                    }

                    if($request->file('image') != ''){
                        $imageFile = $request->file('image');
                        $imageName = 'departamento-'.$imageFile->getClientOriginalName();                 
                        $departmentInstitute->image = $imageName;  
                        \Storage::disk('local')->put($imageName,  \File::get($imageFile));
                    }

                    $departmentInstitute->departments_id = $request->departments_id;
                    $departmentInstitute->institutes_id = $request->institutes_id;
                    
                    $address = Address::find($departmentInstitute->addresses_id);
                    $address->street = $request->street;
                    $address->externalNumber = $request->externalNumber;
                    $address->internalNumber = $request->internalNumber;
                    $address->communities_id = $request->communities_id;

                    $address->save();
                    $departmentInstitute->save();

                    return redirect('instituto_departamento')->with('success','Tus datos fueron modificados de forma satisfactoria.');
                }
                else{
                    $errors = ErrorLog::create([
                            'users_id' => session('user_id'), 
                            'description' => "La relacion instituto - departamento que se trata de actualiza no existe o esta erróneo ".$request->url(),
                            'owner' => session('user')
                        ]);
                    return redirect('instituto_departamento')->with('error', 'No se pudo llevar acabo la acción ');
                }       
            break;
        }
        return array();
    }

    public function instituteDepartment(Request $request)
    {
        switch($request->input('action')){
        case "query":
            $departmentInstitutes = DepartmentInstitute::all();            
            $count = 1;
            foreach ($departmentInstitutes as $departmentInstitute) 
            {
                $department = Department::find($departmentInstitute->departments_id);
                $institute = Institute::find($departmentInstitute->institutes_id);
                $departmentInstitute->institute = $institute->name;
                $departmentInstitute->department = $department->name;
               
                if(isset($departmentInstitute->stamp))
                    $departmentInstitute->stampSRC = '../storage/'.$departmentInstitute->stamp;

                if(isset($departmentInstitute->image))
                        $departmentInstitute->imageSRC = '../storage/'.$departmentInstitute->image;
                
                $departmentInstitute->number = $count++;
                $departmentInstitute->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a> 
                                                 <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return  $departmentInstitutes;
        break;
        case 'new':
           
        break;  
        case 'update':
          
        break;
        case 'delete':
            $departmentInstitute = DepartmentInstitute::find($request->registerId);
            if($departmentInstitute != null && $departmentInstitute->count() > 0){                
                $departmentInstitute->delete();
                return redirect('instituto_departamento')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                        'users_id' => session('user_id'), 
                        'description' => "La relacion instituto - departamento que se trata de eliminar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                return redirect('instituto_departamento')->with('error', 'No se pudo llevar acabo la acción ');
            }   
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
        default:
            return array();
        break;
            }
    }
}
