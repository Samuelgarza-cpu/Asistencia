<?php

namespace App\Http\Controllers\Auth;

/*Modelos Requeridos en el controlador*/
use App\Models\Role;
use App\Models\User;

/*Librerias propias necesarias de laravel*/
use App\Models\DepartmentInstitute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /* Alexis David Aguero Celis
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    | Este controlador maneja la autenticación de usuarios para la aplicación y
    | redirección a su pantalla de inicio.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Redirección de usuarios después de logear
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Crear un nuevo control de instancia
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        /**
         * Guardamos los campos de solicitud como un arreglo
         */
        $credentials = $request->only('name', 'password');
        $remember_me = $request->has('customCheck') ? true : false;

        /**
         * Checamos si existe un usuario y puede entrar a sesión
         * en caso de que si, buscamos en la base de datos el usuario y el rol
         * como los usuarios pueden estar o no activos, buscamos que este activo y guardamos
         * en una variable de sesión el rol y el id del usuario que ingreso.
         */
        if (Auth::attempt($credentials, $remember_me)) {
            $user = User::where('name','=',$credentials['name'])->first();
            if($user->active){
                $role = Role::where('id','=',$user['roles_id'])->first();
                $departments_institutes = DepartmentInstitute::find($user->departments_institutes_id);
                session(['user_agent' =>$role['code']]);
                session(['user_id' => $user['id']]);
                session(['user' => $user['owner']]);
                session(['nameuser' => $user['name']]);
                session(['userImage' => $departments_institutes['image']]);
                session(['department_institute_id' => $user['departments_institutes_id']]);
                if($request->cookie('CPass') == null && $request->cookie('CName') == null && $remember_me)
                return redirect('cookieset/'.$request->password);
                else{
                    if($remember_me)
                        return redirect('home/');
                    else
                        return redirect('home')->cookie('CName',null,0)->cookie('CPass',null,0);
                }
            }
            else{
                $errors = ErrorLog::create([
                    'users_id' => $user->id, 
                    'description' => "El usuario que trata de acceder esta deshabilitado. Ruta de control:".$request->url(),
                    'owner' => $user->owner
                ]);
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
    }
}
