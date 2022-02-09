<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    

    public function login(Request $request) {
        $input = $request->all();
        // dd($input);
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // dd($request);

        // foreach($input as $i => $i_value) {
        //     echo $i_value;
        // }

        if($request->rememberme===null){
            setcookie('login_email',$request->email,100);
            setcookie('login_pass',$request->password,100);
         }
         else{
            setcookie('login_email',$request->email,time()+60*60*24*100);
            setcookie('login_pass',$request->password,time()+60*60*24*100);
         }
         
       

        // dd($remember_me);

        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            if (auth()->user()->is_admin == 1) {
                // if($request->has('remember')){
                //     Cookie::queue('email', $request->email,1440);
                //     Cookie::queue('password', $request->password,1440);
                // }
                Session::put('user_session', $input['email']);
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login')->with('error', 'E-mail-address or Password wrong.');
        }
    }
}
