@extends('layouts.swinedefault')

@section('title')
	Breeder Production Report
@endsection

@section('content')
	<div class="container">
		<h4>Breeder Production Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
	    <div class="col s12">
	    	<p class="center">Total number of pigs in the herd: {{ count($pigs) }}</p>

	      <ul class="tabs tabs-fixed-width green lighten-1">
	        <li class="tab"><a href="#weightsview">Weights</a></li>
	        <li class="tab"><a href="#weaningageview">Age at Weaning</a></li>
	        <li class="tab"><a href="#firstbreedingview">Age at First Breeding</a></li>
	        <li class="tab"><a href="#breedingherdview">Age of Breeding Herd</a></li>
	      </ul>
	    </div>
	    <!-- WEIGHTS -->
	    <div id="weightsview" class="col s12">
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th>Weighing Age</th>
	    				<th>Pigs Weighed</th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td>45 days, kg</td>
	    				@if($weights45d == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights45d) }}</td>
		    				<td>{{ min($weights45d) }}</td>
		    				<td>{{ max($weights45d) }}</td>
		    				<td>{{ round((array_sum($weights45d)/count($weights45d)), 4) }}</td>
		    				<td>{{ round($weights45d_sd, 4) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>60 days, kg</td>
	    				@if($weights60d == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights60d) }}</td>
		    				<td>{{ min($weights60d) }}</td>
		    				<td>{{ max($weights60d) }}</td>
		    				<td>{{ round((array_sum($weights60d)/count($weights60d)), 4) }}</td>
		    				<td>{{ round($weights60d_sd, 4) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>90 days, kg</td>
	    				@if($weights90d == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights90d) }}</td>
		    				<td>{{ min($weights90d) }}</td>
		    				<td>{{ max($weights90d) }}</td>
		    				<td>{{ round((array_sum($weights90d)/count($weights90d)), 4) }}</td>
		    				<td>{{ round($weights90d_sd, 4) }}</td>
							@endif	
	    			</tr>
	    			<tr>
	    				<td>180 days, kg</td>
	    				@if($weights180d == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights180d) }}</td>
		    				<td>{{ min($weights180d) }}</td>
		    				<td>{{ max($weights180d) }}</td>
		    				<td>{{ round((array_sum($weights180d)/count($weights180d)), 4) }}</td>
		    				<td>{{ round($weights180d_sd, 4) }}</td>
							@endif	
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- AGE AT WEANING -->
	    <div id="weaningageview" class="col s12">
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th></th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td>Sows, months</td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Boars, months</td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Herd, months</td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- AGE AT FIRST BREEDING -->
	    <div id="firstbreedingview" class="col s12">
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th></th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td>Sows, months</td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Boars, months</td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Herd, months</td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- AGE OF BREEDING HERD -->
	    <div id="breedingherdview" class="col s12">
	    	
	    </div>
		</div>
	</div>
@endsection