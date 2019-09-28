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
<h4 class="center">Production Performance Report as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h4>
<h4 class="center">SOWS SUMMARY</h4>
<table class="centered">
	<thead class="green lighten-1">
		<tr>
			<th>Parameters</th>
			<th>Average &plusmn; SD</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Litter-size Born Alive</td>
			<td>{{ round(array_sum($lsba_sow)/count($lsba_sow), 2) }} &plusmn; {{ round($lsba_sow_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Male Born</td>
			<td>{{ round(array_sum($numbermales_sow)/count($numbermales_sow), 2) }} &plusmn; {{ round($numbermales_sow_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Female Born</td>
			<td>{{ round(array_sum($numberfemales_sow)/count($numberfemales_sow), 2) }} &plusmn; {{ round($numberfemales_sow_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Stillborn</td>
			<td>{{ round(array_sum($stillborn_sow)/count($stillborn_sow), 2) }} &plusmn; {{ round($stillborn_sow_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Mummified</td>
			<td>{{ round(array_sum($mummified_sow)/count($mummified_sow), 2) }} &plusmn; {{ round($mummified_sow_sd, 2) }}</td>
		</tr>
		{{-- <tr>
			<td>Litter Birth Weight, kg</td>
			<td>{{ round(array_sum($litterbirthweights_sow)/count($litterbirthweights_sow), 2) }} &plusmn; {{ round($litterbirthweights_sow_sd, 2) }}</td>
		</tr> --}}
		<tr>
			<td>Average Birth Weight, kg</td>
			<td>{{ round(array_sum($avebirthweights_sow)/count($avebirthweights_sow), 2) }} &plusmn; {{ round($avebirthweights_sow_sd, 2) }}</td>
		</tr>
		{{-- <tr>
			<td>Litter Weaning Weight, kg</td>
			<td>{{ round(array_sum($litterweaningweights_sow)/count($litterweaningweights_sow), 2) }} &plusmn; {{ round($litterweaningweights_sow_sd, 2) }}</td>
		</tr> --}}
		<tr>
			<td>Average Weaning Weight, kg</td>
			<td>{{ round(array_sum($aveweaningweights_sow)/count($aveweaningweights_sow), 2) }} &plusmn; {{ round($aveweaningweights_sow_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Adjusted Weaning Weight at 45 Days, kg</td>
			<td>{{ round(array_sum($adjweaningweights_sow)/count($adjweaningweights_sow), 2) }} &plusmn; {{ round($adjweaningweights_sow_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Weaned</td>
			<td>{{ round(array_sum($numberweaned_sow)/count($numberweaned_sow), 2) }} &plusmn; {{ round($numberweaned_sow_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Age Weaned, days</td>
			<td>{{ round(array_sum($agesweaned_sow)/count($agesweaned_sow), 2) }} &plusmn; {{ round($agesweaned_sow_sd, 2) }}</td>
		</tr>
		{{-- <tr>
			<td>Pre-weaning Mortality, %</td>
			<td>{{ round(array_sum($preweaningmortality_sow)/count($preweaningmortality_sow), 2) }} &plusmn; {{ round($preweaningmortality_sow_sd, 2) }}</td>
		</tr> --}}
	</tbody>
</table>
<br>
<h4 class="center">BOARS SUMMARY</h4>
<table class="centered">
	<thead class="green lighten-1">
		<tr>
			<th>Parameters</th>
			<th>Average &plusmn; SD</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Litter-size Born Alive</td>
			<td>{{ round(array_sum($lsba_boar)/count($lsba_boar), 2) }} &plusmn; {{ round($lsba_boar_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Male Born</td>
			<td>{{ round(array_sum($numbermales_boar)/count($numbermales_boar), 2) }} &plusmn; {{ round($numbermales_boar_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Female Born</td>
			<td>{{ round(array_sum($numberfemales_boar)/count($numberfemales_boar), 2) }} &plusmn; {{ round($numberfemales_boar_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Stillborn</td>
			<td>{{ round(array_sum($stillborn_boar)/count($stillborn_boar), 2) }} &plusmn; {{ round($stillborn_boar_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Mummified</td>
			<td>{{ round(array_sum($mummified_boar)/count($mummified_boar), 2) }} &plusmn; {{ round($mummified_boar_sd, 2) }}</td>
		</tr>
		{{-- <tr>
			<td>Litter Birth Weight, kg</td>
			<td>{{ round(array_sum($litterbirthweights_boar)/count($litterbirthweights_boar), 2) }} &plusmn; {{ round($litterbirthweights_boar_sd, 2) }}</td>
		</tr> --}}
		<tr>
			<td>Average Birth Weight, kg</td>
			<td>{{ round(array_sum($avebirthweights_boar)/count($avebirthweights_boar), 2) }} &plusmn; {{ round($avebirthweights_boar_sd, 2) }}</td>
		</tr>
		{{-- <tr>
			<td>Litter Weaning Weight, kg</td>
			<td>{{ round(array_sum($litterweaningweights_boar)/count($litterweaningweights_boar), 2) }} &plusmn; {{ round($litterweaningweights_boar_sd, 2) }}</td>
		</tr> --}}
		<tr>
			<td>Average Weaning Weight, kg</td>
			<td>{{ round(array_sum($aveweaningweights_boar)/count($aveweaningweights_boar), 2) }} &plusmn; {{ round($aveweaningweights_boar_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Adjusted Weaning Weight at 45 Days, kg</td>
			<td>{{ round(array_sum($adjweaningweights_boar)/count($adjweaningweights_boar), 2) }} &plusmn; {{ round($adjweaningweights_boar_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Number Weaned</td>
			<td>{{ round(array_sum($numberweaned_boar)/count($numberweaned_boar), 2) }} &plusmn; {{ round($numberweaned_boar_sd, 2) }}</td>
		</tr>
		<tr>
			<td>Age Weaned, days</td>
			<td>{{ round(array_sum($agesweaned_boar)/count($agesweaned_boar), 2) }} &plusmn; {{ round($agesweaned_boar_sd, 2) }}</td>
		</tr>
		{{-- <tr>
			<td>Pre-weaning Mortality, %</td>
			<td>{{ round(array_sum($preweaningmortality_boar)/count($preweaningmortality_boar), 2) }} &plusmn; {{ round($preweaningmortality_boar_sd, 2) }}</td>
		</tr> --}}
	</tbody>
</table>