@extends('layouts.swinedefault')

@section('title')
	Sow Production Performance
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.production_performance_report')}}"><img src="{{asset('images/back.png')}}" width="4%"></a> Sow Production Performance: {{ $sow->registryid }}</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<table>
				<thead>
					<tr>
						<th>Property (Averages)</th>
						<th class="center">Value</th>
					</tr>
				</thead>
	  		<tbody>
	  			<tr>
	  				<td>Farrowing Index</td>
	  				<td class="center"></td>
	  			</tr>
	  			<tr>
	  				<td>Latest Parity</td>
	  				<td class="center">{{ $properties->where("property_id", 76)->first()->value }}</td>
	  			</tr>
	  			<tr>
	  				<td>Litter-size Born Alive</td>
	  				@if($lsba == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ ceil(array_sum($lsba)/count($lsba)) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Male Born</td>
	  				@if($totalmales == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ ceil(array_sum($totalmales)/count($totalmales)) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Female Born</td>
	  				@if($totalfemales == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ ceil(array_sum($totalfemales)/count($totalfemales)) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Stillborn</td>
	  				@if($stillborn == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Mummified</td>
	  				@if($mummified == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($mummified)/count($stillborn), 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Litter Birth Weight, kg</td>
	  				@if($totallitterbirthweights == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totallitterbirthweights)/count($totallitterbirthweights), 4) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Average Birth Weight, kg</td>
	  				@if($avelitterbirthweights == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($avelitterbirthweights)/count($avelitterbirthweights), 4) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Litter Weaning Weight, kg</td>
	  				@if($totallitterweaningweights == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totallitterweaningweights)/count($totallitterweaningweights), 4) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Average Weaning Weight, kg</td>
	  				@if($avelitterweaningweights == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($avelitterweaningweights)/count($avelitterweaningweights), 4) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Adjusted Weaning Weight at 45 Days, kg</td>
	  				@if($aveadjweaningweights == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($aveadjweaningweights)/count($aveadjweaningweights), 4) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Weaned</td>
	  				@if($totalweaned == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalweaned)/count($totalweaned), 4) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Age Weaned, months</td>
	  				@if($totalagesweaned == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalagesweaned)/count($totalagesweaned), 4) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Weaned Per Year</td>
	  				<td class="center"></td>
	  			</tr>
	  			<tr>
	  				<td>Pre-weaning Mortality</td>
	  				@if($preweaningmortality == [])
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 4) }}</td>
	  				@endif
	  			</tr>
	  		</tbody>
	  	</table>
	  </div>
	</div>
@endsection