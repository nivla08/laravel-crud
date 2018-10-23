@section('page-title') Authentication Settings @endsection
@section('css')
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Authentication</h2>
		{{ Breadcrumbs::render('settings-authRegistration') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
    <div class="tabs-container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
				<a class="nav-link active show" data-toggle="tab" href="#auth">
					<i class="fa fa-lock"></i>Authentication
				</a>
			</li>
            <li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#regisration">
					<i class="fa fa-user-plus"></i>Registration
				</a>
			</li>
        </ul>
        <div class="tab-content m-t-lg">
            <div role="tabpanel" id="auth" class="tab-pane active">
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
						  <div class="card-header no-borders font-bold">General</div>
						  <div class="card-body">
							  <form method="POST" action="{{ route('settings.authRegistration') }}">
								  @csrf
								  <div class="form-group row">
									  <div class="col-3">
										  <input class="js-switch" 	name="remember_me" {{ config('site_settings.remember_me') == 1 ? 'checked="checked"' : '' }} type="checkbox">
									  </div>
									  <div class="col-9">
										  <label class="mb-0">Allow "Remember Me"</label><Br  />
										  <small class="pt-0 text-muted">Should 'Remember Me' checkbox be displayed on login form? </small>
									  </div>
								  </div>
								  <div class="form-group row">
									  <div class="col-3">
										  <input class="js-switch" name="forgot_password"  {{ config('site_settings.forgot_password') == 1 ? 'checked="checked"' : '' }} type="checkbox">
									  </div>
									  <div class="col-9">
										  <label class="mb-0">Forgot Password"</label><br />
										  <small class="pt-0 text-muted">Enable/Disable forgot password feature.  </small>
									  </div>
								  </div>
								  <div class="form-group m-t-lg">
								  	<label class="font-bold">Reset Token Lifetime </label><br/>
									<small class="pt-0 text-muted">Number of minutes that the reset token should be considered valid.</small>
									<input name="login_reset_token_lifetime" class="form-control" value="{{ config('site_settings.reset_token') }}" type="number" placeholder="the default is 60" pattern="^[0-9]+">

								  </div>
								  <button class="btn btn-primary m-t-sm" name="auth-general-settings-form">Update Settings</button>
							  </form>
						  </div>
						</div>
						<div class="card m-t-lg m-b-lg">
						  <div class="card-header no-borders">Two-Factor Authentication</div>
						  <div class="card-body">
							  <form method="POST" action="/settings/auth/2fa/enable">
								  @csrf
								  <small class="pt-0 text-muted">Enable/Disable Two-Factor Authentication for the application.</small>
								  <button type="submit" class="btn btn-primary m-t-sm" name="auth-2fa-settings-form">Enable</button>
							  </form>
						  </div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="card">
						  <div class="card-header no-borders font-bold">Authentication Throttling</div>
						  <div class="card-body">
							  <form method="POST" action="{{ route('settings.authRegistration') }}">
								  @csrf
								  <div class="form-group row">
									  <div class="col-3">
										  <input class="js-switch" {{ config('site_settings.throttle_enabled') == 1 ? 'checked="checked"' : '' }} name="throttle_enabled" type="checkbox">
									  </div>
									  <div class="col-9">
										  <label class="mb-0">Throttle Authentication</label><Br  />
										  <small class="pt-0 text-muted">Should the system throttle authentication attempts? </small>
									  </div>
								  </div>
								  <div class="form-group m-t-lg">
									<label class="font-bold">Maximum Number of Attempts </label><br/>
									<small class="pt-0 text-muted">Maximum number of incorrect login attempts before lockout.</small>
									<input name="throttle_attempts" class="form-control" value="{{ config('site_settings.throttle_attempts') }}" type="number" placeholder="the default is 5 attempts" pattern="^[0-9]+">
								  </div>
								  <div class="form-group m-t-lg">
									<label class="font-bold">Lockout Time </label><br/>
									<small class="pt-0 text-muted">Number of minutes to lock the user out for after specified maximum number of incorrect login attempts.</small>
									<input name="throttle_lockout_time" class="form-control" value="{{ config('site_settings.throttle_lockout_time') }}" type="number" placeholder="the default is 1" pattern="^[0-9]+">
								  </div>
								  <button class="btn btn-primary m-t-sm" name="auth-throttle-settings-form">Update Settings</button>
							  </form>
						  </div>
						</div>
					</div>
				</div>
            </div>
            <div role="tabpanel" id="regisration" class="tab-pane">
				<div class="row">
					<div class="col-lg-6">
						<div class="card">
						  <div class="card-header no-borders font-bold">General</div>
						  <div class="card-body">
							  <form method="POST" action="{{ route('settings.authRegistration') }}">
								  @csrf
								  <div class="form-group row">
									  <div class="col-3">
										  <input class="js-switch"  name="reg_enabled" {{ config('site_settings.reg_enabled') == 1 ? 'checked="checked"' : '' }} type="checkbox">
									  </div>
									  <div class="col-9">
										  <label class="mb-0">Allow Registration</label><Br  />
									  </div>
								  </div>
								  <div class="form-group row">
									  <div class="col-3">
										  <input class="js-switch" name="toc" {{ config('site_settings.termsandcondition') == 1 ? 'checked="checked"' : '' }} type="checkbox">
									  </div>
									  <div class="col-9">
										  <label class="mb-0">Terms & Conditions</label><br />
										  <small class="pt-0 text-muted">The user has to confirm that he agree with terms and conditions in order to create an account. </small>
									  </div>
								  </div>
								  <div class="form-group row">
									  <div class="col-3">
										  <input class="js-switch" name="reg_email_confirmation" {{ config('site_settings.reg_email_confirmation') == 1 ? 'checked="checked"' : '' }} type="checkbox">
									  </div>
									  <div class="col-9">
										  <label class="mb-0">Email Confirmation</label><br />
										  <small class="pt-0 text-muted">Require email confirmation from your newly registered users. </small>
									  </div>
								  </div>
								  <button class="btn btn-primary m-t-sm" name="registration-settings-form">Update Settings</button>
							  </form>
						  </div>
						</div>

					</div>
					<div class="col-lg-6">
						<div class="card">
						  <div class="card-header no-borders font-bold">Google reCAPTCHA </div>
						  <div class="card-body">
							  <form method="POST" action="@if(config('site_settings.google_recaptcha') == 0){{ route('settings.enableRecaptcha') }} @elseif (config('site_settings.google_recaptcha') == 1) {{ route('settings.disableRecaptcha') }} @endif">
								  @csrf
								  <small class="pt-0 text-muted">Enable/Disable Google reCAPTCHA during the registration. </small> <br />
								  @if (config('site_settings.google_recaptcha') == 0)
									  <button type="submit" class="btn btn-primary m-t-sm" name="enable-captcha-settings-form">Enable</button>
								  @endif
								  @if (config('site_settings.google_recaptcha') == 1)
									  <button type="submit" class="btn btn-primary m-t-sm" name="disable-captcha-settings-form">Disable</button>
								  @endif
							  </form>
						  </div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-plugin')
<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
@endsection
@section('js-custom')
<script>
    $(document).ready(function () {
    	@if(session('success'))
    	toastr.success('{{session('success')}}');
    	@endif

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });

    });

</script>
@endsection
