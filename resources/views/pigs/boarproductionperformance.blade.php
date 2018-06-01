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
	  					<td class="center">{{ round(array_sum($lsba)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($lsba_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Male Born</td>
	  				@if($totalmales == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalmales)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($totalmales_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Female Born</td>
	  				@if($totalfemales == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalfemales)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($totalfemales_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Stillborn</td>
	  				@if($stillborn == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($stillborn)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($stillborn_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Mummified</td>
	  				@if($mummified == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($mummified)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($mummified_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Litter Birth Weight, kg</td>
	  				@if($totallitterbirthweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totallitterbirthweights)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($totallitterbirthweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Average Birth Weight, kg</td>
	  				@if($avelitterbirthweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($avelitterbirthweights)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($avelitterbirthweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Litter Weaning Weight, kg</td>
	  				@if($totallitterweaningweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totallitterweaningweights)/$properties->where("property_id", 88)->first()->value, 4) }}</td>
	  					<td class="center">{{ round($totallitterweaningweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Average Weaning Weight, kg</td>
	  				@if($avelitterweaningweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($avelitterweaningweights)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($avelitterweaningweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Adjusted Weaning Weight at 45 Days, kg</td>
	  				@if($aveadjweaningweights == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($aveadjweaningweights)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($aveadjweaningweights_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Number Weaned</td>
	  				@if($totalweaned == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalweaned)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($totalweaned_sd, 2) }}</td>
	  				@endif
	  			</tr>
	  			<tr>
	  				<td>Age Weaned, months</td>
	  				@if($totalagesweaned == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($totalagesweaned)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($totalagesweaned_sd, 2) }}</td>
	  				@endif
	  			</tr>
    			<tr>
	  				<td>Pre-weaning Mortality</td>
	  				@if($preweaningmortality == [])
	  					<td class="center">No data available</td>
	  					<td class="center">No data available</td>
	  				@else
	  					<td class="center">{{ round(array_sum($preweaningmortality)/$properties->where("property_id", 88)->first()->value, 2) }}</td>
	  					<td class="center">{{ round($preweaningmortality_sd, 2) }}</td>
	  				@endif
	  			</tr>
    		</tbody>
	  	</table>
	  </div>
	</div>
@endsection