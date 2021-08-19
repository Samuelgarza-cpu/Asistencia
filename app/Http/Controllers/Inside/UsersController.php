<?php

namespace App\Http\Controllers\Inside;

use App\Models\Role;
use App\Models\User;
use App\Mail\UpdateUser;
use App\Models\Institute;
use App\Mail\UsuarioNuevo;
use App\Models\Department;
use App\Events\eventusernew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DepartmentInstitute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\EmailLog;

class UsersController extends Controller
{
    public function index(){
        return view('catalogs.users');
    }

    public function new(){
        $roles = Role::all();
        $departments = Department::all();
        foreach($departments as $department)
        {
            $department_institute = DepartmentInstitute::where('departments_id','=',$department->id)->first();
            if($department_institute != null){
                $institute = Institute::find($department_institute->institutes_id);
                $department->id_of_institute_deparment = $department_institute->id;
                $department->name_with_institute = $department->name.' de '.$institute->name;
            }
        }


        $data = array('roles' => $roles,
            'departments' => $departments,
            'action' => 'new'
        );
        return view('catalogs.usersForm', $data);
    }

    public function updated(Request $request, $id){
        if(is_numeric($id)){
            $roles = Role::all();
            $user = User::find($id);
            if($user != null && $user->count() > 0){
                if(isset($user->signature)){
                    $user->signatureSRC = '../storage/'.$user->signature;
                }
                $departments = Department::all();
                foreach($departments as $department)
                {
                    $department_institute = DepartmentInstitute::where('departments_id','=',$department->id)->first();
                    if($department_institute != null){
                        $institute = Institute::find($department_institute->institutes_id);
                        $department->id_of_institute_deparment = $department_institute->id;
                        $department->name_with_institute = $department->name.' de '.$institute->name;
                    }
                }

                $data = array('roles' => $roles,
                    'departments' =>  $departments,
                    'action' => 'update',
                    'user' => $user
                    );


                return view('catalogs.usersForm', $data);
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'),
                    'description' => "El usuario que se trata de actualizar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('catalogs.usersForm')->with('error', 'No se pudo llevar acabo la acción ');
            }
        }
        else{
            return redirect($id);
        }
    }

    public function save(Request $request){
        switch($request->input('action')){
            case "new":
                $imageFile = $request->file('signature');
                $imageName = $imageFile->getClientOriginalName();
                $user = User::create([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'signature' => $imageName,
                    'active' => $request->active == "on" ? 1 : 0,
                    'owner' => $request->owner,
                    'roles_id' => $request->roles_id,
                    'departments_institutes_id' => $request->departments_institutes_id
                ]);

                $datos=array([
                    'usuario'=> $request->owner,
                    'email'=>$request->email,
                    'name' => $request->name,
                    'password' =>$request->password
                ]);

                $usuarios=User::all();
                event(new eventusernew($usuarios));
                // Mail::to($request->email)->send(new UsuarioNuevo($datos));
                $user->save();
                \Storage::disk('local')->put($imageName,  \File::get($imageFile));

                // $emailLog = EmailLog::create([
                //     'sender' => env('MAIL_FROM_ADDRESS'),
                //     'recipient' => $usuario->email,
                //     'status' => 'Enviado',
                //     'descriptionStatus' => 'Se envio correo de nuevo usuario a '.$usuario->owner
                // ]);
                // $emailLog->save();

                return redirect('usuarios')->with('success','Tus datos fueron almacenados de forma satisfactoria.');

            break;

            case "update":
                $user = User::find($request->id);
                if($user != null && $user->count() > 0){
                    if(isset($user)){
                        if(isset($request->signature)){
                            $imageFile = $request->file('signature');
                            $imageName = $imageFile->getClientOriginalName();
                            \Storage::disk('local')->put($imageName,  \File::get($imageFile));
                            $user->signature = $imageName;
                        }
                        $user->name = $request->name;
                        $password = $request->password == $user->password ? '' : Hash::make($request->password);
                        if($password != ''){
                            $user->password = $password;
                        }
                        $user->email = $request->email;
                        $user->active = $request->active == "on" ? 1 : 0;
                        $user->owner = $request->owner;
                        $user->roles_id = $request->roles_id;
                        $user->departments_institutes_id = $request->departments_institutes_id;
                        $user->save();

                        $datos=array([
                            'usuario'=> $request->owner,
                            'email'=>$request->email,
                            'name' => $request->name,
                            'password' =>$request->password
                            ]);

                        if($request->password != $user->password && $request->name == $user->name)
                        {
                            // Mail::to($request->email)->send(new UpdateUser($datos));
                        }
                        elseif($request->name != $user->name && $request->password != $user->password){
                            // Mail::to($request->email)->send(new UpdateUser($datos));
                        }

                        // $emailLog = EmailLog::create([
                        //     'sender' => env('MAIL_FROM_ADDRESS'),
                        //     'recipient' => $request->email,
                        //     'status' => 'Enviado',
                        //     'descriptionStatus' => 'Se envio correo de actualización de usuario '. $user->name
                        // ]);
                        // $emailLog->save();
                    }
                    return redirect('usuarios')->with('success','Tus datos fueron almacenados de forma satisfactoria.');
                }
                else{
                    $errors = ErrorLog::create([
                        'users_id' => session('user_id'),
                        'description' => "El usuario que se trata de actualizar no existe o esta erróneo ".$request->url(),
                        'owner' => session('user')
                    ]);
                    return redirect('usuarios')->with('error', 'No se pudo llevar acabo la acción ');
                }
            break;

            default:
                return array();
            break;
        }
    }

    public function users(Request $request)
    {
        switch($request->input('action')){
        case "query":
            DB::statement(DB::raw('set @row:=0'));
            $users = User::join('departments_institutes as dI', 'users.departments_institutes_id','dI.id')
                            ->join('roles as R', 'users.roles_id', 'R.id')
                            ->join('departments as D', 'dI.departments_id', 'D.id')
                            ->join('institutes as I', 'dI.institutes_id', 'I.id')
                            ->select('users.*', DB::raw('@row:=@row+1 AS number'), 'D.name as department', 'I.name as institute', 'R.name as role')
                            ->get();
            foreach ($users as $user)
            {
                $user->status = $user->active == 1 ? "Activo" : "Inactivo";
                $user->actions = '<a class="update" id="update" title="Modificar"> <i class="fas fa-edit"></i></a>
                                  <a class="remove" id="delete" title="Eliminar"><i class="fas fa-trash"></i></a>';
            }
            return $users;
        break;
        case 'delete':
            $user = User::find($request->registerId);
            if($user != null && $user->count() > 0){
                // $user->delete();
                $user->active = 0;
                $user->save();
                return redirect('usuarios')->with('success','el registro se elimino de forma satisfactoria.');
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => session('user_id'),
                    'description' => "El usuario que se trata de eliminar no existe o esta erróneo ".$request->url(),
                    'owner' => session('user')
                ]);
                return redirect('usuarios')->with('error', 'No se pudo llevar acabo la acción ');
            }
        break;
        default:
            return array();
        break;
        }
    }
}
