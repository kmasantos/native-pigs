@extends('layouts.swinedefault')

@section('title')
	Boar Production Performance
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.production_performance_report')}}"><img src="{{asset('images/back.png')}}" width="4%"></a> Boar Production Performance: {{ $boar->registryid }}</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<table>
				<thead>
					<tr>
						<th>Parameters (Averages per Service)</th>
						<th class="center">Value</th>
						<th class="center">Standard Deviation</th>
					</tr>
				</thead>
	  		<tbody>
    			<tr>
	  				<td>Service</td>
	  				<td class="center">{{ $properties->where("property_id", 88)->first()->value }}</td>
	  				<td class="center">N/A</td>
	  			</tr>
	  			<tr>
	  				<td>Litter-size Born Alive</td>
	  				@if($lsba == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($lsba)/count($services), 2) }}</td>
	  					<td class="center">{{ round($lsba_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Male Born</td>
	  				@if($totalmales == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalmales)/count($services), 2) }}</td>
	  					<td class="center">{{ round($totalmales_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Female Born</td>
	  				@if($totalfemales == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalfemales)/count($services), 2) }}</td>
	  					<td class="center">{{ round($totalfemales_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Stillborn</td>
	  				@if($stillborn == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($stillborn)/count($services), 2) }}</td>
	  					<td class="center">{{ round($stillborn_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Mummified</td>
	  				@if($mummified == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($mummified)/count($services), 2) }}</td>
	  					<td class="center">{{ round($mummified_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Litter Birth Weight, kg</td>
	  				@if($totallitterbirthweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totallitterbirthweights)/count($services), 2) }}</td>
	  					<td class="center">{{ round($totallitterbirthweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Average Birth Weight, kg</td>
	  				@if($avelitterbirthweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($avelitterbirthweights)/count($services), 2) }}</td>
	  					<td class="center">{{ round($avelitterbirthweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Litter Weaning Weight, kg</td>
	  				@if($totallitterweaningweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totallitterweaningweights)/count($services), 4) }}</td>
	  					<td class="center">{{ round($totallitterweaningweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Average Weaning Weight, kg</td>
	  				@if($avelitterweaningweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($avelitterweaningweights)/count($services), 2) }}</td>
	  					<td class="center">{{ round($avelitterweaningweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Adjusted Weaning Weight at 45 Days, kg</td>
	  				@if($aveadjweaningweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($aveadjweaningweights)/count($services), 2) }}</td>
	  					<td class="center">{{ round($aveadjweaningweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Weaned</td>
	  				@if($totalweaned == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalweaned)/count($services), 2) }}</td>
	  					<td class="center">{{ round($totalweaned_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Age Weaned, months</td>
	  				@if($totalagesweaned == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalagesweaned)/count($services), 2) }}</td>
	  					<td class="center">{{ round($totalagesweaned_sd, 2) }}</td>
	  				@endif
	  			</tr>
    			<tr>
	  				<td>Pre-weaning Mortality</td>
	  				@if($preweaningmortality == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($preweaningmortality)/count($services), 2) }}</td>
	  					<td class="center">{{ round($preweaningmortality_sd, 2) }}</td>
	  				@endif
	  			</tr>
    		</tbody>
	  	</table>
	  </div>
	  <div class="row center">
	  	<div class="col s12">
				<h5>Records per Service</h5>
				@foreach($services as $service)
						<div class="card-panel">
							<table class="centered">
								<thead>
									<tr>
										<th>Service</th>
										<th>Sow Used</th>
										<th>Date Bred</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{ $count++ }}</td>
										<td>{{ App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Sow Used") }}</td>
										<td>{{ Carbon\Carbon::parse($service)->format('F j, Y') }}</td>
										<td><a href="{{ URL::route('farm.pig.boar_production_performance_per_service', [App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Group ID")]) }}"><i class="material-icons">visibility</i></a></td>
									</tr>
								</tbody>
							</table>
						</div>
				@endforeach
			</div>
	  </div>
	</div>
@endsection