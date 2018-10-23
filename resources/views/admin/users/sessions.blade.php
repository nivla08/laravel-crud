@section('page-title'){{ $user->email }} @endsection
@section('css')
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>{{ $user->username }}</h2>
		{{ Breadcrumbs::render('user-session', $user->id) }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
	<div class="col-md-12">
		<div class="ibox">
			<div class="ibox-content">
				<table class="table table-striped table-borderless dataTables-example">
				  <thead>
				    <tr>
					    <th>IP Address</th>
						  <th>Device</th>
						  <th>Browser</th>
						  <th>Last Activity</th>
						  <th>Action</th>
				    </tr>
				  </thead>
				  <tbody>
					  <tr>
					  @if (count($sessionData) > 0)
						  @foreach ($sessionData as $session)
						  <td>{{ $session->ip_address }}</td>
						  <td></td>
						  <td>{{ $session->user_agent }}</td>
						  <td>{{ $session->last_activity }}</td>
						  <td>
							  <a  href="#" class="remove">
								  <span class="fa fa-times"></span>
							  </a>
							  <form id="invalidate-form" action="/admin/users/{{ $user->id }}/session/{{ $session->id }}/invalidate" method="POST" style="display: none;">
								  @csrf
								  	{{ method_field('DELETE') }}
							  </form>
						  </td>
				    	</tr>
							@endforeach
						@endif
				  </tbody>
				</table>
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
		@if(session('success'))
		toastr.success('{{session('success')}}');
		@endif
		@if(session('message'))
		toastr.error('{{session('message')}}');
		@endif
		$('.remove').click(function(){
			swal({
				title: "Are you sure want to remove this item?",
				text: "You will not be able to recover this item",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Confirm",
				cancelButtonText: "Cancel",
				closeOnConfirm: true,
				closeOnCancel: true
			},
			function(isConfirm) {
				if (isConfirm) {
					document.getElementById('invalidate-form').submit();
				}
			});
		});
	});
</script>
@endsection
