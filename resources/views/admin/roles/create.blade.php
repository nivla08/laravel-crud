@section('page-title', 'Create Roles Permission')
@section('css')
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Create New Role</h2>
		{{ Breadcrumbs::render('role-create') }}
	</div>
</div>
@endsection
@section('role_action', route('roles.store'))
@extends('layouts.master')
@section('permission_checkboxes')
	@foreach ($permissions as $key => $value)
		<div class="i-checks">
		<label>
			<input type="checkbox" name="permission[]" value="{{ $key }}">
			{{ $value }}
		</label>
		</div>
	@endforeach
@endsection
@section('wrapper-content')
	<div class="col-lg-12">
	    <div class="ibox">
	        <div class="ibox-content">
				<form method="POST" action="@yield('role_action')">
	            <div class="row">
	            	<div class="col-md-3">
						<h5>Role Details</h5>
						<p>A general role information.</p>
	            	</div>
					<div class="col-md-9">
							@csrf
							@yield('role_method')
			                <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
								<label class="col-form-label">Name*</label>
								<input type="text" class="form-control" name="name" value="@yield('role_name')" required>
								@if ($errors->first('name'))
									<span role="alert" class="text-danger small"><strong>{{ $errors->first('name') }}*</strong></span>
								@endif
			                </div>
			                <div class="form-group {{ $errors->first('guard_name') ? 'has-error' : '' }}">
								<label class="col-form-label">Guard Name*</label>
								<input type="text" class="form-control" name="guard_name" value="@yield('guard_name')" required>
								@if ($errors->first('guard_name'))
									<span role="alert" class="text-danger small"><strong>{{ $errors->first('guard_name') }}*</strong></span>
								@endif
			                </div>
							<div class="form-group {{ $errors->first('display_name') ? 'has-error' : '' }}">
								<label class="col-form-label">Display Name*</label>
								<input type="text" class="form-control" name="display_name" value="@yield('display_name')" required>
								@if ($errors->first('display_name'))
									<span role="alert" class="text-danger small"><strong>{{ $errors->first('display_name') }}*</strong></span>
								@endif
			                </div>
			                <div class="form-group  {{ $errors->first('description') ? 'has-error' : '' }}">
								<label class="col-form-label">Description*</label>
								<input type="text" class="form-control" name="description" value="@yield('description')" required>
								@if ($errors->first('description'))
									<span role="alert" class="text-danger small"><strong>{{ $errors->first('description') }}*</strong></span>
								@endif
			                </div>
							<div class="form-group  {{ $errors->first('permission') ? 'has-error' : '' }}">
								<label class="col-form-label">Permission</label>
									@yield('permission_checkboxes')
								@if ($errors->first('permission'))
									<span role="alert" class="text-danger small"><strong>{{ $errors->first('permission') }}*</strong></span>
								@endif
							</div>

					</div>
	            </div>
				<div class="form-group">
					<button class="btn btn-lg btn-primary float-left" type="submit">@yield('submit_value', 'Create')</button>
				</div>
			</form>
	        </div>
	    </div>
	</div>
@endsection
@section('js-plugin')
<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
@endsection
@section('js-custom')
	<script>
	$(document).ready(function () {
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
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
