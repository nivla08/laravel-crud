@section('page-title')Reset Password | {{ config('app.name', 'Laravel') }}@endsection
@section('bg-color', 'white-bg')
@include('partials.theme01.head')
  <div class="passwordBox animated fadeInDown">
      <div class="row">
        <div class="col-md-12">
          <div class="ibox-content">
            <h2 class="font-bold">{{ __('Reset Password') }}</h2>
              <div class="row">
                <div class="col-lg-12">
                  <form class="m-t" role="form" method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                    @csrf
                    <div class="form-group">
                      <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
                      <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                      <label for="password" class="col-form-label">{{ __('Password') }}</label>
                      <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                      @if ($errors->has('password'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Reset Password') }}</button>
                  </form>
                </div>
              </div>
          </div>
        </div>
      </div>
      <hr/>
      <div class="row">
          <div class="col-md-6">
              Copyright {{ config('app.name') }}
          </div>
          <div class="col-md-6 text-right">
             <small>© {{ date('Y') }}</small>
          </div>
      </div>
  </div>

</body>

</html>
