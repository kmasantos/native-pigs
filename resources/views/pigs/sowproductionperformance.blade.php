@extends('layouts.swinedefault')

@section('title')
	Sow Production Performance
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.production_performance_report')}}"><img src="{{asset('images/back.png')}}" width="4%"></a> Sow Production Performance: <strong>{{ $sow->registryid }}</strong></h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12 m10 l6">
				<div class="card">
					<div class="card-content grey lighten-2">
						@if(count($parities) < 1)
							<h3>No data available</h3>
						@else
							@foreach($farrowing_intervals_text as $farrowing_interval_text)
								<p>{{ $farrowing_interval_text }} days</p>
							@endforeach
							<br>
						@endif
						<p><strong>Farrowing Intervals</strong></p>
					</div>
				</div>
			</div>
			<div class="col s12 m10 l6">
				<div class="card">
					<div class="card-content grey lighten-2">
						@if(count($parities) < 1)
							<h3>No data available</h3>
						@else
							<h2>{{ round($farrowing_index, 2) }}</h2>
						@endif
						<p><strong>Farrowing Index</strong></p>
					</div>
				</div>
			</div>
		</div>
		<div class="row center">
	  	<div class="col s12">
				<h5>Sow Cards</h5>
				@foreach($usage as $sow_usage)
					<div class="card-panel">
						<table class="centered">
							<thead>
								<tr>
									<th>Boar Used</th>
									<th>Parity</th>
									<th>Date Bred</th>
									<th>Status</th>
									<th>View Performance</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Boar Used") }}</td>
									@if(App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity") == 0)
										<td>&mdash;</td>
									@else
										<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity") }}</td>
									@endif
									<td>{{ Carbon\Carbon::parse($sow_usage)->format('F j, Y') }}</td>
									<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") }}</td>
									@if(App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Recycled" || App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Bred" || App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Aborted" || App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Pregnant")
										<td><i class="material-icons">visibility_off</i></td>
									@elseif(App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Farrowed")
										<td><a href="{{ URL::route('farm.pig.sow_production_performance_per_parity', [App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Group ID")]) }}"><i class="material-icons">visibility</i></a></td>
									@endif
								</tr>
							</tbody>
						</table>
					</div>
				@endforeach
			</div>
	  </div>
	</div>
@endsection