@section('page-title') Create Permission @endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Create New Permission</h2>
		{{ Breadcrumbs::render('permission-create') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
    <div class="ibox">
		<form method="POST" action="{{ route('permission.store') }}">
		<div class="ibox-content">
        	<div class="row">
				<div class="col-md-3">
					<h5>Permission Details </h5>
					<p>A general permission information. </p>
				</div>
				<div class="col-md-9">
					@csrf
					<div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
						<label class="col-form-label">Name*</label>
						<input type="text" class="form-control" name="name" value="{{ @old('name') }}" placeholder="permission.name" pattern="\^([0-9a-zA-Z]\.[0-9a-zA-Z])$\" required>
						@if ($errors->first('name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('name') }}*</strong></span>
						@endif

					</div>
					<div class="form-group {{ $errors->first('display_name') ? 'has-error' : '' }}">
						<label class="col-form-label">Display Name*</label>
						<input type="text" class="form-control" name="display_name" value="{{ @old('display_name') }}" required>
						@if ($errors->first('display_name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('display_name') }}*</strong></span>
						@endif

					</div>
					<div class="form-group {{ $errors->first('description') ? 'has-error' : '' }}">
						<label class="col-form-label">Description</label>
						<input type="text" class="form-control" name="description" value="{{ @old('description') }}">
						@if ($errors->first('description'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('description') }}*</strong></span>
						@endif

					</div>
					<div class="form-group {{ $errors->first('guard_name') ? 'has-error' : '' }}">
						<label class="col-form-label">Guard name*</label>
						<input type="text" class="form-control" name="guard_name" value="{{ @old('guard_name') }}" required>
						@if ($errors->first('guard_name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('guard_name') }}*</strong></span>
						@endif
					</div>
				</div>
                <button class="btn btn-md btn-primary float-left" type="submit">Create</button>
			</div>
        </div>
    	</form>
	</div>
</div>
@endsection
