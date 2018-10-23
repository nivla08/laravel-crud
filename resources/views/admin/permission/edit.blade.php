@section('page-title') Edit Permission @endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>{{ $permission->name }}</h2>
		{{ Breadcrumbs::render('permission-edit', $permission->id) }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
    <div class="ibox">
		<form method="POST" action="{{ route('permission.update', $permission->id) }}">
		<div class="ibox-content">
        	<div class="row">
				<div class="col-md-3">
					<h5>Permission Details </h5>
					<p>A general permission information. </p>
				</div>
				<div class="col-md-9">
					@csrf
					{{ method_field('PUT') }}
					<div class="form-group {{ $errors->first('name') ? 'has-error' : '' }}">
						<label class="col-form-label">Name*</label>
						<input type="text" class="form-control {{ $permission->id <=5 ? 'readonly' : ''}}" name="name" value="{{ $permission->name }}" pattern="\^([0-9a-zA-Z]\.[0-9a-zA-Z])$\" {{ $permission->id <=6 ? 'readonly' : ''}} required>
						@if ($errors->first('name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('name') }}*</strong></span>
						@endif

					</div>
					<div class="form-group {{ $errors->first('display_name') ? 'has-error' : '' }}">
						<label class="col-form-label">Display Name*</label>
						<input type="text" class="form-control" name="display_name" value="{{ $permission->display_name }}" required>
						@if ($errors->first('display_name'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('display_name') }}*</strong></span>
						@endif

					</div>
					<div class="form-group {{ $errors->first('description') ? 'has-error' : '' }}">
						<label class="col-form-label">Description</label>
						<input type="text" class="form-control" name="description" value="{{ $permission->description }}">
						@if ($errors->first('description'))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('description') }}*</strong></span>
						@endif

					</div>
					<div class="form-group {{ $errors->first('guard_name') ? 'has-error' : '' }}">
						<label class="col-form-label">Guard name*</label>
						<input type="text" class="form-control" name="guard_name" value="{{ $permission->guard_name }}" required>
						@if ($errors->first('guard_name') || (session('guards')))
							<span role="alert" class="text-danger small"><strong>{{ $errors->first('guard_name') }}*</strong></span>
						@endif
					</div>
				</div>
			</div>
        </div>
		<button class="btn btn-md btn-primary float-left" type="submit">Save Changes</button>
	</form>
	<form id="delete-form-permission" action="{{ route('permission.destroy', $permission->id)}}" method="POST" style="display:inline-block;">
		<span class="btn btn-delete btn-md btn-danger">Delele</span>
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
	</form>
	</div>
</div>
@endsection
@section('js-plugin')
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
@endsection
@section('js-custom')
<script>
$(document).ready(function () {
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
	$('.btn-delete').click(function(){
	  swal({
		  title: "Are you sure that you want to delete this permission?",
		  text: "This action cannot be undone.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Confirm",
		  cancelButtonText: "Cancel",
		  closeOnConfirm: true,
		  closeOnCancel: true
		},
		function(isConfirm) {
		  if (isConfirm) {
			 document.getElementById('delete-form-permission').submit();
		  }
	  });
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
