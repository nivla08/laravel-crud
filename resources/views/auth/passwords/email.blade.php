@section('page-title')Request Password Reset | {{ config('app.name', 'Laravel') }} @endsection
@section('bg-color', 'white-bg')
@include('partials.theme01.head')
  <div class="passwordBox animated fadeInDown">
    <div class="row">

      <div class="col-md-12">
          <div class="ibox-content">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
              <h2 class="font-bold">Forgot password</h2>
              <p>Enter your email address and your password will be reset and emailed to you.</p>
              <div class="row">
                <div class="col-lg-12">
                  <form class="m-t" method="POST" role="form" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf
                      <div class="form-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                      </div>
                      <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Send Password Reset Link') }}</button>
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
  </div>

</body>

</html>
