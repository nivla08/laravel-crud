@section('page-title')Users @endsection
@section('css')
	<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Users</h2>
		{{ Breadcrumbs::render('users') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
	<div class="ibox ">
		<div class="ibox-content">
			<form method="get" action="{{ route('users.index') }}" class="float-left user-search">
				<div class="input-group">
					<input class="form-control form-control-md" name="search" placeholder="Search user" type="text" value="{{ isset($search) ? $search : '' }}">
					<div class="input-group-btn">
						<button type="submit" class="btn btn-md btn-primary">Search</button>
					</div>
				</div>
			</form>
			<a href="/admin/users/create" class="btn btn-primary btn-md float-right" title="Add Users"><i class="fa fa-plus"></i> User</a>
			<div class="table-responsive">
				<table class="table table-striped table-borderless dataTables-example" >
					<thead>
						<tr>
							<th></th>
							<th>Email</th>
							<th>Roles</th>
							<th>Direct Permissions </th>
							<th>Verified</th>
							<th>isOnline</th>
							<th>Registration Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
					@if (count($users) > 0)
						@foreach ($users as $user)
							<tr>
								<td>
									<img alt="{{ $user->fullname }}" class="avatar rounded-circle img-thumbnail img-responsive" height="60" width="60" src="{{ $user->getFirstMediaUrl('avatar') ? $user->getFirstMediaUrl('avatar', 'small') :  asset('images/profile.png') }}">
								</td>
								<td><a href="{{ route('users.show', $user->id) }}">{{ $user->email }}</a></td>
								<td>
									@if (count($user->roles) > 0)
										@foreach ($user->roles()->pluck('name') as $role)
											<label class="label label-info label-many">{{ $role }}</label>
										@endforeach
									@else
										<label class="label label-default">none</label>
									@endif
								</td>
								<td>
									@if (count($user->getDirectPermissions()) > 0)
										@foreach ($user->getDirectPermissions() as $key => $value)
										{{ $value->display_name }}<br />
										@endforeach
									@else
										<label class="label label-danger">none</label>
									@endif
								</td>
								<td>
									@if ($user->email_verified_at != null)
										{{ $user->email_verified_at }}
									@else
										<label class="badge badge-danger">Unconfirmed</label>
									@endif
								</td>
								<td>
									@if ($user->isOnline())
										<label class="badge badge-primary">Online</label>
									@else
										<label class="badge badge-danger">Offline</label>
									@endif
								</td>
								<td>{{ $user->created_at }}</td>
								<td>
									<div class="dropdown show d-inline-block">
							            <a class="btn btn-icon" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							                <i class="fa fa-ellipsis-h"></i>
							            </a>
							            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
		                                    <a href="/admin/users/{{ $user->id }}/session" class="dropdown-item text-gray-500">
					                        <i class="fa fa-list mr-2"></i>User Sessions</a>
			                                <a href="/admin/users/{{ $user->id }}" class="dropdown-item text-gray-500">
												<i class="fa fa-eye mr-2"></i>View User</a>
											<a class="dropdown-item text-gray-500" href="{{ URL::to('/admin/users/'.$user->id.'/edit') }}" class="btn btn-xs badge" title="Edit User">
												<i class="fa fa-edit mr-2"></i>Edit</a>
											@if($user->id !== 1)
												<div class="dropdown-item no-padding ml-3">
													<form method="POST" id="delete-form-user" action="{{ URL::to('/admin/users/'.$user->id) }}" style="display:inline-block;">
														@csrf
														{{ method_field('DELETE') }}
														<span class="btn btn-xs btn-delete" title="delete user " data-username="{{ $user->username }}" ><i class="fa fa-trash mr-2"></i> Delete</span>
													</form>
												</div>
											@endif
							            </div>
							        </div>
								</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
				{{ $users->appends(['search' => $search ])->links() }}
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
			let username = $(this).data("username");
			swal({
				title: 'Are you sure that you want to delete "'+username+'" ?',
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
					document.getElementById('delete-form-user').submit();
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
