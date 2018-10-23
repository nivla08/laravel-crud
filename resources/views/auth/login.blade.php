@section('page-title') Login | {{ config('app.name', 'Laravel') }} @endsection
@section('bg-color', 'gray-bg')
@include('partials.theme01.head')
  <div class="middle-box loginscreen animated fadeInDown">
  <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" id="form-login">
        @csrf
      <div class="form-group">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="youname@email.com" name="email" value="{{ old('email') }}" required autofocus>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group">
        <input id="password" type="password" name="password" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Password" required="">
        @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
      </div>
      @if(config('site_settings.allow_remember_me') == 1)
      <div class="form-group text-center">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
      </div>
        @endif
        <div class="text-center">
          <button type="submit" class="btn btn-primary block full-width m-b">  {{ __('Login') }}</button>
          @if(config('site_settings.forgot_password') == 1)
          <a href="{{ route('password.request') }}"><small>{{ __('Forgot Your Password?') }}</small></a>
          @endif
          @if(config('site_settings.reg_enabled') == 1)
          <p class="text-muted text-center"><small>Do not have an account?</small></p>
          <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">Create an account</a>
          @endif
        </div>
      </form>

  </div>
</div>

  <!-- Mainly scripts -->
  <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>

</html>
