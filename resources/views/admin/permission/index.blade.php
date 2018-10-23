@section('page-title')Permissions @endsection
@section('css')
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Permissions</h2>
		{{ Breadcrumbs::render('permission') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
	<div class="ibox ">
		<div class="ibox-content">
			<a href="/admin/permission/create" class="btn btn-primary btn-md float-right" title="Add Permission"><i class="fa fa-plus"></i> Permissions</a>
			<div class="table-responsive">
				<form id="role_permission" method="POST" action="{{ route('sync_Roles') }}">
					@csrf
				<table class="table table-striped table-borderless">
					<thead>
						<tr>
							<th>Display Name</th>
							@foreach ($roles as $role)
							<th>{{ $role->display_name }}</th>
							@endforeach
							<th></th>
						</tr>
					</thead>
					<tbody>
						@if (count($permissions) > 0)
						@foreach ($permissions as $permission)
						<tr>
							<td>
								<i class="fa fa-info-circle" title="{{ $permission->description }}"></i>
								{{ $permission->display_name }}
							</td>
							@foreach ($roles as $role)
							<td>
							@if($role->hasPermissionTo($permission->name))
								@if ($role->id == 1)
									<input type="checkbox" class="i-checks disabled" disabled name="roles[{{ $role->id }}][]" value="{{ $permission->name }}" checked="checked" />
								@else
									<input type="checkbox" class="i-checks" name="roles[{{ $role->id }}][]" value="{{ $permission->name }}" checked="checked" />
								@endif
							@else
								<input type="checkbox" class="i-checks" name="roles[{{ $role->id }}][]" value="{{ $permission->name }}" />
							@endif
							</td>
							@endforeach
							<td>
								<a class="btn btn-edit btn-sm badge" href="{{ URL::to('admin/permission/'.$permission->id.'/edit') }}"><i class="fa fa-edit"></i></a>
								@if (!($permission->id <= 6))
									<span class="delete-permission btn btn-edit btn-sm badge" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}"><i class="fa fa-trash"></i></span>
								@endif
							</td>
						</tr>
						@endforeach

						@endif
					</tbody>
				</table>
				</form>
				<form method="POST" action="" id="form-delete-permission" stlye="display:hidden;">
					@csrf
					{{ method_field('DELETE') }}
				</form>
				<button class="btn btn-primary btn-lg" type="submit" form="role_permission" >Save Permission</button>
			</div>
		</div>
		{{ $permissions->links() }}
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
    	$('.delete-permission').click(function(){
    		let id = $(this).data("id");
    		let name =  $(this).data("name");
    	  swal({
    		  title: 'Are you sure that you want to delete this "'+name+'" permission?',
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
    			  let form =  $('#form-delete-permission');
    			  let url = "{{ route('permission.index') }}";
    			  let action = form.attr("action", url+"/"+id);
    			  form.submit();
    		  }
    	  });
    	});
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
