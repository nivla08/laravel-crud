<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {

        return view('auth.login');

    }

    public function username() {

        return 'email';

    }

    protected function validateLogin(Request $request){
    $this->validate($request, [
        $this->username() => 'required|exists:users,' . $this->username() . ',active,1',
        'password' => 'required',
    ], [
        $this->username() . '.exists' => 'The selected email is invalid or the account has been disabled.'
    ]);
}

    public function maxAttempts() {

        return property_exists($this, 'maxAttempts') ?
                $this->maxAttempts : config('site_settings.throttle_attempts');
    }

    public function decayMinutes() {

        return property_exists($this, 'decayMinutes') ?
            $this->decayMinutes : config('site_settings.throttle_lockout_time');
    }

}
