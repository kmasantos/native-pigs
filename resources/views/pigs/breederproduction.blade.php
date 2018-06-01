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
	        <li class="tab"><a href="#weaningageview">Age at Weaning</a></li>
	        <li class="tab"><a href="#firstbreedingview">Age at First Breeding</a></li>
	        <li class="tab"><a href="#breedingherdview">Age of Breeding Herd</a></li>
	      </ul>
	    </div>
	    <!-- AGE AT WEANING -->
	    <div id="weaningageview" class="col s12" style="padding-top: 10px;">
	    	<table class="centered">
	    		<thead>
	    			<tr>
	    				<th></th>
	    				<th>Number of Pigs with Record</th>
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
	    <div id="firstbreedingview" class="col s12" style="padding-top: 10px;">
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
	    <div id="breedingherdview" class="col s12" style="padding-top: 10px;">
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