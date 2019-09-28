@extends('layouts.swinedefault')

@section('title')
	Boar Production Performance
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.production_performance_report')}}"><img src="{{asset('images/back.png')}}" width="4%"></a> Boar Production Performance: <strong>{{ $boar->registryid }}</strong></h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="row center">
				<div class="col s12">
	        <ul class="tabs tabs-fixed-width green lighten-1">
	          <li class="tab"><a href="#boarcard">Boar Card</a></li>
	          <li class="tab"><a href="#performance">Performance</a></li>
	        </ul>
	      </div>
	      <div id="boarcard" class="col s12" style="padding-top:10px;">
	      	<div class="row center">
				  	<div class="col s12">
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
										@foreach($services as $service)
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
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="performance" class="col s12" style="padding-top:10px;">
					<div class="row center">
						<div class="col s12">
							<p>Total number of service: <strong>{{ count($services) }}</strong> (Successful: <strong>{{ count($successful) }}</strong>, Failed: <strong>{{ count($failed) }}</strong>, Others: <strong>{{ count($others) }}</strong>) <a class="tooltipped" data-position="right" data-tooltip="Others: Bred, Pregnant, Aborted"><i class="material-icons tiny">info_outline</i></a></p>
							<table>
								<thead>
									<tr>
										<th>Parameters (Averages)</th>
										<th class="center">Values</th>
										<th class="center">Standard Deviation</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Litter-size Born Alive</td>
										@if($lsba != [])
											<td class="center">{{ round(array_sum($lsba)/count($lsba), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($lsba, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									<tr>
										<td>Number Male Born</td>
										@if($numbermales != [])
											<td class="center">{{ round(array_sum($numbermales)/count($numbermales), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($numbermales, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									<tr>
										<td>Number Female Born</td>
										@if($numberfemales != [])
											<td class="center">{{ round(array_sum($numberfemales)/count($numberfemales), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($numberfemales, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									<tr>
										<td>Number Stillborn</td>
										@if($stillborn != [])
											<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($stillborn, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									<tr>
										<td>Number Mummified</td>
										@if($mummified != [])
											<td class="center">{{ round(array_sum($mummified)/count($mummified), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($mummified, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									{{-- <tr>
										<td>Litter Birth Weight, kg</td>
										@if($litterbirthweights != [])
											<td class="center">{{ round(array_sum($litterbirthweights)/count($litterbirthweights), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($litterbirthweights, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr> --}}
									<tr>
										<td>Average Birth Weight, kg</td>
										@if($avebirthweights != [])
											<td class="center">{{ round(array_sum($avebirthweights)/count($avebirthweights), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($avebirthweights, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									{{-- <tr>
										<td>Litter Weaning Weight, kg</td>
										@if($litterweaningweights != [])
											<td class="center">{{ round(array_sum($litterweaningweights)/count($litterweaningweights), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($litterweaningweights, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr> --}}
									<tr>
										<td>Average Weaning Weight, kg</td>
										@if($aveweaningweights != [])
											<td class="center">{{ round(array_sum($aveweaningweights)/count($aveweaningweights), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($aveweaningweights, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									<tr>
										<td>Adjusted Weaning Weight at 45 Days, kg</td>
										@if($adjweaningweights != [])
											<td class="center">{{ round(array_sum($adjweaningweights)/count($adjweaningweights), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($adjweaningweights, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									<tr>
										<td>Number Weaned</td>
										@if($numberweaned != [])
											<td class="center">{{ round(array_sum($numberweaned)/count($numberweaned), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($numberweaned, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									<tr>
										<td>Age weaned, days</td>
										@if($agesweaned != [])
											<td class="center">{{ round(array_sum($agesweaned)/count($agesweaned), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($agesweaned, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr>
									{{-- <tr>
										<td>Pre-weaning Mortality, %</td>
										@if($preweaningmortality != [])
											<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }}</td>
											<td class="center">{{ round(App\Http\Controllers\FarmController::standardDeviation($preweaningmortality, false), 2) }}</td>
										@else
											<td class="center">No data available</td>
											<td class="center">No data available</td>
										@endif
									</tr> --}}
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
	  </div>
	  <div class="fixed-action-btn">
		  <a class="btn-floating btn-large green darken-4">
		    <i class="large material-icons">cloud_download</i>
		  </a>
		  <ul>
		    <li><a href="{{ URL::route('farm.pig.boar_production_perf_download_csv', [$boar->id]) }}" class="btn-floating green lighten-1 tooltipped" data-position="left" data-tooltip="Download as CSV File"><i class="material-icons">table_chart</i></a></li>
		    <li><a href="{{ URL::route('farm.pig.boar_production_perf_download_pdf', [$boar->id]) }}" class="btn-floating green darken-1 tooltipped" data-position="left" data-tooltip="Download as PDF"><i class="material-icons">file_copy</i></a></li>
		  </ul>
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
			$(document).ready(function(){
		    $('.fixed-action-btn').floatingActionButton();
		  });
	</script>
@endsection