@extends('layouts.swinedefault')

@section('title')
	Production Performance Report
@endsection

@section('content')
	<div class="container">
		<h4>Production Performance Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12">
	      <ul class="tabs tabs-fixed-width green lighten-1">
	        <li class="tab"><a href="#persowview">Per sow</a></li>
	        <li class="tab"><a href="#perboarview">Per boar</a></li>
	        <li class="tab"><a id="per_parity" href="#perparityview">Per parity</a></li>
	        <li class="tab"><a href="#permonthview">Per month</a></li>
	        <li class="tab"><a href="#perbreedview">Per breed</a></li>
	      </ul>
	    </div>
	    <!-- PER SOW -->
	    <div id="persowview" class="col s12">	    	
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Registration ID</th>
	    				<th class="center">View Production Performance</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			@forelse($sowbreeders as $sowbreeder)
		    			<tr>
		    				<td>{{ $sowbreeder->registryid }}</td>
		    				<td class="center"><a href="{{ URL::route('farm.pig.sow_production_performance', [$sowbreeder->id]) }}"><i class="material-icons">visibility</i></a></td>
		    			</tr>
		    		@empty
	    				<tr>
	    					<td colspan="2" class="center">No sow data available</td>
	    				</tr>
    				@endforelse
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER BOAR -->
	    <div id="perboarview" class="col s12">
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Registration ID</th>
	    				<th class="center">View Production Performance</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			@forelse($boarbreeders as $boarbreeder)
		    			<tr>
		    				<td>{{ $boarbreeder->registryid }}</td>
		    				<td class="center"><a href="{{ URL::route('farm.pig.boar_production_performance', [$boarbreeder->id]) }}"><i class="material-icons">visibility</i></a></td>
		    			</tr>
		    		@empty
	    				<tr>
	    					<td colspan="2" class="center">No boar data available</td>
	    				</tr>
    				@endforelse
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER PARITY -->
	    <div id="perparityview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Generate Reports by:</p>
		  		</div>
	    		<div class="col s5">
	    			{{-- {!! Form::open(['route' => 'farm.pig.prod_performance_parity', 'method' => 'post', 'id' => 'report_filter']) !!} --}}
						<select id="filter_parity" name="filter_parity" class="browser-default" {{-- onchange="document.getElementById('report_filter').submit();" --}}>
							<option disabled selected>Parity {{ $filter }}</option>
							@foreach($parity as $parity)
								<option value="{{ $parity }}">Parity {{ $parity }}</option>
							@endforeach
						</select>
						{{-- {!! Form::close() !!} --}}
					</div>
	    	</div>
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Property (Averages)</th>
	    				<th class="center">Value</th>
	    				<th class="center">Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				@if($lsba == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($lsba)/count($lsba), 2) }}</td>
								<td class="center">{{ round($lsba_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				@if($totalmales == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalmales)/count($totalmales), 2) }}</td>
								<td class="center">{{ round($totalmales_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				@if($totalfemales == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalfemales)/count($totalfemales), 2) }}</td>
								<td class="center">{{ round($totalfemales_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				@if($stillborn == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
								<td class="center">{{ round($stillborn_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				@if($mummified == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($mummified)/count($mummified), 2) }}</td>
								<td class="center">{{ round($mummified_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight, kg</td>
	    				@if($totallitterbirthweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totallitterbirthweights)/count($totallitterbirthweights), 2) }}</td>
								<td class="center">{{ round($totallitterbirthweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight, kg</td>
	    				@if($avelitterbirthweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($avelitterbirthweights)/count($avelitterbirthweights), 2) }}</td>
								<td class="center">{{ round($avelitterbirthweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight, kg</td>
	    				@if($totallitterweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totallitterweaningweights)/count($totallitterweaningweights), 2) }}</td>
								<td class="center">{{ round($totallitterweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight, kg</td>
	    				@if($avelitterweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($avelitterweaningweights)/count($avelitterweaningweights), 2) }}</td>
								<td class="center">{{ round($avelitterweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days, kg</td>
	    				@if($aveadjweaningweights == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($aveadjweaningweights)/count($aveadjweaningweights), 2) }}</td>
								<td class="center">{{ round($aveadjweaningweights_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				@if($totalweaned == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalweaned)/count($totalweaned), 2) }}</td>
								<td class="center">{{ round($totalweaned_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Age Weaned, months</td>
	    				@if($totalagesweaned == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($totalagesweaned)/count($totalagesweaned), 2) }}</td>
								<td class="center">{{ round($totalagesweaned_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				@if($preweaningmortality == [])
		    				<td class="center">No data available</td>
		    				<td class="center">No data available</td>
		    			@else
		    				<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }}</td>
								<td class="center">{{ round($preweaningmortality_sd, 2) }}</td>
							@endif
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER MONTH -->
	    <div id="permonthview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Generate Reports within:</p>
		  		</div>
		  		{{-- {!! Form::open(['route' => 'farm.pig.filter_production_performance_per_month', 'method' => 'post', 'id' => 'report_filter2']) !!} --}}
	    		<div class="col s2">
						<input id="start_date" type="text" class="datepicker" name="start_date" placeholder="Start date">
					</div>
					<div class="col s2">
						<input id="end_date" type="text" class="datepicker" name="end_date" placeholder="End date">
					</div>
	    		{{-- {!! Form::close() !!} --}}
	    	</div>
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER BREED -->
	    <div id="perbreedview" class="col s12">
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function(){
		  $("#filter_parity").change(function () {
				event.preventDefault();
				var filter = $(this).val();
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: '../farm/production_performance_per_parity/'+filter,
					type: 'POST',
					cache: false,
					data: {filter},
					success: function(data)
					{
						Materialize.toast('Showing data with parity '+filter, 4000);
					}
				});
		  });
		});
	</script>
@endsection