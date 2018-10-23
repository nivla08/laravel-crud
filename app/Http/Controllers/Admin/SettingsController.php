<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\AuthRegistrationRequest;
use Validator;

class SettingsController extends Controller {
    //
	public function __construct() {

		$this->middleware('auth');
		$this->middleware(['role_or_permission:administrator|
							manage.auth.settings|
							manage.general.settings'
						  ]
						);

	}

	public function general(Request $request) {

		$env = new DotenvEditor();

		if ($request->isMethod('post')) {
				$env->changeEnv([
		        'APP_NAME'   => '"'.$request->app_name.'"',
		    ]);
			$request->session()
										->flash('success', 'App name has changed successfully !');
		}

		return view('admin.settings.general');

	}

		public function authRegistration(request $request) {

		$env = new DotenvEditor();

		if ($request->isMethod('post')) {

			if ($request->has('auth-general-settings-form')) {
				$forgot_password 		= 0;
				$remember_me 				= 0;

				if ($request->filled('remember_me')) {
					$remember_me 			= 1;
				}

				if ($request->filled('forgot_password')) {
					$forgot_password 	= 1;
				}

				$env->changeEnv([
					'SETTINGS_RESET_TOKEN'   		=> $request->login_reset_token_lifetime,
					'SETTINGS_REMEMBER_ME'			=> $remember_me,
					'SETTINGS_FORGOT_PASSWORD'	=> $forgot_password,
				]);
				$request->session()
						->flash('success', ' General Authentication updated successfully !');
			}

			// Two-Factor Authentication
			if ($request->has('auth-2fa-settings-form')) {
				$request->session()
				->flash('success', ' Two-Factor Authentication updated successfully !');
			}

			// Authentication Throttling
			if ($request->has('auth-throttle-settings-form')) {
				$throttle_enabled 		= 0;

				if ($request->filled('throttle_enabled')) {
					$throttle_enabled 	= 1;
				}

				$env->changeEnv([
					'SETTINGS_THROTTLE_ATTEMPTS'  	 	=> $request->throttle_attempts,
					'SETTINGS_THROTTLE_ENABLED'   		=> $throttle_enabled,
					'SETTINGS_THROTTLE_LOCKOUT_TIME' 	=> $request->throttle_lockout_time,
				]);
				$request->session()
				->flash('success', ' Authentication Throttling updated successfully !');
			}

			// Registration General
			if ($request->has('registration-settings-form')) {

				$reg_enabled 						= 0;
				$termsandconditions 		= 0;
				$reg_email_confirmation = 0;

				if ($request->filled('reg_enabled')) {
					$reg_enabled = 1;
				}

				if ($request->filled('toc')) {
					$termsandconditions = 1;
				}

				if ($request->filled('reg_email_confirmation')) {
					$reg_email_confirmation = 1;
				}

				$env->changeEnv([
					'SETTINGS_REG_ENABLED'   					=> $reg_enabled,
					'SETTINGS_TERMSANDCONDITION'   		=> $termsandconditions,
					'SETTINGS_REG_EMAIL_CONFIRMATION' => $reg_email_confirmation,
				]);

				$request->session()
						->flash('success', 'Registration setting updated successfully !');
			}

			return redirect()->back();

		}

		return view('admin.settings.authRegistration');

	}


	public function EnableRecaptcha(request $request) {
		//  Google reCAPTCHA
		if ($request->has('enable-captcha-settings-form')) {
			$env = new DotenvEditor();
			$env->changeEnv([
				'SETTINGS_GOOGLE_RECAPTCHA' => 1,
			]);
			$request->session()->flash('success', '	Google reCAPTCHA  now enabled!');
			return redirect()->back();
		}

	}


	public function DisableRecaptcha(request $request) {

		if ($request->has('disable-captcha-settings-form')) {
			$env = new DotenvEditor();
			$env->changeEnv([
				'SETTINGS_GOOGLE_RECAPTCHA' => 0,
			]);
			$request->session()->flash('success', '	Google reCAPTCHA  now disable !');
			return redirect()->back();
		}

	}



}
