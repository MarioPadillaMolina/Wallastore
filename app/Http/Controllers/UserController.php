<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Auth;
use App\Mail\ChangeUserEmail;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {
        // solo un admin debe hacer los métodos siguientes
        $this->middleware('admin')->only(['create', 'store', 'destroy', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); //esto lo hace eloquent
        return view('backend.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provincias = Provincia::orderBy('nombre')->get(); 
        return view('backend.user.create', ['provincias' => $provincias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = new User($request->all());
        $user->password = Hash::make($user->password);
        try {
            $result = $user->save();
        } catch (\exception $e) {
            $result = 0;
        }

        if ($user->id > 0) {
            $response = ['op' => 'create', 'r' => $result, 'id' => $user->id];
            return redirect('backend/user')->with($response);
        } else {
            return back()->withInput()->with(['error' => 'algo ha fallado']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view("backend.user.show", ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //usuario logueado
        $current_user = request()->user();
        $provincias = Provincia::orderBy('nombre')->get(); 
        //bloqueamos editar al admin id->1
        if ($current_user->id != $user->id && !$current_user->admin) {
            return redirect('backend/user')->with(['error' => 'No tiene permiso para hacer eso']);
        }
        return view('backend.user.edit', ['user' => $user, 'provincias' => $provincias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //protección de edición de no admins
        $current_user = request()->user();
        if (($current_user->id != $user->id && !$current_user->admin) || $user->id == 1) {
            return redirect('backend/user');
        }
        //validación
        $this->validatorEdit($request->all(), $user->id)->validate(); //pasamos la id que necesita el validator
        // $user = $user->update($request->all());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->admin = $request->admin;
        $user->provincia_id = $request->provincia_id;
        //si hemos introducido nuevo password..
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        //salvamos
        try {
            $result = $user->save();
        } catch (\exception $e) {
            $result = 0;
        }
        $response = ['op' => 'update', 'r' => $result, 'id' => $user->id];
        return redirect('backend/user')->with($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $id = $user->id;
        $current_user = request()->user();
        $result = 0;
        if ($current_user->id == 1 && $user->id != 1) { //si eres super admin borras a quien sea menos a ti
            try {
                $result = $user->delete();
            } catch (\Exception $ex) {
                $result = 0;
            }
        } else if ($current_user->admin && $current_user->id != $user->id && !$user->admin) {//si eres admin, borras a otros que no sean admin
            try {
                $result = $user->delete();
            } catch (\Exception $ex) {
                $result = 0;
            }
        }
        $response = ['op' => 'destroy', 'r' => $result, 'id' => $id];
        return redirect('backend/user')->with($response);
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'admin' => ['required', 'boolean'],
            'password' => ['required', 'string', 'min:8'], //quitamos el confirmed, para crearlo desde el admin no hace falta
            'provincia_id' => ['required', 'string'],
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorEdit(array $data, $id)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id], //la id del que vamos a cambiarle el mail
            'admin' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
            'provincia_id' => ['required', 'string'],
        ]);
    }



    /*************GESTIÓN DE DATOS DEL USUARIO**************/

    //cogemos el user de la sesión para cambiarle la clave
    function changePassword(Request $request)
    {
        $this->passwordValidate($request->all())->validate();
        //1-verificar que la clave anterior es correcta
        //2-encriptar la clave nueva y asignarla
        $user = auth()->user();
        // $user = Auth::user();
        if (Hash::check($request->oldpassword, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('home')->with(['password' => true]);
        } else {
            return redirect('home')->withErrors(['passworderror' => 'no se ha podido cambiar la clave debido a que la clave anterior no es correcta']);
        }
    }

    private function passwordValidate(array $data)
    {
        return Validator::make($data, [
            'oldpassword' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    function changeUser(Request $request)
    {
        $redirect = 'home';
        $this->userValidate($request->all())->validate();
        $user = auth()->user();
        $user->name = $request->name;
        if ($user->email != $request->email) { //si he modificado el mail:
            $this->sendMailChanged($user); //envío el correo pasándole el usuario
            $user->email = $request->email; //asigno el correo
            $user->email_verified_at = null; //quito la verificación
            $user->sendEmailVerificationNotification(); //envío la verificación al nuevo correo
            session()->flash('login', true);
            Auth::logout();
            //\Illuminate\Support\Facades\Auth::logout();
            $redirect = 'login';
        }
        try {
            $user->save(); //guardo el user en la BBDD
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['usererror' => '...']);
        }
        return redirect($redirect)->with(['userchange' => true]);
    }

    public function sendMailChanged($user)
    { //envío correo avisando de que se ha cambiado el correo
        //creo URL firmada                                                  parámetro ID
        $ruta = URL::TemporarySignedRoute('email.restore', now()->addDays(1), ['id' => $user->id, 'email' => $user->email]);
        $correo = new ChangeUserEmail($ruta); //creo el objeto correo que voy a enviar
        Mail::to($user)->send($correo); //cuando cambie la cuenta de correo envío un correo a la cuenta anterior
        //$user es un objeto $user
    }

    private function userValidate(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            //para que nos deje repetir el propio email pero no el de otro user de la bbdd
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id],
        ]);
    }


    //muestra el formulario de restauración de mail(get)
    function restoreEmail(Request $request, $id, $email) //pasamos los dos parámetros de la ruta
    {
        $user = User::find($id);
        $ruta = \URL::TemporarySignedRoute('email.restore', now()->addDays(1), ['id' => $user->id, 'email' => $user->email]);
        return view('auth.restore')->with(['email' => $email, 'nombre' => $user->name, 'ruta' => $ruta]);
    }

    //ejecuta el form de restauración de mail (post)
    function restorePreviousEmail(Request $request, $id, $email)
    {
        $user = User::find($id);
        // dd($email);
        $user->email = $email;
        try {
            $user->save();
            session()->flash('restoreemail', true); //se ha restablecido correctamente tu cuenta de correo anterior
        } catch (\Exception $e) {
            session()->flash('restoreemail', false); //no se ha restablecido correctamente tu cuenta de correo anterior
        }
        return redirect('login');
    }


    public function updateLocation(Request $request, $id)
    {
        $user = User::find($id);
        $user->provincia_id = $request->provincia_id;
        try {
            $result = $user->save();
        } catch (\exception $e) {
            $result = 0;
        }
        $response = ['op' => 'updateProvincia', 'r' => $result, 'id' => $user->id];
        return redirect('home')->with($response);
    }
}
