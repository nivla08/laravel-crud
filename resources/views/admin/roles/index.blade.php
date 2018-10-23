@section('page-title')Roles @endsection
@section('css')
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Roles</h2>
		{{ Breadcrumbs::render('roles') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
	<div class="ibox ">
		<div class="ibox-content">
				<a href="/admin/roles/create" class="btn btn-primary btn-md float-right" title="Add Role"><i class="fa fa-plus"></i> Role</a>
			<div class="table-responsive">
				<table class="table table-striped table-borderless" >
					<thead>
						<tr>
							<th>Name</th>
							<th>Guard</th>
							<th>CREATED AT</th>
							<th>UPDATED AT</th>
							<th># of users with this role</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					@if (count($roles) > 0)
						@foreach ($roles as $role)
							<tr>
								<td>
									<i class="fa fa-info-circle" title="{{ $role->description }}"></i>
									{{ $role->name }}
								</td>
								<td>{{ $role->guard_name }}</td>
								<td>{{ $role->created_at }}</td>
								<td>{{ $role->updated_at }}</td>
								<td>{{ $role->users_count }}</td>
								<td>
									<a href="{{ URL::to('/admin/roles/'.$role->id.'/edit') }}" class="btn btn-xs badge"><i class="fa fa-edit"></i></a>
									@if($role->id !== 1 && $role->id !== 2)
									<form method="POST" id="delete-form-role" action="{{ URL::to('/admin/roles/'.$role->id) }}" style="display:inline-block;">
										@csrf
										{{ method_field('DELETE') }}
										<span class="btn btn-xs btn-delete badge" data-name="{{ $role->name }}"><i class="fa fa-trash"></i></span>
									</form>
									@endif
								</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js-plugin')
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
@endsection
@section('js-custom')
<script>
$(document).ready(function () {
	$('.btn-delete').click(function(){
		let name = $(this).data("name");
		swal({
			title: 'Are you sure that you want to delete "'+name+'" ?',
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
				document.getElementById('delete-form-role').submit();
			}
		});
	});
	@if(session('success'))
	toastr.success('{{session('success')}}');
	@endif
	@if (session('message'))
	toastr.error('{{ session('message') }}')
	@endif
});
</script>
@endsection
