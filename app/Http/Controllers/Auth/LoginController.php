<?php

namespace App\Http\Controllers\Auth;

use App\LoginLog;
use Jenssegers\Agent\Agent;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Adldap\Laravel\Facades\Adldap;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //Esta función genera los logs de inicio de sesión de los usuarios
    function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        $agent = new Agent();

        if($agent->isDesktop()){
            $device = 'Desktop';
        }elseif($agent->isMobile()){
            $device = 'Mobile';
        }elseif($agent->isTablet()){
            $device = 'Tablet';
        }
        LoginLog::create([
           'username' => $user->email,
           'email' => $user->email,
           'ip' => $request->getClientIp(),
           'device' => $device,
           'platform' => $agent->platform().' '.floatval($agent->version($agent->platform())),
           'browser' => $agent->browser().' '.floatval($agent->version($agent->browser())),
        ]);
    }
    // Función para permitir el login de el usuario solamente una vez
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = Session::getId();
        Auth::user()->save();
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
    //
    // Funciones de la librería para las conexiones con el LDAP
    //
	public function username()
    {
        // we could return config('ldap_auth...') directly
        // but it seems to change a lot and with this check we make sure
        // that it will fail in future versions, if changed.
        // you can return the config(...) directly if you want.
        //$column_name = config('ldap_auth.identifiers.database.username_column', null);
        //dd($column_name);
        /*if ( !$column_name ) {
            die('Error in LoginController::username(): could not find username column.');
        }
        return $column_name;*/
        return 'username';
    }
    /*protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string|regex:/^[A-Za-z]+\.[A-Za-z]+$/',
            'password' => 'required|string',
        ]);
    }*/

    protected function attemptLogin(Request $request)
    {
        //dd("Logueo Dominio");
        $credentials = $request->only($this->username(), 'password');
        //dd($credentials);
        $username = $credentials[$this->username()];
        $password = $credentials['password'];

        //$user_format = env('LDAP_USER_FORMAT', 'cn=%s,'.env('LDAP_BASE_DN', ''));
        $user_format = env('LDAP_USER_FORMAT');
        //dd($user_format);
        $userdn = sprintf($user_format, $username);
        //dd($userdn);
        //dd($username);
        /*$varible_user = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();
        dd($varible_user);*/
        /*foreach($varible_user->memberof as $grupo){
            $partes = explode(",", $grupo);
            foreach($partes as $parte){
                if(strpos($parte, 'CN=GRP-ASG') !== false){
                    $asgGrupo = $parte;
                }
            }
        }
        dd($asgGrupo);*/
        //dd(Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first());
        //dd(Adldap::auth()->attempt($userdn, $password));
        //dd(Adldap::auth()->attempt($userdn, $password));
        //dd(Adldap::auth()->bind($userdn, $password));
        //dd(Adldap::auth()->attempt($userdn, $password, $bindAsUser = true));
        //dd(Adldap::search()->where(env('LDAP_USER_FORMAT'), '=', $username)->first());

        // you might need this, as reported in
        // [#14](https://github.com/jotaelesalinas/laravel-simple-ldap-auth/issues/14):
        //Adldap::auth()->bind($userdn, $password);
        //$testUser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();
        //$testUser = Adldap::auth()->attempt($userdn, $password, $bindAsUser = true);
        //dd($testUser);
        if(Adldap::auth()->attempt($userdn, $password, $bindAsUser = true)) {
            // the user exists in the LDAP server, with the provided password

            $user = \App\User::where($this->username(), $username)->first();
            //dd($user);
            //Nuevo
            $ldapuser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();

            // Validamos si el usuario pertenece a algun grupo
            //dd($ldapuser);
            if($ldapuser->memberof){
                foreach($ldapuser->memberof as $grupo){
                // foreach($simulado as $grupo){
                    $partes = explode(",", $grupo);
                    foreach($partes as $parte){
                        if(strpos($parte, 'CN=GRP-ASG') !== false){
                            $asgGrupo = $parte;
                            // array_push($groupsNew,$asgGrupo);
                        }
                    }
                }

                // El usuario no tiene ningún grupo de Asgard asignado'
                if(!isset($asgGrupo)){
                    // buscar metodo para retorno aquí.
                    return false;

                }

                // $asgGrupo = implode(";",$groupsNew);

                // grupos del usuario
                // dd($groupsNew,implode(";",$groupsNew) );


                // El usuario no tiene ningún grupo asignado'


            }else{
                // buscar metodo para retorno aquí.
                return false;
            }
            if (!$user) {
                // the user doesn't exist in the local database, so we have to create one
                /*
                foreach($grupos as $grupo){
                    $partes = explode(",", $grupo);
                    foreach($partes as $parte){
                        if(strpos($parte, 'CN=GRP-ASG') !== false){
                            $asgGrupo = $parte;
                        }
                    }
                }
                $asgGrupo = str_replace('CN=','',$asgGrupo); */

                $user = new \App\User();
                $user->username = $username;
                $user->password = '';

                // you can skip this if there are no extra attributes to read from the LDAP server
                // or you can move it below this if(!$user) block if you want to keep the user always
                // in sync with the LDAP server
                $sync_attrs = $this->retrieveSyncAttributes($username);
                // dd($sync_attrs);
                foreach ($sync_attrs as $field => $value) {
                    $user->$field = $value !== null ? $value : '';
                }
                //dd($user);
                // dd($user);
                // dd(explode(";",$user->group));
                // foreach( explode(";",$user->group) as $grupo){
                    $user->assignRole(explode(";",$user->group));
                // }

            }else
			{
                // Algo que no sirve no copiar
				$sync_attrs = $this->retrieveSyncAttributes($username);


                //dd($sync_attrs['grupo']);

                // dd();

                // Lista de usuarios con problemas
                // $user->email = 'ICF7771A@claro.co';
                // $sync_attrs['group'] = 'GRP-ASG-Admin-Master';
                // $sync_attrs['group'] = explode(";",$sync_attrs['group']);
                if ($user->email == 'ICF7771A@claro.co' && in_array('GRP-ASG-Admin-Master',explode(";",$sync_attrs['group']))){
                    $sync_attrs['group'] = 'GRP-ASG-DES';
                }

                // dd($sync_attrs['group'],1);

                // $user->email = 'ECM8580E@claro.co';
                // $sync_attrs['group'] = 'GRP-ASG-Admin-Master';
                // $sync_attrs['group'] = explode(";",$sync_attrs['group']);
                if ($user->email == 'ECM8580E@claro.co' && in_array('GRP-ASG-Admin-Master',explode(";",$sync_attrs['group']) )){
                    $sync_attrs['group'] = 'GRP-ASG-DES';
                }

                // dd($sync_attrs['group'],2);
                // fin lista
				$user->update([
					'email' => $sync_attrs['email'],
					'group' => $sync_attrs['group'],
				]);
                // dd($sync_attrs['group']);
                // dd(explode(";",$sync_attrs['group']));
                // foreach( explode(";",$sync_attrs['group']) as $grupo){
                    // dd(explode(";",$sync_attrs['group']));
                    $user->syncRoles( explode(";",$sync_attrs['group']) );
                    // $user->assignRole($grupo);
                // }
			}

            // by logging the user we create the session, so there is no need to login again (in the configured time).
            // pass false as second parameter if you want to force the session to expire when the user closes the browser.
            // have a look at the section 'session lifetime' in `config/session.php` for more options.
            $this->guard()->login($user, false);
            // dd("posible creacion");
            return true;

        }

        // the user doesn't exist in the LDAP server or the password is wrong
        // log error
        return false;
            /*
            if (isset ($request->local) ) {
                # code...
                return $this->guard()->attempt(
                    $this->credentials($request), $request->filled('remember')
                );
            }else
            {

            }*/

    }

    protected function retrieveSyncAttributes($username)
    {
        $ldapuser = Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username)->first();
        if ( !$ldapuser ) {
            // log error
            return false;
        }
        // if you want to see the list of available attributes in your specific LDAP server:
        //var_dump($ldapuser->attributes); exit;
        //dd($ldapuser->attributes);

        // needed if any attribute is not directly accessible via a method call.
        // attributes in \Adldap\Models\User are protected, so we will need
        // to retrieve them using reflection.

        $ldapuser_attrs = null;


        $groupsNew = [];

        $attrs = [];
        // $simulado = [
        //     "CN=GRP-ASG-Admin-Master,OU=Grupos,OU=CLARO - Resources,DC=claro,DC=co",
        //     "CN=GRP-ASG-DES,OU=Grupos,OU=CLARO - Resources,DC=claro,DC=co"
        // ];
        foreach($ldapuser->memberof as $grupo){
        //    foreach( $simulado as $grupo ){
            $partes = explode(",", $grupo);
            // dd($partes);
            foreach($partes as $parte){
                if(strpos($parte, 'CN=GRP-ASG') !== false){
                    $asgGrupo = $parte;
                    array_push($groupsNew,$asgGrupo);
                }
            }
        }
        // dd($asgGrupo);
        // $asgGrupo = str_replace('CN=','',$asgGrupo);

        // nuevo
        foreach( $groupsNew as $index => $grupito ){
            $groupsNew[$index] = str_replace('CN=','',$grupito);
        }
        $ldapuser['group'] = implode(";",$groupsNew);

        // dd($ldapuser);
        foreach (config('ldap_auth.sync_attributes') as $local_attr => $ldap_attr) {
            if ( $local_attr == 'username' ) {
                continue;
            }

            $method = 'get' . $ldap_attr;
            //dd($ldapuser);
            if (method_exists($ldapuser, $method)) {
                $attrs[$local_attr] = $ldapuser->$method();
                continue;
            }


            if ($ldapuser_attrs === null) {
                $ldapuser_attrs = self::accessProtected($ldapuser, 'attributes');
            }

            if (!isset($ldapuser_attrs[$ldap_attr])) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            if (!is_array($ldapuser_attrs[$ldap_attr])) {
                $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr];
            }

            if (count($ldapuser_attrs[$ldap_attr]) == 0) {
                // an exception could be thrown
                $attrs[$local_attr] = null;
                continue;
            }

            // now it returns the first item, but it could return
            // a comma-separated string or any other thing that suits you better
            $attrs[$local_attr] = $ldapuser_attrs[$ldap_attr][0];
            //$attrs[$local_attr] = $ldapuser_attrs[$ldap_attr][13][0];
            //$attrs[$local_attr] = implode(',', $ldapuser_attrs[$ldap_attr]);
        }
        //dd($attrs['grupo']);
        return $attrs;
    }

    protected static function accessProtected ($obj, $prop)
    {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

}
