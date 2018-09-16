@extends('layouts.swinedefault')

@section('title')
	Sow Production Performance Per Parity
@endsection

@section('content')
	<div class="container">
		<h5><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="2.5%"></a> Sow Production Performance Per Parity - <strong>{{ $group->getMother()->registryid }}</strong></h5>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12">
				<table>
					<thead>
						<tr>
							<th>Parameters</th>
							<th class="center">Value</th>
						</tr>
					</thead>
		  		<tbody>
		  			<tr>
		  				<td>Parity</td>
		  				<td class="center">{{ $groupingproperties->where("property_id", 48)->first()->value }}</td>
		  			</tr>
		  			<tr>
		  				<td>Litter-size Born Alive</td>
	  					<td class="center">{{ $groupingproperties->where("property_id", 50)->first()->value }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Male Born</td>
		  				<td class="center">{{ $groupingproperties->where("property_id", 51)->first()->value }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Female Born</td>
		  				<td class="center">{{ $groupingproperties->where("property_id", 52)->first()->value }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Stillborn</td>
	  					<td class="center">{{ $groupingproperties->where("property_id", 45)->first()->value }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Mummified</td>
	  					<td class="center">{{ $groupingproperties->where("property_id", 46)->first()->value }}</td>
		  			</tr>
		  			<tr>
		  				<td>Litter Birth Weight, kg</td>
		  				<td class="center">{{ round($groupingproperties->where("property_id", 55)->first()->value, 2) }}</td>
		  			</tr>
		  			<tr>
		  				<td>Average Birth Weight, kg</td>
	  					<td class="center">{{ round($groupingproperties->where("property_id", 56)->first()->value, 2) }}</td>
		  			</tr>
		  			@if(!is_null($groupingproperties->where("property_id", 6)->first()))
			  			<tr>
			  				<td>Litter Weaning Weight, kg</td>
								<td class="center">{{ round($groupingproperties->where("property_id", 62)->first()->value, 2) }}</td>
			  			</tr>
			  			<tr>
			  				<td>Average Weaning Weight, kg</td>
		  					<td class="center">{{ round($groupingproperties->where("property_id", 58)->first()->value, 2) }}</td>
			  			</tr>
			  			<tr>
			  				<td>Adjusted Weaning Weight at 45 Days, kg</td>
		  					<td class="center">{{ $aveadjweaningweights }}</td>
			  			</tr>
			  			<tr>
			  				<td>Number Weaned</td>
		  					<td class="center">{{ $groupingproperties->where("property_id", 57)->first()->value }}</td>
			  			</tr>
			  			<tr>
			  				<td>Age Weaned, days</td>
		  					<td class="center">{{ $aveageweaned }}</td>
			  			</tr>
			  			<tr>
			  				<td>Pre-weaning Mortality, %</td>
			  				<td class="center">{{ round($groupingproperties->where("property_id", 59)->first()->value, 2) }}</td>
			  			</tr>
			  		@else
			  			<tr>
			  				<td>Litter Weaning Weight, kg</td>
								<td class="center">No data available</td>
			  			</tr>
			  			<tr>
			  				<td>Average Weaning Weight, kg</td>
		  					<td class="center">No data available</td>
			  			</tr>
			  			<tr>
			  				<td>Adjusted Weaning Weight at 45 Days, kg</td>
		  					<td class="center">No data available</td>
			  			</tr>
			  			<tr>
			  				<td>Number Weaned</td>
		  					<td class="center">No data available</td>
			  			</tr>
			  			<tr>
			  				<td>Age Weaned, days</td>
		  					<td class="center">No data available</td>
			  			</tr>
			  			<tr>
			  				<td>Pre-weaning Mortality, %</td>
			  				<td class="center">No data available</td>
			  			</tr>
			  		@endif
		  		</tbody>
		  	</table>
		  </div>
		</div>
	</div>
@endsection