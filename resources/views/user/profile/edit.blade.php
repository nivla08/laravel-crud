@section('page-title', $user->username)
@section('css')
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>My Profile</h2>
		{{ Breadcrumbs::render('profile') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
	<div class="row">
		<div class="col-lg-8">
			<form method="POST" action="{{ route('profile.update') }}">
				@csrf
				@yield('form_method')
			<div class="ibox">
				<div class="ibox-content">
					<div class="tabs-container">
						<ul class="nav nav-tabs" role="tablist">
							<li><a class="nav-link active show" data-toggle="tab" href="#tab-1">User Details</a></li>
							<li><a class="nav-link" data-toggle="tab" href="#tab-2">Login Details</a></li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" id="tab-1" class="tab-pane active show">
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-3">
											<p>A general user profile information. </p>
										</div>
										<div class="col-sm-4">
											<div class="form-group {{ $errors->first('roles') ? 'has-error' : '' }}">
												<label class="col-form-label">Roles*</label>
												<select class="select2_roles form-control" name="roles[]" multiple="multiple" @if(!auth()->user()->can('roles.manage')) disabled @endif >
												@foreach ($roles as $key => $value)
													@if ($user->hasRole($value))
														<option value="{{ $key }}" selected>{{ $value }}</option>
													@else
														<option value="{{ $key }}">{{ $value }}</option>
													@endif

												@endforeach
												</select>
												@if ($errors->first('roles'))
													<span role="alert" class="text-danger"><strong>{{ $errors->first('roles') }}*</strong></span>
												@endif
											</div>
											<div class="form-group {{ $errors->first('first_name') ? 'has-error' : '' }}">
												<label class="col-form-label">First Name*</label>
												<input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required>
												@if ($errors->first('first_name'))
													<span role="alert" class="text-danger"><strong>{{ $errors->first('first_name') }}*</strong></span>
												@endif
											</div>
											<div class="form-group {{ $errors->first('last_name') ? 'has-error' : '' }}">
											   <label class="col-form-label">Last Name*</label>
											   <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required>
											   @if ($errors->first('last_name'))
												   <span role="alert" class="text-danger"><strong>{{ $errors->first('last_name') }}*</strong></span>
											   @endif
										   </div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label class="col-form-label" for="activated">Status</label>
												<input type="text" class="form-control" name="activated" value="{{ $user->activated == 1 ? 'active' : 'banned'}}" disabled>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" id="tab-2" class="tab-pane">
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-3">
											<p>Details used for authenticating with the application. </p>
										</div>
										<div class="col-sm-9">
											<div class="form-group {{ $errors->first('username') ? 'has-error' : '' }}">
												<label class="col-form-label">Username*</label>
												<input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
												@if ($errors->first('username'))
													<span role="alert" class="text-danger"><strong>{{ $errors->first('username') }}*</strong></span>
												@endif
											</div>

										   <div class="form-group  {{ $errors->first('email') ? 'has-error' : '' }}">
											  <label class="col-form-label">Email*</label>
											  <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
											  @if ($errors->first('email'))
												  <span role="alert" class="text-danger"><strong>{{ $errors->first('email') }}*</strong></span>
											  @endif
										  </div>
											<div class="form-group {{ $errors->first('password') ? 'has-error' : '' }}">
											  <label class="col-form-label">Password</label>
											  <input type="password" class="form-control" name="password" placeholder="Leave field blank it you don't want to change it">
											  @if ($errors->first('password'))
												  <span role="alert" class="text-danger"><strong>{{ $errors->first('password') }}*</strong></span>
											  @endif
											</div>
											<div class="form-group">
											  <label class="col-form-label">Confirm Password</label>
											  <input type="password" class="form-control" name="password_confirmation" placeholder="Leave field blank it you don't want to change it">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button class="btn btn-lg btn-primary" type="submit">Save Changes</button>
			</div>
			</form>
		</div>
		<div class="col-lg-4">
			<div class="ibox">
				 <div class="ibox-content text-center">
					 <div class="m-b-md">
						<img alt="{{ $user->fullname }}" class="avatar rounded-circle img-thumbnail img-responsive" src="{{ $user->getFirstMediaUrl('avatar') ? $user->getFirstMediaUrl('avatar', 'thumb') :  asset('images/profile.png') }}">
					</div>

					<form id="avatar-form" method="POST" action="{{ route('profile.upload') }}" enctype="multipart/form-data">

						@csrf
						<input type="file" name="avatar"/>
						<input type="submit" id="avatar-submit" value="Upload" class="btn btn-outline-secondary btn-block" >
					</form>
				 </div>
			 </div>
		 </div>
	 </div>
@endsection
@section('js-plugin')
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- profile js -->
<script src="{{ asset('js/custom/profile.js') }}"></script>
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
