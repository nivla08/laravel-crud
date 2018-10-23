<?php

return [
	'forgot_password'				=> env('SETTINGS_FORGOT_PASSWORD', 1),
	'google_recaptcha'				=> env('SETTINGS_GOOGLE_RECAPTCHA', 1),
	'remember_me'					=> env('SETTINGS_REMEMBER_ME', 1),
	'reset_token'					=> env('SETTINGS_RESET_TOKEN', 60),
	'reg_email_confirmation'		=> env('SETTINGS_REG_EMAIL_CONFIRMATION', 1),
	'reg_enabled'					=> env('SETTINGS_REG_ENABLED', 1),
	'throttle_enabled'				=> env('SETTINGS_REG_ENABLED', 1),
	'throttle_attempts'				=> env('SETTINGS_THROTTLE_ATTEMPTS', 5),
	'throttle_lockout_time'			=> env('SETTINGS_THROTTLE_LOCKOUT_TIME', 1),
	'termsandcondition'				=> env('SETTINGS_TERMSANDCONDITION', 0),
	'google_recaptcha_secret_key' 	=> env('SETTINGS_RECAPTCHA_SECRET_KEY', 'YOUR_GOOGLE_RECAPTCHA_SECRET_KEY'),
];

 ?>
