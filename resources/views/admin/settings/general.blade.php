@section('page-title')General Settings @endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>General Settings</h2>
		{{ Breadcrumbs::render('settings-general') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="col-lg-12">
	<div class="ibox ">
		<div class="ibox-content">
			<form method="POST" action="{{ route('settings.general') }}" accept-charset="UTF-8" id="general-settings-form">
				@csrf
				<div class="form-group">
   					 <label for="name">Name</label>
   					 <input class="form-control" id="app_name" name="app_name" value="{{ config('app.name') }}" type="text">
   				 </div>
				<button type="submit" class="btn btn-primary">Update Settings</button>
			</form>
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
    });
</script>
@endsection
