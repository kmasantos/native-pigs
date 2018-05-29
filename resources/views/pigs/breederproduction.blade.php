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
	    	<p class="center">Total number of pigs in the herd: {{ count($breeders) }}</p>

	      <ul class="tabs tabs-fixed-width green lighten-1">
	        <li class="tab"><a href="#weightsview">Weights</a></li>
	        <li class="tab"><a href="#weaningageview">Age at Weaning</a></li>
	        <li class="tab"><a href="#firstbreedingview">Age at First Breeding</a></li>
	        <li class="tab"><a href="#breedingherdview">Age of Breeding Herd</a></li>
	      </ul>
	    </div>
	    <!-- WEIGHTS -->
	    <div id="weightsview" class="col s12">
	    	<h5 class="center green-text text-lighten-1">Herd</h5>
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
	    	<h5 class="center green-text text-lighten-1">Year of Birth</h5>
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
	    <!-- AGE AT WEANING -->
	    <div id="weaningageview" class="col s12">
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th></th>
	    				<th>Number of Pigs Weaned</th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td colspan="2"> </td>
	    				<td colspan="4" class="center">in days</td>
	    			</tr>
	    			<tr>
	    				<td>Sows</td>
	    				@if($ages_weanedsow == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		    				<td>{{ count($ages_weanedsow) }} out of {{ count($sows) }}</td>
		    				<td>{{ min($ages_weanedsow) }}</td>
		    				<td>{{ max($ages_weanedsow) }}</td>
		    				<td>{{ round(array_sum($ages_weanedsow)/count($ages_weanedsow), 2) }}</td>
		    				<td>{{ round($ages_weanedsow_sd, 2) }}</td>
		    			@endif
	    			</tr>
	    			<tr>
	    				<td>Boars</td>
	    				@if($ages_weanedboar == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		    				<td>{{ count($ages_weanedboar) }} out of {{ count($boars) }}</td>
		    				<td>{{ min($ages_weanedboar) }}</td>
		    				<td>{{ max($ages_weanedboar) }}</td>
		    				<td>{{ round(array_sum($ages_weanedboar)/count($ages_weanedboar), 2) }}</td>
		    				<td>{{ round($ages_weanedboar_sd, 2) }}</td>
		    			@endif
	    			</tr>
	    			<tr>
	    				<td>Herd</td>
	    				@if($ages_weanedbreeder == [])
		            <td colspan="5" class="center">No data available</td>
		          @else
		    				<td>{{ count($ages_weanedbreeder) }} out of {{ count($sows)+count($boars) }}</td>
		    				<td>{{ min($ages_weanedbreeder) }}</td>
		    				<td>{{ max($ages_weanedbreeder) }}</td>
		    				<td>{{ round(array_sum($ages_weanedbreeder)/count($ages_weanedbreeder), 2) }}</td>
		    				<td>{{ round($ages_weanedbreeder_sd, 2) }}</td>
		    			@endif
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
	    				<th>Number of Bred Pigs with Age Data</th>
	    				<th>Minimum</th>
	    				<th>Maximum</th>
	    				<th>Average</th>
	    				<th>Standard Deviation</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<tr>
	    				<td colspan="2"> </td>
	    				<td colspan="4" class="center">in months</td>
	    			</tr>
	    			<tr>
	    				<td>Sows</td>
	    				@if($firstbredsowsages == [])
	    					<td colspan="5" class="center">No data available</td>
	    				@else
		    				<td>{{ count($firstbredsowsages) }} out of {{ count($firstbredsows)+count($duplicates) }}</td>
		    				<td>{{ min($firstbredsowsages) }}</td>
		    				<td>{{ max($firstbredsowsages) }}</td>
		    				<td>{{ round(array_sum($firstbredsowsages)/count($firstbredsowsages), 2) }}</td>
		    				<td>{{ round($firstbredsowsages_sd, 2) }}</td>
		    			@endif
	    			</tr>
	    			<tr>
	    				<td>Boars</td>
	    				@if($firstbredboarsages == [])
	    					<td colspan="5" class="center">No data available</td>
	    				@else
		    				<td>{{ count($firstbredboarsages) }} out of {{ count($firstbredboars)+count($uniqueboars) }}</td>
		    				<td>{{ min($firstbredboarsages) }}</td>
		    				<td>{{ max($firstbredboarsages) }}</td>
		    				<td>{{ round(array_sum($firstbredboarsages)/count($firstbredboarsages), 2) }}</td>
		    				<td>{{ round($firstbredboarsages_sd, 2) }}</td>
		    			@endif
	    			</tr>
	    			<tr>
	    				<td>Herd</td>
	    				@if($firstbredages == [])
	    					<td colspan="5" class="center">No data available</td>
	    				@else
		    				<td>{{ count($firstbredages) }} out of {{ count($firstbredsows)+count($duplicates)+count($firstbredboars)+count($uniqueboars) }}</td>
		    				<td>{{ min($firstbredages) }}</td>
		    				<td>{{ max($firstbredages) }}</td>
		    				<td>{{ round(array_sum($firstbredages)/count($firstbredages), 2) }}</td>
		    				<td>{{ round($firstbredages_sd, 2) }}</td>
		    			@endif
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- AGE OF BREEDING HERD -->
	    <div id="breedingherdview" class="col s12">
	    	<div class="row">
		    	<div class="col s6 push-s3">
	    			<div class="card">
	    				<div class="card-content grey lighten-2">
	    					<h5>Breeders</h5>
	    					@if($breederages != [] && $breeders != [])
		    					<h3>{{ round(array_sum($breederages)/count($breederages) ,2) }}*</h3>
		    					<h5>Average age, months</h5><br><br>
		    					*breeders with age data: {{ count($breederages) }} out of {{ count($herdbreeders) }}<br>
		    				@else
		    					<h3>No data available</h3>
		    				@endif
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col s6">
	    			<div class="card">
	    				<div class="card-content grey lighten-2">
	    					<h5>Sow Breeders</h5>
	    					@if($breedersowages != [] && $breedersows != [])
		    					<h3>{{ round(array_sum($breedersowages)/count($breedersowages) ,2) }}*</h3>
		    					<h5>Average age, months</h5><br><br>
		    					*breeders with age data: {{ count($breedersowages) }} out of {{ count($breedersows) }}<br>
		    				@else
		    					<h3>No data available</h3>
		    				@endif
	    				</div>
	    			</div>
	    		</div>
	    		<div class="col s6">
	    			<div class="card">
	    				<div class="card-content grey lighten-2">
	    					<h5>Boar Breeders</h5>
	    					@if($breederboarages != [] && $breederboars != [])
		    					<h3>{{ round(array_sum($breederboarages)/count($breederboarages) ,2) }}*</h3>
		    					<h5>Average age, months</h5><br><br>
		    					*breeders with age data: {{ count($breederboarages) }} out of {{ count($breederboars) }}<br>
		    				@else
		    					<h3>No data available</h3>
		    				@endif
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
		</div>
	</div>
@endsection