{{ session()->put('user_id', $user->id) }}
@section('page-title', 'Edit Users')
@section('css')
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>{{ $user->fullname }}</h2>
		{{ Breadcrumbs::render('user-edit', $user->id) }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="row">
	<div class="col-lg-8">
			<div class="ibox">
				<form method="POST" action="{{ route('users.update', session()->get('user_id')) }}">
					@csrf
					{{ method_field('PUT') }}
				<div class="ibox-content">
					<div class="tabs-container">
						<ul class="nav nav-tabs" role="tablist">
							<li><a class="nav-link active show" data-toggle="tab" href="#tab-1">User Details</a></li>
							<li><a class="nav-link" data-toggle="tab" href="#tab-2">Login Details</a></li>
							<li><a class="nav-link" data-toggle="tab" href="#tab-3">User Role Permissions</a></li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" id="tab-1" class="tab-pane active show">
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-3">
											<p>A general user profile information. </p>
										</div>
										<div class="col-sm-4">
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
												<label class="col-form-label" for="active">Status</label>
												<select name="active" id="active" class="form-control" {{ $user->id == 1? 'disabled' : '' }} >
													<option value="1" {{ $user->active == 1 ? 'selected' : '' }}>Enabled</option>
													<option value="0" {{ $user->active == 0 ? 'selected' : '' }}>Disabled</option>
												</select>
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
											<div class="form-group {{ $errors->first('password') ? 'has-error' : '' }}">
											  <label class="col-form-label">Confirm Password</label>
											  <input type="password" class="form-control" name="password_confirmation" placeholder="Leave field blank it you don't want to change it">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" id="tab-3" class="tab-pane">
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-3">
											<p>A general user profile information. </p>
										</div>
										<div class="col-sm-9">
											<div class="form-group">
												<div class="col-12">
													<label class="col-form-label font-bold">Roles*</label>
												</div>
												<div class="col-12 {{ $errors->first('roles') ? 'has-error' : '' }}">
													@foreach ($roles as $key => $value)
														@if ($user->hasRole($value->name))
															<label for="{{ $value->display_name }}" class="mr-2"><input type="checkbox" class="i-checks" value="{{ $value->id }}" name="roles[]" checked="checked">{{ ucfirst($value->display_name) }}</label>
														@else
															<label for="{{ $value->display_name }}" class="mr-2"><input type="checkbox" class="i-checks" value="{{ $value->id }}" name="roles[]">{{ ucfirst($value->display_name) }}</label>
														@endif
													@endforeach
												</div>
												@if ($errors->first('roles'))
													<span role="alert" class="text-danger"><strong>{{ $errors->first('roles') }}*</strong></span>
												@endif
											</div>
											<div class="form-group {{ $errors->first('permission') ? 'has-error' : '' }}">
												<div class="col-12">
													<label class="col-form-label font-bold">Direct Permissions*</label>
												</div>
												<div class="col-12">
													@foreach ($permissions as $key => $value)
													<div class="">
														@if ($user->hasPermissionTo($value->id, 'web'))
														<label for="{{ $value->display_name }}" class="mr-2">
															<input type="checkbox" class="i-checks" {{ $user->id == 1 ? 'disabled' : '' }} value="{{ $value->id }}" name="permission[]" checked {{ $user->id == 1 ? 'disabled' : '' }}>{{ ucfirst($value->display_name) }}
														</label>
														@else
														<label for="{{ $value->display_name }}" class="mr-2">
															<input type="checkbox" class="i-checks" value="{{ $value->id }}" name="permission[]">{{ ucfirst($value->display_name) }}
														</label>
														@endif
													</div>
													@endforeach
												</div>
												@if ($errors->first('permission'))
													<span role="alert" class="text-danger"><strong>{{ $errors->first('permission') }}*</strong></span>
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<button class="btn btn-lg btn-primary mt-2" type="submit">Save Changes</button>
			</form>
			</div>
	</div>
	<div class="col-lg-4">
		<div class="ibox">
			 <div class="ibox-content text-center">
				 <div class="m-b-md">
					<img alt="image" class="avatar rounded-circle img-thumbnail img-responsive mt-5 mb-4" src="{{ $user->getFirstMediaUrl('avatar') ? $user->getFirstMediaUrl('avatar', 'thumb') :  asset('uploads/user/images/profile.png') }}">
				</div>
				<form method="POST" action="{{ route('users.storeAvatar') }}" enctype="multipart/form-data">
					@csrf
					<div class="custom-file">
						<input id="logo" type="file" name="avatar" class="custom-file-input">
						<label for="logo" class="custom-file-label">Choose file...</label>
					</div>
					<input type="submit" class="btn btn-primary btn-lg btn-flat" value="Upload">
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
@endsection
@section('js-custom')
<script type="text/javascript">
    $(document).ready(function(){
    	$('.i-checks').iCheck({
    		checkboxClass: 'icheckbox_square-green',
    		radioClass: 'iradio_square-green',
    	});
    	@if(session('success'))
    	toastr.success('{{session('success')}}');
    	@endif
    	@if(session('message'))
    	toastr.error('{{session('message')}}');
    	@endif
    });
</script>
@endsection
