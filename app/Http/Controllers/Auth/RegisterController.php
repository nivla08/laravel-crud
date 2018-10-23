<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('guest');

    }

    public function showRegistrationForm() {

        if ($this->isRegEnable() == 1 ){

            return view('auth.register');
        }

        return redirect('login');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'username'      => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'first_name'    => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {

        if (config('site_settings.termsandcondition') == 1) {

            if ((!$request->has('termsAndCondition'))
                                && (!$request->filled('termsAndCondition'))) {

                return redirect()->back()
                ->with('message', 'User you must agree in our terms and condtions');
            }

        }

        if($this->isRecaptchaEnable() == true) {

            if ($this->hasRecaptchaReponse($request) == true) {
                $token      = $request->input('g-recaptcha-response');
                $client     = new Client();
                $recaptcha_secret_key = config('site_settings.google_recaptcha_secret_key');
                $response   = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                    'form_params'   => array(
                            'secret'    => $recaptcha_secret_key,
                            'response'  => $token
                            )
                ]);
                $result     = json_decode($response->getBody()->getContents());
                if ($result->success == false) {
                    return redirect()->back(); //bots are not allowed
                }
            }

        }

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {

        return User::create([
            'username'      => $data['username'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'active'        => 1,
        ]);

    }

    public function isRegEnable() {

        $reg_enabled = config('site_settings.reg_enabled');

        return $reg_enabled;

    }


    // if request not have recaptcha response redirect to login
    public function hasRecaptchaReponse($request) {

        if ( ! $request->filled('g-recaptcha-response')) {
            return false; // did't get g-recaptcha-response
        }

        return true; // validate g-recaptcha-response token
    }

    public function isRecaptchaEnable() {

        $google_recaptcha = config('site_settings.google_recaptcha');

        if ($google_recaptcha == 0 ){

            return false; // recaptcha disable

        }

        return true; // recaptcha enable

    }
}
