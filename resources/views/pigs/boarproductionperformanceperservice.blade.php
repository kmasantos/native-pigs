@extends('layouts.swinedefault')

@section('title')
	Boar Production Performance Per Service
@endsection

@section('content')
	<div class="container">
		<h5><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="2.5%"></a> Boar Production Performance Per Service - {{ $group->getFather()->registryid }}</h5>
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
		  				<td>Litter-size Born Alive</td>
	  					<td class="center">{{ $lsba }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Male Born</td>
		  				<td class="center">{{ count($males) }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Female Born</td>
		  				<td class="center">{{ count($females) }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Stillborn</td>
	  					<td class="center">{{ $stillborn }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Mummified</td>
	  					<td class="center">{{ $mummified }}</td>
		  			</tr>
		  			<tr>
		  				<td>Litter Birth Weight, kg</td>
		  				<td class="center">{{ array_sum($litterbirthweights) }}</td>
		  			</tr>
		  			<tr>
		  				<td>Average Birth Weight, kg</td>
	  					<td class="center">{{ $avebirthweight }}</td>
		  			</tr>
		  			<tr>
		  				<td>Litter Weaning Weight, kg</td>
							<td class="center">{{ array_sum($litterweaningweights) }}</td>
		  			</tr>
		  			<tr>
		  				<td>Average Weaning Weight, kg</td>
	  					<td class="center">{{ $aveweaningweight }}</td>
		  			</tr>
		  			<tr>
		  				<td>Adjusted Weaning Weight at 45 Days, kg</td>
	  					<td class="center">{{ $aveadjweaningweights }}</td>
		  			</tr>
		  			<tr>
		  				<td>Number Weaned</td>
	  					<td class="center">{{ $numberweaned }}</td>
		  			</tr>
		  			<tr>
		  				<td>Age Weaned, days</td>
	  					<td class="center">{{ $aveageweaned }}</td>
		  			</tr>
		  			<tr>
		  				<td>Pre-weaning Mortality</td>
		  				<td class="center">{{ $preweaningmortality }}</td>
		  			</tr>
		  		</tbody>
		  	</table>
		  </div>
		</div>
	</div>
@endsection