@section('page-title', 'Edit Roles Permission')
@section('css')
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>{{ $role->name }}</h2>
		{{ Breadcrumbs::render('role-edit', $role->id) }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-content">
			<form method="POST" action="{{ route('roles.update', $role->id) }}">
            <div class="row">
            	<div class="col-md-3">
					<h5>Role Details</h5>
					<p>A general role information.</p>
            	</div>
				<div class="col-md-9">
					@csrf
					{{ method_field('PUT') }}
	                <div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
						<label class="col-form-label">Name*</label>
						<input type="text" class="form-control {{ $role->id <= 2 ? 'readonly' : '' }}" name="name" value="{{ $role->name }}" {{ $role->id <= 2 ? 'readonly' : '' }} required>
						@if ($errors->first('name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('name') }}*</strong></span>
						@endif
	                </div>
					<div class="form-group {{ $errors->first('guard_name') ? 'has-error' : '' }}">
						<label class="col-form-label">Guard Name*</label>
						<input type="text" class="form-control" name="guard_name" value="{{ $role->guard_name }}" required>
						@if ($errors->first('guard_name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('guard_name') }}*</strong></span>
						@endif
					</div>
					<div class="form-group {{ $errors->first('display_name') ? 'has-error' : '' }}">
						<label class="col-form-label">Display Name*</label>
						<input type="text" class="form-control" name="display_name" value="{{ $role->display_name }}" required>
						@if ($errors->first('display_name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('display_name') }}*</strong></span>
						@endif
	                </div>
	                <div class="form-group  {{ $errors->first('description') ? 'has-error' : '' }}">
						<label class="col-form-label">Description*</label>
						<input type="text" class="form-control" name="description" value="{{ $role->description }}" required>
						@if ($errors->first('description'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('description') }}*</strong></span>
						@endif
	                </div>
					<div class="form-group  {{ $errors->first('permission') ? 'has-error' : '' }}">
						<label class="col-form-label">Permission</label>
						@foreach ($permissions as $key => $value)
							@if($role->hasPermissionTo($value))
								<div class="i-checks">
									<label>
										<input type="checkbox" class="{{ $role->id == 1 ? 'disabled' : '' }}" name="permission[]" value="{{ $key }}" checked="checked" {{ $role->id == 1 ? 'disabled' : '' }}>
										{{ $value }}
									</label>
								</div>
							@else
								<div class="i-checks">
									<label>
										<input type="checkbox" name="permission[]" value="{{ $key }}">
										{{ $value }}
									</label>
								</div>
							@endif
						@endforeach
						@if ($errors->first('permission'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('permission') }}*</strong></span>
						@endif
					</div>

				</div>
            </div>
			<div class="form-group">
				<button class="btn btn-lg btn-primary float-left" type="submit">Save Changes</button>
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
