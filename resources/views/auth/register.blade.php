@section('page-title'){{ config('app.name', 'Laravel') }} | Register @endsection
@section('css')
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection
@if(config('site_settings.google_recaptcha') == 1)
@section('recaptcha')<script src='https://www.google.com/recaptcha/api.js'></script>@endsection
@endif
@section('bg-color', 'gray-bg')
@include('partials.theme01.head')
  <div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        {{-- <div>
            <h1 class="logo-name">IN+</h1>
        </div> --}}
        <h3>{{ __('Register') }}</h3>
        <p>Create account to see it in action.</p>
        <form class="m-t" role="form" method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}" id="form-register">
          @csrf
          <div class="form-group row">
            <label for="email" class="col-form-label">{{ __('Email') }} *</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group row">
            <label for="username" class="col-form-label">{{ __('Username') }} *</label>
            <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group row">
            <label for="first_name" class="col-form-label">{{ __('First Name') }} *</label>
            <input id="first-name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>

            @if ($errors->has('first_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group row">
            <label for="last_name" class="col-form-label">{{ __('Last Name') }} *</label>
            <input id="last-name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>

            @if ($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group row">
            <label for="password" class="col-form-label">{{ __('Password') }} *</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group row">
            <label for="password_confirmation" class="col-form-label">{{ __('Comfirm Password') }} *</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
          </div>
           @if (config('site_settings.termsandcondition') == 1)
          <div class="form-group">
              <div class="checkbox i-checks"><label> <input type="checkbox" name="termsAndCondition" required><i></i> Agree the terms and policy </label></div>
              @if(session('message')) <span class="text-danger small" role="alert"><strong>**{{ session('message') }}**</strong></span> @endif
          </div>
          @endif

          @if (config('site_settings.google_recaptcha') == 1)
              <div class="g-recaptcha" data-sitekey="6Ld4BnMUAAAAANLl-6HrQQvRANcK5DEp-sf__oad"></div>
          @endif
          <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Register') }}</button>
          <p class="text-muted text-center"><small>Already have an account?</small></p>
          <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Login</a>
        </form>
        <p class="m-t"> <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
  </div>

  </div>

  <!-- Mainly scripts -->
  <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
  <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
  <!-- Custom and plugin javascript -->
  <script src="{{ asset('js/inspinia.js') }}"></script>
  <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
  <script>
      $(document).ready(function(){
          $('.i-checks').iCheck({
              checkboxClass: 'icheckbox_square-green',
          });
          @if(config('site_settings.google_recaptcha') == 1)
          $('#form-register').submit(function(event) {
              var verified = grecaptcha.getResponse();
              if (verified.length === 0) {
                  event.preventDefault();
              }
          });
          @endif
      });
  </script>
</body>

</html>
