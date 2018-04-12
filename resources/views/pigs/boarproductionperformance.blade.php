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
						<th>Property</th>
						<th class="center">Value</th>
					</tr>
				</thead>
	  		<tbody>
    			<tr>
    				<td>Farrowing Index</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Number Male Born</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Number Female Born</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Litter Birth Weight</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Average Birth Weight</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Number Stillborn</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Number Mummified</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Litter Weaning Weight</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Average Weaning Weight</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Adjusted Weaning Weight at 45 Days</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Number Weaned</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Age Weaned</td>
    				<td class="center"></td>
    			</tr>
    			<tr>
    				<td>Pre-weaning Mortality</td>
    				<td class="center"></td>
    			</tr>
    		</tbody>
	  	</table>
	  </div>
	</div>
@endsection