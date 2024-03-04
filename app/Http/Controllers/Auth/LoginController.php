<?php

namespace App\Http\Controllers\Auth;

use View;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserValidation;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\RegisterValidation;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $data = [ 'page' => 'Sign In' ];
		View::share('data', $data);
    }

    public function loginform(Request $request) {
        $msg = $request->session()->pull('session_msg', '');

        // cache requested protected url before login
        $return_url = url()->previous(); 
        if(($return_url != route('users.loginform')) && ($return_url != route('users.login'))) {
            $request->session()->put('return_url', $return_url);
        }

        return view('auth.login', compact('msg'));
    }

    public function login(Request $request) {

        // check if there was a cached protected url
        $return = $request->session()->get('return_url', url($this->redirectTo));

        $credentials = array(
            'username'=> $request->input('username'),
            'password'  => $request->input('password'),
            'u_enabled' => 1
        );

        if(Auth::attempt($credentials)) {
            return redirect(route('dashboard'));
        }

        $credentials = array(
            'email'   => $request->input('email'),
            'password'  => $request->input('password'),
            'u_enabled' => 1
        );

        if(Auth::attempt($credentials)) {
            return redirect(route('dashboard'));
        }

        session(['session_msg' => 'Invalid Username?Email or Password.']);
        return redirect(route('users.loginform'))->withInput($request->input());
    }
    
    public function logout() {
        Auth::logout();
        session(['session_msg' => 'You have been signed-out.']);
        return redirect(route('users.loginform'));
    }

    public function register(RegisterValidation $request){
        // Get input values
        $firstname = $request->input('first_name');
        $lastname = $request->input('last_name');

        // Create default username
        $defaultUsername = substr($firstname, 0, 1) . $lastname;

       

        $input = $request->validated();
        $request->request->add(['created_at' => Carbon::now(), 'username' => $defaultUsername]);
        $user   = User::create($request->all());
        
        $request->session()->put('session_msg', 'Account Registered.');
        return redirect(route('users.loginform'));
    }
}

