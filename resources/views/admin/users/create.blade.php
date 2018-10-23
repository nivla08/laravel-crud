@section('css')
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection
@section('page-title', 'Create Users')
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Create New User</h2>
		{{ Breadcrumbs::render('user-create') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="row">
	<div class="col-lg-12">
	    <div class="ibox">
			<form method="POST" action="/admin/users">
				@csrf
	        <div class="ibox-content">
				<div class="row">
					<div class="col-sm-3">
						<p>User Details</p>
						<p>A general user profile information. </p>
					</div>
					<div class="col-sm-4">
						<div class="form-group {{ $errors->first('roles') ? 'has-error' : '' }}">
							<label class="col-form-label">Roles*</label>
							<select class="select2_roles form-control" name="roles[]" multiple="multiple" required>
								@foreach ($roles as $key => $value)
										<option value="{{ $key }}">{{ $value }}</option>
								@endforeach
							</select>
							@if ($errors->first('roles'))
								<span role="alert" class="text-danger"><strong>{{ $errors->first('roles') }}*</strong></span>
							@endif
						</div>
						<div class="form-group {{ $errors->first('first_name') ? 'has-error' : '' }}">
							<label class="col-form-label">First Name*</label>
							<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
							@if ($errors->first('first_name'))
								<span role="alert" class="text-danger"><strong>{{ $errors->first('first_name') }}*</strong></span>
							@endif
						</div>
						<div class="form-group {{ $errors->first('last_name') ? 'has-error' : '' }}">
						   <label class="col-form-label">Last Name*</label>
						   <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
						   @if ($errors->first('last_name'))
							   <span role="alert" class="text-danger"><strong>{{ $errors->first('last_name') }}*</strong></span>
						   @endif
					   </div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="col-form-label" for="active">Status</label>
							<select name="active" id="active" class="form-control">
								<option value="1">Enabled</option>
								<option value="0" selected>Disabled</option>
							</select>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="ibox">
			<div class="ibox-content">
				<div class="row">
					<div class="col-sm-3">
						<p>Login Details</p>
						<p>Details used for authenticating with the application. </p>
					</div>
					<div class="col-sm-9">
						<div class="form-group {{ $errors->first('username') ? 'has-error' : '' }}">
							<label class="col-form-label">Username*</label>
							<input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
							@if ($errors->first('username'))
								<span role="alert" class="text-danger"><strong>{{ $errors->first('username') }}*</strong></span>
							@endif
						</div>

					   <div class="form-group  {{ $errors->first('email') ? 'has-error' : '' }}">
						  <label class="col-form-label">Email*</label>
						  <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
						  @if ($errors->first('email'))
							  <span role="alert" class="text-danger"><strong>{{ $errors->first('email') }}*</strong></span>
						  @endif
					  </div>
						<div class="form-group {{ $errors->first('password') ? 'has-error' : '' }}">
						  <label class="col-form-label">Password*</label>
						  <input type="password" class="form-control" name="password" required>
						  @if ($errors->first('password'))
							  <span role="alert" class="text-danger"><strong>{{ $errors->first('password') }}*</strong></span>
						  @endif
						</div>
						<div class="form-group">
						  <label class="col-form-label">Password Comfirmation*</label>
						  <input type="password" class="form-control" name="password_confirmation" required>
						</div>
					</div>
				</div>
				<button class="btn btn-lg btn-primary" type="submit">Create</button>
			</div>
		</form>
		</div>
	</div>
</div>
@endsection
@section('js-plugin')
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
@endsection
@section('js-custom')
<script>
	$(document).ready(function(){
		$(".select2_roles").select2();
		@if(session('success'))
		toastr.success('{{session('success')}}');
		@endif
		@if(session('message'))
		toastr.error('{{session('message')}}');
		@endif
	});
</script>
@endsection
