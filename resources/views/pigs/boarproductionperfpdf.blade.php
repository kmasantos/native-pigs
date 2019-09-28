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
<h4 class="center">Boar Production Performance of {{ $boar->registryid }} as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h4>
<h4 class="center">Boar Card</h4>
<table class="centered">
	<thead class="green lighten-1">
		<tr>
			<th>Service</th>
			<th>Sow Used</th>
			<th>Date Bred</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($services as $service)
			<tr>
				<td>{{ $count++ }}</td>
				<td>{{ App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Sow Used") }}</td>
				<td>{{ Carbon\Carbon::parse($service)->format('F j, Y') }}</td>
				@if(App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Status") == "Farrowed")
					<td>Successful</td>
				@elseif(App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Status") == "Recycled")
					<td>Failed</td>
				@else
					<td>{{ App\Http\Controllers\FarmController::getGroupingPerService($boar->id, $service, "Status") }}</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>
<h4 class="center">Reproductive Performance</h4>
<p class="center">Total number of service: <strong>{{ count($services) }}</strong> (Successful: <strong>{{ count($successful) }}</strong>, Failed: <strong>{{ count($failed) }}</strong>, Others: <strong>{{ count($others) }}</strong>)
<table class="centered">
	<thead class="green lighten-1">
		<tr>
			<th>Parameters (Averages)</th>
			<th>Values</th>
			<th>Standard Deviation</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Litter-size Born Alive</td>
			@if($lsba != [])
				<td>{{ round(array_sum($lsba)/count($lsba), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($lsba, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Male Born</td>
			@if($numbermales != [])
				<td>{{ round(array_sum($numbermales)/count($numbermales), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($numbermales, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Female Born</td>
			@if($numberfemales != [])
				<td>{{ round(array_sum($numberfemales)/count($numberfemales), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($numberfemales, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Stillborn</td>
			@if($stillborn != [])
				<td>{{ round(array_sum($stillborn)/count($stillborn), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($stillborn, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Mummified</td>
			@if($mummified != [])
				<td>{{ round(array_sum($mummified)/count($mummified), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($mummified, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		{{-- <tr>
			<td>Litter Birth Weight, kg</td>
			@if($litterbirthweights != [])
				<td>{{ round(array_sum($litterbirthweights)/count($litterbirthweights), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($litterbirthweights, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr> --}}
		<tr>
			<td>Average Birth Weight, kg</td>
			@if($avebirthweights != [])
				<td>{{ round(array_sum($avebirthweights)/count($avebirthweights), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($avebirthweights, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		{{-- <tr>
			<td>Litter Weaning Weight, kg</td>
			@if($litterweaningweights != [])
				<td>{{ round(array_sum($litterweaningweights)/count($litterweaningweights), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($litterweaningweights, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr> --}}
		<tr>
			<td>Average Weaning Weight, kg</td>
			@if($aveweaningweights != [])
				<td>{{ round(array_sum($aveweaningweights)/count($aveweaningweights), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($aveweaningweights, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		<tr>
			<td>Adjusted Weaning Weight at 45 Days, kg</td>
			@if($adjweaningweights != [])
				<td>{{ round(array_sum($adjweaningweights)/count($adjweaningweights), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($adjweaningweights, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Weaned</td>
			@if($numberweaned != [])
				<td>{{ round(array_sum($numberweaned)/count($numberweaned), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($numberweaned, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		<tr>
			<td>Age weaned, days</td>
			@if($agesweaned != [])
				<td>{{ round(array_sum($agesweaned)/count($agesweaned), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($agesweaned, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr>
		{{-- <tr>
			<td>Pre-weaning Mortality, %</td>
			@if($preweaningmortality != [])
				<td>{{ round(array_sum($preweaningmortality)/count($preweaningmortality), 2) }}</td>
				<td>{{ round(App\Http\Controllers\FarmController::standardDeviation($preweaningmortality, false), 2) }}</td>
			@else
				<td>No data available</td>
				<td>No data available</td>
			@endif
		</tr> --}}
	</tbody>
</table>