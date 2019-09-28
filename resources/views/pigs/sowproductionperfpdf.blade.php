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
<h4 class="center">Sow Production Performance of {{ $sow->registryid }} as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h4>
@if(!is_null($properties->where("property_id", 3)->first()) && $properties->where("property_id", 3)->first()->value != "Not specified")
	<p class="center">Age First Bred: {{ $age_firstbred }} months, Age First Parity: {{ $age_firstparity }} months (Date of Birth: {{ Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->format('F j, Y') }})</p>
@else
	<p class="center">No Date of Birth to compute for Age First Bred and Age First Parity</p>
@endif
<table class="centered">
	<thead class="green lighten-1">
		<tr>
			<th>Farrowing Intervals</th>
			<th>Farrowing Index</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				@if(count($parities) <= 1)
					No data available
				@else
					@foreach($farrowing_intervals_text as $farrowing_interval_text)
						{{ $farrowing_interval_text }} days<br>
					@endforeach
				@endif
			</td>
			<td>
				@if(count($parities) <= 2)
					No data available
				@else
					{{ round($farrowing_index, 2) }}
				@endif
			</td>
		</tr>
	</tbody>
</table>
<h4 class="center">Sow Card</h4>
<table class="centered">
	<thead class="green lighten-1">
		<tr>
			<th>Parity</th>
			<th>Boar Used</th>
			<th>Date Bred</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		@foreach($usage as $sow_usage)
			<tr>
				@if(App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity") == 0)
					<td>&mdash;</td>
				@else
					<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Parity") }}</td>
				@endif
				<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Boar Used") }}</td>
				<td>{{ Carbon\Carbon::parse($sow_usage)->format('F j, Y') }}</td>
				<td>{{ App\Http\Controllers\FarmController::getGroupingPerParity($sow->id, $sow_usage, "Status") }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<h4 class="center">Summary</h4>
<table class="centered">
	<thead class="green lighten-1">
		<tr>
			<th>Parameters</th>
			<th colspan="{{ count($parities) }}" class="center">Values</th>
			<th class="center">Average &plusmn; SD</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Parity</td>
			@foreach($parities as $parity)
				<td class="center"><strong>{{ $parity }}</strong></td>
			@endforeach
			<td class="center">&mdash;</td>
		</tr>
		<tr>
			<td>Litter-size Born Alive</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "lsba") }}</td>
			@endforeach
			@if($lsba_sow != [])
				<td class="center">{{ round(array_sum($lsba_sow)/count($lsba_sow), 2) }} &plusmn; {{ round($lsba_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Male Born</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number males") }}</td>
			@endforeach
			@if($numbermales_sow != [])
				<td class="center">{{ round(array_sum($numbermales_sow)/count($numbermales_sow), 2) }} &plusmn; {{ round($numbermales_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Female Born</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number females") }}</td>
			@endforeach
			@if($numberfemales_sow != [])
				<td class="center">{{ round(array_sum($numberfemales_sow)/count($numberfemales_sow), 2) }} &plusmn; {{ round($numberfemales_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Stillborn</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "stillborn") }}</td>
			@endforeach
			@if($stillborn_sow != [])
				<td class="center">{{ round(array_sum($stillborn_sow)/count($stillborn_sow), 2) }} &plusmn; {{ round($stillborn_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Mummified</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "mummified") }}</td>
			@endforeach
			@if($mummified_sow != [])
				<td class="center">{{ round(array_sum($mummified_sow)/count($mummified_sow), 2) }} &plusmn; {{ round($mummified_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		{{-- <tr>
			<td>Litter Birth Weight, kg</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "litter birth weight") }}</td>
			@endforeach
			@if($litterbirthweights_sow != [])
				<td class="center">{{ round(array_sum($litterbirthweights_sow)/count($litterbirthweights_sow), 2) }} &plusmn; {{ round($litterbirthweights_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr> --}}
		<tr>
			<td>Average Birth Weight, kg</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "ave birth weight") }}</td>
			@endforeach
			@if($avebirthweights_sow != [])
				<td class="center">{{ round(array_sum($avebirthweights_sow)/count($avebirthweights_sow), 2) }} &plusmn; {{ round($avebirthweights_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		{{-- <tr>
			<td>Litter Weaning Weight, kg</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "litter weaning weight") }}</td>
			@endforeach
			@if($litterweaningweights_sow != [])
				<td class="center">{{ round(array_sum($litterweaningweights_sow)/count($litterweaningweights_sow), 2) }} &plusmn; {{ round($litterweaningweights_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr> --}}
		<tr>
			<td>Average Weaning Weight, kg</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "ave weaning weight") }}</td>
			@endforeach
			@if($aveweaningweights_sow != [])
				<td class="center">{{ round(array_sum($aveweaningweights_sow)/count($aveweaningweights_sow), 2) }} &plusmn; {{ round($aveweaningweights_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		<tr>
			<td>Adjusted Weaning Weight at 45 Days, kg</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "adj weaning weight") }}</td>
			@endforeach
			@if($adjweaningweights_sow != [])
				<td class="center">{{ round(array_sum($adjweaningweights_sow)/count($adjweaningweights_sow), 2) }} &plusmn; {{ round($adjweaningweights_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		<tr>
			<td>Number Weaned</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "number weaned") }}</td>
			@endforeach
			@if($numberweaned_sow != [])
				<td class="center">{{ round(array_sum($numberweaned_sow)/count($numberweaned_sow), 2) }} &plusmn; {{ round($numberweaned_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		<tr>
			<td>Age Weaned, days</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "age weaned") }}</td>
			@endforeach
			@if($agesweaned_sow != [])
				<td class="center">{{ round(array_sum($agesweaned_sow)/count($agesweaned_sow), 2) }} &plusmn; {{ round($agesweaned_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr>
		{{-- <tr>
			<td>Pre-weaning Mortality, %</td>
			@foreach($parities as $parity)
				<td class="center">{{ App\Http\Controllers\FarmController::getSowProductionPerformanceSummary($sow->id, $parity, "preweaning mortality") }}</td>
			@endforeach
			@if($preweaningmortality_sow != [])
				<td class="center">{{ round(array_sum($preweaningmortality_sow)/count($preweaningmortality_sow), 2) }} &plusmn; {{ round($preweaningmortality_sow_sd, 2) }}</td>
			@else
				<td class="center">No data available</td>
			@endif
		</tr> --}}
	</tbody>
</table>