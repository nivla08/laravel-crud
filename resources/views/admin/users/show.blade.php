@section('page-title'){{ ucfirst($user->username) }}@endsection
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>{{ $user->username }}</h2>
		{{ Breadcrumbs::render('show-user', $user->id) }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
<div class="row">
	<div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Profile Details <span class="pull-right"><a class="text-info" title="edit" href="{{ route('users.edit', $user->id) }}">Edit</a></span></h5>
            </div>
            <div class="ibox-content p-xxs border-left-right">
				<div class="row">
					<label for="id" class="col-sm-4 font-bold">
						ID
					</label>
					<div class="col-sm-8">
						{{ $user->id }}
					</div>
				</div>
				<div class="row">
					<label for="avatar" class="col-sm-4 font-bold">
						Avatar
					</label>
					<div class="col-sm-8">
						<img alt="image" class="img-responsive img-fluid" src="{{ $user->getFirstMediaUrl('avatar') ? $user->getFirstMediaUrl('avatar') :  asset('images/profile.png') }}">
					</div>
				</div>
				<div class="row">
					<label for="name" class="col-sm-4 font-bold">Name</label>
					<div class="col-sm-8">
						<p>{{ $user->fullname }}</p>
					</div>
				</div>
				<div class="row">
					<label for="name" class="col-sm-4 font-bold">Email</label>
					<div class="col-sm-8">
						<p>{{ $user->email }}</p>
					</div>
				</div>
            </div>
        </div>
	</div>
	<div class="col-lg-8">
		<div class="i-box">
			<div class="ibox-content">
				<h5>Latest Activity</h5>
				<table class="table table-striped table-borderless">
				  <thead>
				    <tr>
				      <th>Action</th>
				      <th>Date</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <td></td>
				      <td></td>
				    </tr>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
