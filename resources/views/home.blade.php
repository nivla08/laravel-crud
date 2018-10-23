@section('page-title', 'Home')
@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-sm-4">
		<h2>Dashboard</h2>
		{{ Breadcrumbs::render('home') }}
	</div>
</div>
@endsection
@extends('layouts.master')
@section('wrapper-content')
@if (Auth::user()->hasRole('administrator'))
<div class="row">
	<div class="col-xl-3 col-md-6">
	  <div class="card widget no-padding">
	      <div class="card-body">
	          <div class="row">
	              <div class="col-2 text-info">
	                  <i class="fa fa-users fa-3x"></i>
	              </div>
	              <div class="col-10 pr-0">
					<div class="text-right">
						<h2>{{ $total_users }}</h2>
						<div class="text-muted">Total Users</div>
					</div>
	              </div>
	          </div>
	        </div>
	    </div>
	</div>


	<div class="col-xl-3 col-md-6">
	  <div class="card widget no-padding">
	      <div class="card-body">
	          <div class="row">
	              <div class="col-2 text-success">
	                  <i class="fa fa-user-plus fa-3x"></i>
	              </div>
	              <div class="col-10 pr-0">
					<div class="text-right">
						<h2>{{ $newUserCount }}</h2>
						<div class="text-muted">New Users this month</div>
					</div>
	              </div>
	          </div>
	        </div>
	    </div>
	</div>


	<div class="col-xl-3 col-md-6">
	  <div class="card widget no-padding">
	      <div class="card-body">
	          <div class="row">
	              <div class="col-2 text-danger">
	                  <i class="fa fa-user-times fa-3x"></i>
	              </div>
	              <div class="col-10 pr-0">
					<div class="text-right">
						<h2>{{ $bannedUser }}</h2>
						<div class="text-muted">Banned Users</div>
					</div>
	              </div>
	          </div>
	        </div>
	    </div>
	</div>


	<div class="col-xl-3 col-md-6">
	  <div class="card widget no-padding">
	      <div class="card-body">
	          <div class="row">
	              <div class="col-2 text-warning">
	                  <i class="fa fa-user fa-3x"></i>
	              </div>
	              <div class="col-10 pr-0">
					<div class="text-right">
						<h2>{{ $unconfirmmedUser }}</h2>
						<div class="text-muted">Unconfirmed Users</div>
					</div>
	              </div>
	          </div>
	        </div>
	    </div>
	</div>

</div>

<div class="row">
    <div class="col-lg-8 col-md-12 mb-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Registration History</h5>
    				<div>
    					<canvas height="200" id="lineChart"></canvas>
    			   </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Latest Registrations
                	<small class="float-right">
                    <a href="{{ route('users.index') }}" title="view all user">View All</a>
                  </small>
                </h5>

                <ul class="list-group list-group-flush">
					@foreach ($newRegisteredUsers as $user)
						<li class="list-group-item list-group-item-action">
							<a href="{{ route('users.show', $user->id) }}" class="d-flex text-dark no-decoration">
								<img class="rounded-circle" src="{{ $user->getFirstMediaUrl('avatar', 'small') ? $user->getFirstMediaUrl('avatar', 'small') : asset('images/profile.png') }}" width="40" height="40">
								<div class="ml-2" style="line-height: 1.2;">
									<span class="d-block p-0">{{ $user->email }}</span>
									<small class="text-muted">1{{ $user->created_at->diffForHumans()  }}</small>
								</div>
							</a>
						</li>
					@endforeach
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
@endif

@section('js-plugin')
<!-- ChartJS-->
<script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
@endsection
@section('js-custom')
<script>
	$(document).ready(function () {
		let lineData = {
			labels: {!! json_encode($date) !!},
			datasets: [

				{
					label: "Data 1",
					backgroundColor: 'rgba(26,179,148,0.5)',
					borderColor: "rgba(26,179,148,0.7)",
					pointBackgroundColor: "rgba(26,179,148,1)",
					pointBorderColor: "#fff",
					data: {!! json_encode($data) !!}
				}
			]
		};

		let lineOptions = {
			responsive: true,
			elements: {
                line: {
                    tension: 0, // disables bezier curves
                }
            }
		};
		let ctx = document.getElementById("lineChart").getContext("2d");
				new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
		});
</script>
@endsection
