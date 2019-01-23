@extends('layouts.swinedefault')

@section('title')
	Sow Production Performance
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.production_performance_report')}}"><img src="{{asset('images/back.png')}}" width="4%"></a> Sow Production Performance: <strong>{{ $sow->registryid }}</strong></h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			@if(!is_null($properties->where("property_id", 3)->first()) && $properties->where("property_id", 3)->first()->value != "Not specified")
				<p>Age First Bred: <strong>{{ $age_firstbred }} months</strong>, Age First Parity: <strong>{{ $age_firstparity }} months</strong> (Date of Birth: <strong>{{ Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->format('F j, Y') }}</strong>)</p>
			@else
				<p>No Date of Birth to compute for Age First Bred and Age First Parity</p>
			@endif
			<div class="col s12 m12 l6">
				<div class="card">
					<div class="card-content grey lighten-2">
						@if(count($parities) <= 1)
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
			<div class="col s12 m12 l6">
				<div class="card">
					<div class="card-content grey lighten-2">
						@if(count($parities) <= 1)
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
        <ul class="tabs tabs-fixed-width green lighten-1">
          <li class="tab"><a href="#sowcard">Sow Card</a></li>
          <li class="tab"><a href="#summary">Summary</a></li>
        </ul>
      </div>
      <div id="sowcard" class="col s12" style="padding-top:10px;">
      	<div class="row center">
			  	<div class="col s12">
						<div class="card-panel">
							<table class="centered">
								<thead>
									<tr>
										<th>Parity</th>
										<th>Boar Used</th>
										<th>Date Bred</th>
										<th>Status</th>
										<th>View Performance</th>
									</tr>
								</thead>
								<tbody>
									@foreach($usage as $sow_usage)
										<tr>
											@if(App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity") == 0)
												<td>&mdash;</td>
											@else
												<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity") }}</td>
											@endif
											<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Boar Used") }}</td>
											<td>{{ Carbon\Carbon::parse($sow_usage)->format('F j, Y') }}</td>
											<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") }}</td>
											@if(App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Recycled" || App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Bred" || App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Aborted" || App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Pregnant")
												<td><i class="material-icons">visibility_off</i></td>
											@elseif(App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") == "Farrowed")
												<td><a href="{{ URL::route('farm.pig.sow_production_performance_per_parity', [App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Group ID")]) }}"><i class="material-icons">visibility</i></a></td>
											@endif
										@endforeach
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div id="summary" class="col s12" style="padding-top:10px;">
      	<div class="row center">
      		<table style="overflow-x: scroll;">
      			<thead>
      				<tr>
      					<th>Parameters</th>
      					<th colspan="{{ count($parities) }}" class="center">Values</th>
      					<th class="center">Average &plusmn; SD</th>
      				</tr>
      			</thead>
      			<tbody>
      				<tr>
      					<td>Parity</td>
      					@foreach($parities as $parity)
      						<td class="center"><strong>{{ $parity }}</strong></td>
      					@endforeach
      					<td class="center">&mdash;</td>
      				</tr>
      				<tr>
			  				<td>Litter-size Born Alive</td>
			  				@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "lsba") }}</td>
		  					@endforeach
		  					@if($lsba != [])
									<td class="center">{{ round(array_sum($lsba)/count($lsba), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($lsba, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Number Male Born</td>
			  				@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number males") }}</td>
		  					@endforeach
		  					@if($numbermales != [])
									<td class="center">{{ round(array_sum($numbermales)/count($numbermales), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($numbermales, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Number Female Born</td>
			  				@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number females") }}</td>
		  					@endforeach
		  					@if($numberfemales != [])
									<td class="center">{{ round(array_sum($numberfemales)/count($numberfemales), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($numberfemales, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Number Stillborn</td>
		  					@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "stillborn") }}</td>
		  					@endforeach
		  					@if($stillborn != [])
									<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($stillborn, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Number Mummified</td>
		  					@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "mummified") }}</td>
		  					@endforeach
		  					@if($mummified != [])
									<td class="center">{{ round(array_sum($mummified)/count($mummified), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($mummified, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Litter Birth Weight, kg</td>
			  				@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "litter birth weight") }}</td>
		  					@endforeach
		  					@if($litterbirthweights != [])
									<td class="center">{{ round(array_sum($litterbirthweights)/count($litterbirthweights), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($litterbirthweights, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Average Birth Weight, kg</td>
		  					@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "ave birth weight") }}</td>
		  					@endforeach
		  					@if($avebirthweights != [])
									<td class="center">{{ round(array_sum($avebirthweights)/count($avebirthweights), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($avebirthweights, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Litter Weaning Weight, kg</td>
								@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "litter weaning weight") }}</td>
		  					@endforeach
		  					@if($litterweaningweights != [])
									<td class="center">{{ round(array_sum($litterweaningweights)/count($litterweaningweights), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($litterweaningweights, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Average Weaning Weight, kg</td>
		  					@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "ave weaning weight") }}</td>
		  					@endforeach
		  					@if($aveweaningweights != [])
									<td class="center">{{ round(array_sum($aveweaningweights)/count($aveweaningweights), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($aveweaningweights, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Adjusted Weaning Weight at 45 Days, kg</td>
		  					@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "adj weaning weight") }}</td>
		  					@endforeach
		  					@if($adjweaningweights != [])
									<td class="center">{{ round(array_sum($adjweaningweights)/count($adjweaningweights), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($adjweaningweights, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Number Weaned</td>
		  					@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number weaned") }}</td>
		  					@endforeach
		  					@if($numberweaned != [])
									<td class="center">{{ round(array_sum($numberweaned)/count($numberweaned), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($numberweaned, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Age Weaned, days</td>
		  					@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "age weaned") }}</td>
		  					@endforeach
		  					@if($agesweaned != [])
									<td class="center">{{ round(array_sum($agesweaned)/count($agesweaned), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($agesweaned, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
			  			<tr>
			  				<td>Pre-weaning Mortality, %</td>
			  				@foreach($parities as $parity)
		  						<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "preweaning mortality") }}</td>
		  					@endforeach
		  					@if($preweaningmortality != [])
									<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($preweaningmortality, false), 2) }}</td>
								@else
									<td class="center">No data available</td>
								@endif
			  			</tr>
      			</tbody>
      		</table>
      	</div>
      </div>
	  </div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
			$('.datepicker').pickadate({
			  selectMonths: true, // Creates a dropdown to control month
			  selectYears: 15, // Creates a dropdown of 15 years to control year,
			  today: 'Today',
			  clear: 'Clear',
			  close: 'Ok',
			  closeOnSelect: false, // Close upon selecting a date,
			  format: 'yyyy-mm-dd', 
			  max: new Date()
			});
	</script>
@endsection