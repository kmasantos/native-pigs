@extends('layouts.swinedefault')

@section('title')
	Boar Production Performance
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.production_performance_report')}}"><img src="{{asset('images/back.png')}}" width="4%"></a> Boar Production Performance: <strong>{{ $boar->registryid }}</strong></h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
	  	<div class="col s12">
				<h5>Boar Cards</h5>
				@foreach($services as $service)
					<div class="card-panel">
						<table class="centered">
							<thead>
								<tr>
									<th>Service</th>
									<th>Sow Used</th>
									<th>Date Bred</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ $count++ }}</td>
									<td>{{ App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Sow Used") }}</td>
									<td>{{ Carbon\Carbon::parse($service)->format('F j, Y') }}</td>
									@if(App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Status") == "Farrowed")
										<td>Successful</td>
									@elseif(App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Status") == "Recycled")
										<td>Failed</td>
									@else
										<td>{{ App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Status") }}</td>
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