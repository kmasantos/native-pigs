@extends('layouts.swinedefault')

@section('title')
	Growth Performance Report
@endsection

@section('content')
	<div class="container">
		<h4>Growth Performance Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<h5 class="center">Inventory as of {{ $now->format('F j, Y') }}</h5>
			<div class="col s12">
				<ul class="tabs tabs-fixed-width green lighten-1">
	        <li class="tab"><a href="#perherdview">Herd</a></li>
	        <li class="tab"><a href="#breedersview">Breeders</a></li>
	        <li class="tab"><a href="#growersview">Growers</a></li>
	        <li class="tab"><a href="#peryearofbirthview">Year of Birth</a></li>
	      </ul>
	    </div>
	    {{-- PER HERD --}}
	    <div id="perherdview" class="col s12">
	    	<h5 class="center">Total number of pigs: {{ count($pigs) }} <a href="#!" class="tooltipped" data-position="bottom" data-tooltip="All pigs including dead, sold, culled, and donated"><i class="material-icons">info_outline</i></a></h5>
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th>Weighing Age</th>
	    				<th>Number of Pigs Weighed</th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td>Birth, kg</td>
	    				@if($bweights == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($bweights) }}</td>
		    				<td>{{ min($bweights) }}</td>
		    				<td>{{ max($bweights) }}</td>
		    				<td>{{ round((array_sum($bweights)/count($bweights)), 2) }}</td>
		    				<td>{{ round($bweights_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>Weaning, kg</td>
	    				@if($wweights == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($wweights) }}</td>
		    				<td>{{ min($wweights) }}</td>
		    				<td>{{ max($wweights) }}</td>
		    				<td>{{ round((array_sum($wweights)/count($wweights)), 2) }}</td>
		    				<td>{{ round($wweights_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>45 days, kg</td>
	    				@if($weights45d == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights45d) }}</td>
		    				<td>{{ min($weights45d) }}</td>
		    				<td>{{ max($weights45d) }}</td>
		    				<td>{{ round((array_sum($weights45d)/count($weights45d)), 2) }}</td>
		    				<td>{{ round($weights45d_sd, 2) }}</td>
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
		    				<td>{{ round((array_sum($weights60d)/count($weights60d)), 2) }}</td>
		    				<td>{{ round($weights60d_sd, 2) }}</td>
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
		    				<td>{{ round((array_sum($weights90d)/count($weights90d)), 2) }}</td>
		    				<td>{{ round($weights90d_sd, 2) }}</td>
							@endif	
	    			</tr>
	    			<tr>
	    				<td>150 days, kg</td>
	    				@if($weights150d == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights150d) }}</td>
		    				<td>{{ min($weights150d) }}</td>
		    				<td>{{ max($weights150d) }}</td>
		    				<td>{{ round((array_sum($weights150d)/count($weights150d)), 2) }}</td>
		    				<td>{{ round($weights150d_sd, 2) }}</td>
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
		    				<td>{{ round((array_sum($weights180d)/count($weights180d)), 2) }}</td>
		    				<td>{{ round($weights180d_sd, 2) }}</td>
							@endif	
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    {{-- BREEDERS --}}
	    <div id="breedersview" class="col s12">
	    	<h5 class="center">Total number of breeders: {{ count($breeders) }}</h5>
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th>Weighing Age</th>
	    				<th>Number of Pigs Weighed</th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td>Birth, kg</td>
	    				@if($bweights_breeders == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($bweights_breeders) }}</td>
		    				<td>{{ min($bweights_breeders) }}</td>
		    				<td>{{ max($bweights_breeders) }}</td>
		    				<td>{{ round((array_sum($bweights_breeders)/count($bweights_breeders)), 2) }}</td>
		    				<td>{{ round($bweights_breeders_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>Weaning, kg</td>
	    				@if($wweights_breeders == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($wweights_breeders) }}</td>
		    				<td>{{ min($wweights_breeders) }}</td>
		    				<td>{{ max($wweights_breeders) }}</td>
		    				<td>{{ round((array_sum($wweights_breeders)/count($wweights_breeders)), 2) }}</td>
		    				<td>{{ round($wweights_breeders_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>45 days, kg</td>
	    				@if($weights45d_breeders == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights45d_breeders) }}</td>
		    				<td>{{ min($weights45d_breeders) }}</td>
		    				<td>{{ max($weights45d_breeders) }}</td>
		    				<td>{{ round((array_sum($weights45d_breeders)/count($weights45d_breeders)), 2) }}</td>
		    				<td>{{ round($weights45d_breeders_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>60 days, kg</td>
	    				@if($weights60d_breeders == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights60d_breeders) }}</td>
		    				<td>{{ min($weights60d_breeders) }}</td>
		    				<td>{{ max($weights60d_breeders) }}</td>
		    				<td>{{ round((array_sum($weights60d_breeders)/count($weights60d_breeders)), 2) }}</td>
		    				<td>{{ round($weights60d_breeders_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>90 days, kg</td>
	    				@if($weights90d_breeders == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights90d_breeders) }}</td>
		    				<td>{{ min($weights90d_breeders) }}</td>
		    				<td>{{ max($weights90d_breeders) }}</td>
		    				<td>{{ round((array_sum($weights90d_breeders)/count($weights90d_breeders)), 2) }}</td>
		    				<td>{{ round($weights90d_breeders_sd, 2) }}</td>
							@endif	
	    			</tr>
	    			<tr>
	    				<td>150 days, kg</td>
	    				@if($weights150d_breeders == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights150d_breeders) }}</td>
		    				<td>{{ min($weights150d_breeders) }}</td>
		    				<td>{{ max($weights150d_breeders) }}</td>
		    				<td>{{ round((array_sum($weights150d_breeders)/count($weights150d_breeders)), 2) }}</td>
		    				<td>{{ round($weights150d_breeders_sd, 2) }}</td>
							@endif	
	    			</tr>
	    			<tr>
	    				<td>180 days, kg</td>
	    				@if($weights180d_breeders == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights180d_breeders) }}</td>
		    				<td>{{ min($weights180d_breeders) }}</td>
		    				<td>{{ max($weights180d_breeders) }}</td>
		    				<td>{{ round((array_sum($weights180d_breeders)/count($weights180d_breeders)), 2) }}</td>
		    				<td>{{ round($weights180d_breeders_sd, 2) }}</td>
							@endif	
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    {{-- GROWERS --}}
	    <div id="growersview" class="col s12">
	    	<h5 class="center">Total number of growers: {{ count($growers) }}</h5>
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th>Weighing Age</th>
	    				<th>Number of Pigs Weighed</th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td>Birth, kg</td>
	    				@if($bweights_growers == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($bweights_growers) }}</td>
		    				<td>{{ min($bweights_growers) }}</td>
		    				<td>{{ max($bweights_growers) }}</td>
		    				<td>{{ round((array_sum($bweights_growers)/count($bweights_growers)), 2) }}</td>
		    				<td>{{ round($bweights_growers_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>Weaning, kg</td>
	    				@if($wweights_growers == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($wweights_growers) }}</td>
		    				<td>{{ min($wweights_growers) }}</td>
		    				<td>{{ max($wweights_growers) }}</td>
		    				<td>{{ round((array_sum($wweights_growers)/count($wweights_growers)), 2) }}</td>
		    				<td>{{ round($wweights_growers_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>45 days, kg</td>
	    				@if($weights45d_growers == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights45d_growers) }}</td>
		    				<td>{{ min($weights45d_growers) }}</td>
		    				<td>{{ max($weights45d_growers) }}</td>
		    				<td>{{ round((array_sum($weights45d_growers)/count($weights45d_growers)), 2) }}</td>
		    				<td>{{ round($weights45d_growers_sd, 2) }}</td>
							@endif		    				
	    			</tr>
	    			<tr>
	    				<td>60 days, kg</td>
	    				@if($weights60d_growers == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights60d_growers) }}</td>
		    				<td>{{ min($weights60d_growers) }}</td>
		    				<td>{{ max($weights60d_growers) }}</td>
		    				<td>{{ round((array_sum($weights60d_growers)/count($weights60d_growers)), 2) }}</td>
		    				<td>{{ round($weights60d_growers_sd, 2) }}</td>
							@endif
	    			</tr>
	    			<tr>
	    				<td>90 days, kg</td>
	    				@if($weights90d_growers == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights90d_growers) }}</td>
		    				<td>{{ min($weights90d_growers) }}</td>
		    				<td>{{ max($weights90d_growers) }}</td>
		    				<td>{{ round((array_sum($weights90d_growers)/count($weights90d_growers)), 2) }}</td>
		    				<td>{{ round($weights90d_growers_sd, 2) }}</td>
							@endif	
	    			</tr>
	    			<tr>
	    				<td>150 days, kg</td>
	    				@if($weights150d_growers == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights150d_growers) }}</td>
		    				<td>{{ min($weights150d_growers) }}</td>
		    				<td>{{ max($weights150d_growers) }}</td>
		    				<td>{{ round((array_sum($weights150d_growers)/count($weights150d_growers)), 2) }}</td>
		    				<td>{{ round($weights150d_growers_sd, 2) }}</td>
							@endif	
	    			</tr>
	    			<tr>
	    				<td>180 days, kg</td>
	    				@if($weights180d_growers == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		          	<td>{{ count($weights180d_growers) }}</td>
		    				<td>{{ min($weights180d_growers) }}</td>
		    				<td>{{ max($weights180d_growers) }}</td>
		    				<td>{{ round((array_sum($weights180d_growers)/count($weights180d_growers)), 2) }}</td>
		    				<td>{{ round($weights180d_growers_sd, 2) }}</td>
							@endif	
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    {{-- PER YEAR OF BIRTH --}}
	    <div id="peryearofbirthview" class="col s12">
	   		<h5 class="center">Total number of pigs: {{ count($pigs) }} <a href="#!" class="tooltipped" data-position="bottom" data-tooltip="All pigs including dead, sold, culled, and donated"><i class="material-icons">info_outline</i></a></h5>
	    	<div class="row center">
	    		<p>Birth Weight, kg</p>
	    		<table class="centered">
	    			<thead>
	    				<tr>
	    					<th>Year</th>
	    					<th>Number of Pigs Weighed</th>
	    					<th>Minimum</th>
	    					<th>Maximum</th>
	    					<th>Average</th>
	    					<th>Standard Deviation</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse($years as $year)
		    				<tr>
		    					<td>{{ $year }}</td>
		    					<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 53)) }}</td>
		    					@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 53) == [])
			    					<td colspan="4">No data available</td>
			    				@else
			    					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 53)) }}</td>
			    					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 53)) }}</td>
			    					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 53))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 53)), 2) }}</td>
			    					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 53), false), 2) }}</td>
			    				@endif
		    				</tr>
		    			@empty
		    				<tr>
		    					<td colspan="6">No data available</td>
		    				</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
	    	<div class="row center">
	    		<p>Weaning Weight, kg</p>
	    		<table class="centered">
	    			<thead>
	    				<tr>
	    					<th>Year</th>
	    					<th>Number of Pigs Weighed</th>
	    					<th>Minimum</th>
	    					<th>Maximum</th>
	    					<th>Average</th>
	    					<th>Standard Deviation</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse($years as $year)
		    				<tr>
		    					<td>{{ $year }}</td>
		    					<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 54)) }}</td>
		    					@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 54) == [])
			    					<td colspan="4">No data available</td>
			    				@else
			    					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 54)) }}</td>
			    					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 54)) }}</td>
			    					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 54))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 54)), 2) }}</td>
			    					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 54), false), 2) }}</td>
			    				@endif
		    				</tr>
		    			@empty
		    				<tr>
		    					<td colspan="6">No data available</td>
		    				</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
	    	<div class="row center">
	    		<p>Body weight at 45 days, kg</p>
	    		<table class="centered">
	    			<thead>
	    				<tr>
	    					<th>Year</th>
	    					<th>Number of Pigs Weighed</th>
	    					<th>Minimum</th>
	    					<th>Maximum</th>
	    					<th>Average</th>
	    					<th>Standard Deviation</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse($years as $year)
		    				<tr>
		    					<td>{{ $year }}</td>
		    					<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 45)) }}</td>
		    					@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 45) == [])
			    					<td colspan="4">No data available</td>
			    				@else
			    					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 45)) }}</td>
			    					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 45)) }}</td>
			    					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 45))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 45)), 2) }}</td>
			    					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 45), false), 2) }}</td>
			    				@endif
		    				</tr>
		    			@empty
		    				<tr>
		    					<td colspan="6">No data available</td>
		    				</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
		    <div class="row center">
	    		<p>Body weight at 60 days, kg</p>
	    		<table class="centered">
	    			<thead>
	    				<tr>
	    					<th>Year</th>
	    					<th>Number of Pigs Weighed</th>
	    					<th>Minimum</th>
	    					<th>Maximum</th>
	    					<th>Average</th>
	    					<th>Standard Deviation</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse($years as $year)
		    				<tr>
		    					<td>{{ $year }}</td>
		    					<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 46)) }}</td>
		    					@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 46) == [])
			    					<td colspan="4">No data available</td>
			    				@else
			    					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 46)) }}</td>
			    					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 46)) }}</td>
			    					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 46))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 46)), 2) }}</td>
			    					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 46), false), 2) }}</td>
			    				@endif
		    				</tr>
	    				@empty
		    				<tr>
		    					<td colspan="6">No data available</td>
		    				</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
	    	<div class="row center">
	    		<p>Body weight at 90 days, kg</p>
	    		<table class="centered">
	    			<thead>
	    				<tr>
	    					<th>Year</th>
	    					<th>Number of Pigs Weighed</th>
	    					<th>Minimum</th>
	    					<th>Maximum</th>
	    					<th>Average</th>
	    					<th>Standard Deviation</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse($years as $year)
		    				<tr>
		    					<td>{{ $year }}</td>
		    					<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 69)) }}</td>
		    					@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 69) == [])
			    					<td colspan="4">No data available</td>
			    				@else
			    					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 69)) }}</td>
			    					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 69)) }}</td>
			    					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 69))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 69)), 2) }}</td>
			    					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 69), false), 2) }}</td>
			    				@endif
		    				</tr>
	    				@empty
		    				<tr>
		    					<td colspan="6">No data available</td>
		    				</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
	    	<div class="row center">
	    		<p>Body weight at 150 days, kg</p>
	    		<table class="centered">
	    			<thead>
	    				<tr>
	    					<th>Year</th>
	    					<th>Number of Pigs Weighed</th>
	    					<th>Minimum</th>
	    					<th>Maximum</th>
	    					<th>Average</th>
	    					<th>Standard Deviation</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse($years as $year)
		    				<tr>
		    					<td>{{ $year }}</td>
		    					<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 90)) }}</td>
		    					@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 90) == [])
			    					<td colspan="4">No data available</td>
			    				@else
			    					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 90)) }}</td>
			    					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 90)) }}</td>
			    					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 90))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 90)), 2) }}</td>
			    					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 90), false), 2) }}</td>
			    				@endif
		    				</tr>
	    				@empty
		    				<tr>
		    					<td colspan="6">No data available</td>
		    				</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
		    <div class="row center">
	    		<p>Body weight at 180 days, kg</p>
	    		<table class="centered">
	    			<thead>
	    				<tr>
	    					<th>Year</th>
	    					<th>Number of Pigs Weighed</th>
	    					<th>Minimum</th>
	    					<th>Maximum</th>
	    					<th>Average</th>
	    					<th>Standard Deviation</th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse($years as $year)
		    				<tr>
		    					<td>{{ $year }}</td>
		    					<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 47)) }}</td>
		    					@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 47) == [])
			    					<td colspan="4">No data available</td>
			    				@else
			    					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 47)) }}</td>
			    					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 47)) }}</td>
			    					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 47))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 47)), 2) }}</td>
			    					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 47), false), 2) }}</td>
			    				@endif
		    				</tr>
	    				@empty
		    				<tr>
		    					<td colspan="6">No data available</td>
		    				</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
	    </div>
    </div>
	</div>
@endsection