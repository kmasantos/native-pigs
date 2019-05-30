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
<h4 class="center">Breeder Inventory Report for the month of {{ Carbon\Carbon::parse($now)->format('F, Y') }} as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h4>
<br>
<h4 class="center">Sow Inventory</h4>
@if($noage_sows == [])
	<p class="center">Number of female breeders in the herd: <b>{{ count($sows) }}</b> (sows: {{ count($bredsows)+count($bredgilts)+count($pregnantsows)+count($lactatingsows)+$drysows }}, gilts: {{ count($gilts) }})</p>
	<p class="center">Average age: <b>{{ round(array_sum($age_sows)/(count($sows)-count($noage_sows)), 2) }} months</b></p>
@else
	<p class="center">Number of female breeders in the herd: <b>{{ count($sows) }}</b> (sows: {{ count($bredsows)+count($bredgilts)+count($pregnantsows)+count($lactatingsows)+$drysows }}, gilts: {{ count($gilts) }})</p>
	<p class="center">Average age: <b>{{ round(array_sum($age_sows)/(count($sows)-count($noage_sows)), 2) }} months</b> (female breeders without age data: {{ count($noage_sows) }})</p>
@endif
<table class="centered">
	<thead>
		<tr>
			<th colspan="3">Pregnant (bred sows and gilts are considered pregnant)</th>
		</tr>
		<tr>
			<th>Bred Sows</th>
			<th>Bred Gilts</th>
			<th>Confirmed</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ count($bredsows) }}</td>
			<td>{{ count($bredgilts) }}</td>
			<td>{{ count($pregnantsows) }}</td>
		</tr>
	</tbody>
</table>
<br>
<table class="centered">
	<thead>
		<tr>
			<th>Gilts (not yet bred)</th>
			<th>Lactating (farrowed, not yet weaned)</th>
			<th>Dry Sows (weaned and recycled sows)</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ count($gilts) }}</td>
			<td>{{ count($lactatingsows) }}</td>
			<td>
				@if($drysows < 0)
					0
				@else
					{{ $drysows }}
				@endif
			</td>
		</tr>
	</tbody>
</table>
<br><br>
<h4 class="center">Boar Inventory</h4>
<p class="center">Number of boars in the herd: <b>{{ count($boars) }}</b></p>
<p class="center">Average age: <b>{{ round(array_sum($age_boars)/(count($srboars)+count($jrboars)), 2) }} months</b>*</p>
<table class="centered">
	<thead>
		<tr>
			<th>Junior Boars (less than 1	year old)</th>
			<th>Senior Boars (1 year old and above)</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ count($jrboars) }}</td>
			<td>{{ count($srboars) }}</td>
		</tr>
	</tbody>
</table>
@if($noage_boars != [])
	<p class="center">*boars without age data: {{ count($noage_boars) }}</p>
@endif