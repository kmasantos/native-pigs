<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.1/css/materialize.min.css">
<style>
	table, th, td {
		border: solid black 1px;
	}
	table {
		border-collapse: collapse;
	}
</style>

<h3 class="center green-text text-lighten-1">Native Pig Breed Information System</h3>
<hr>
<h4 class="center">Growth Performance Report as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h4>
<h4 class="center">HERD</h4>
<h6 class="center">Total number of pigs: <strong>{{ count($pigs) }}</strong></h6>
<table class="centered">
	<thead class="green lighten-1">
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
			@if($wweights == [])
				<td>Weaning, kg</td>
        <td colspan="5" class="center">No data available</td>
      @else
      	<td>Weaning at {{ round((array_sum($agesweaned_all)/count($agesweaned_all)), 2) }} days, kg</td>
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
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<h4 class="center">BREEDERS</h4>
<h6 class="center">Total number of breeders: <strong>{{ count($breeders) }}</strong></h6>
<table class="centered">
	<thead class="green lighten-1">
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
			@if($wweights_breeders == [])
				<td>Weaning, kg</td>
        <td colspan="5" class="center">No data available</td>
      @else
      	<td>Weaning at {{ round((array_sum($agesweaned_breeders)/count($agesweaned_breeders)), 2) }} days, kg</td>
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
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<h4 class="center">GROWERS</h4>
<h6 class="center">Total number of growers: <strong>{{ count($growers) }}</strong></h6>
<table class="centered">
	<thead class="green lighten-1">
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
			@if($wweights_growers == [])
				<td>Weaning, kg</td>
        <td colspan="5" class="center">No data available</td>
      @else
      	<td>Weaning at {{ round((array_sum($agesweaned_growers)/count($agesweaned_growers)), 2) }} days, kg</td>
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
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<h4 class="center">YEAR OF BIRTH</h4>
<h6 class="center">Total number of pigs: <strong>{{ count($pigs) }}</strong></h6>
<p class="green-text text-lighten-1">Birth Weight, kg</p>
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
				<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 5)) }}</td>
				@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 5) == [])
					<td colspan="4">No data available</td>
				@else
					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 5)) }}</td>
					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 5)) }}</td>
					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 5))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 5)), 2) }}</td>
					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 5), false), 2) }}</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="6">No data available</td>
			</tr>
		@endforelse
	</tbody>
</table>
@if($years == [])
	<p class="green-text text-lighten-1">Weaning Weight, kg</p>
@else
	<p class="green-text text-lighten-1">Weaning Weight at {{ round((array_sum($agesweaned_all)/count($agesweaned_all)), 2) }} days, kg</p>
@endif
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
				<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 7)) }}</td>
				@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 7) == [])
					<td colspan="4">No data available</td>
				@else
					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 7)) }}</td>
					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 7)) }}</td>
					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 7))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 7)), 2) }}</td>
					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 7), false), 2) }}</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="6">No data available</td>
			</tr>
		@endforelse
	</tbody>
</table>
<p class="green-text text-lighten-1">Body weight at 45 days, kg</p>
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
				<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 32)) }}</td>
				@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 32) == [])
					<td colspan="4">No data available</td>
				@else
					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 32)) }}</td>
					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 32)) }}</td>
					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 32))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 32)), 2) }}</td>
					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 32), false), 2) }}</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="6">No data available</td>
			</tr>
		@endforelse
	</tbody>
</table>
<p class="green-text text-lighten-1">Body weight at 60 days, kg</p>
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
				<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 33)) }}</td>
				@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 33) == [])
					<td colspan="4">No data available</td>
				@else
					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 33)) }}</td>
					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 33)) }}</td>
					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 33))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 33)), 2) }}</td>
					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 33), false), 2) }}</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="6">No data available</td>
			</tr>
		@endforelse
	</tbody>
</table>
<p class="green-text text-lighten-1">Body weight at 90 days, kg</p>
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
				<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 34)) }}</td>
				@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 34) == [])
					<td colspan="4">No data available</td>
				@else
					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 34)) }}</td>
					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 34)) }}</td>
					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 34))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 34)), 2) }}</td>
					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 34), false), 2) }}</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="6">No data available</td>
			</tr>
		@endforelse
	</tbody>
</table>
<p class="green-text text-lighten-1">Body weight at 150 days, kg</p>
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
				<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 35)) }}</td>
				@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 35) == [])
					<td colspan="4">No data available</td>
				@else
					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 35)) }}</td>
					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 35)) }}</td>
					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 35))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 35)), 2) }}</td>
					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 35), false), 2) }}</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="6">No data available</td>
			</tr>
		@endforelse
	</tbody>
</table>
<p class="green-text text-lighten-1">Body weight at 180 days, kg</p>
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
				<td>{{ count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 36)) }}</td>
				@if(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 36) == [])
					<td colspan="4">No data available</td>
				@else
					<td>{{ min(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 36)) }}</td>
					<td>{{ max(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 36)) }}</td>
					<td>{{ round(array_sum(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 36))/count(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 36)), 2) }}</td>
					<td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getWeightsPerYearOfBirth($year, 36), false), 2) }}</td>
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="6">No data available</td>
			</tr>
		@endforelse
	</tbody>
</table>