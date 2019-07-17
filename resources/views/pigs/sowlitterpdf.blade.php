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
<h4 class="center">Sow & Litter Record</h4>
<table>
	<tbody>
		<tr>
			<td>Sow Used</td>
			<td><b>{{ $family->getMother()->registryid }}</b></td>
			@if(!is_null($family->getGroupingProperties()->where("property_id", 48)->first()))
				<td rowspan="2" style="text-align: center; vertical-align: middle;">Parity: <b>{{ $family->getGroupingProperties()->where("property_id", 48)->first()->value }}</b></td>
			@else
				<td rowspan="2" style="text-align: center; vertical-align: middle;">Parity: <b>Not specified</b></td>
			@endif
		</tr>
		<tr>
			<td>Boar Used</td>
			<td><b>{{ $family->getFather()->registryid }}</b></td>
		</tr>
	</tbody>
</table>
<br>
<table>
	<tbody>
		<tr>
			<td>Date Bred: <b>{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 42)->first()->value)->format('j F, Y') }}</b></td>
			@if(is_null($family->getGroupingProperties()->where("property_id", 3)->first()))
				<td>Date Farrowed: </td>
			@else
				<td>Date Farrowed: <b>{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 3)->first()->value)->format('j F, Y') }}</b></td>
			@endif
			@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
				<td>Date Weaned: </td>
			@else
				@if(!is_null($family->getGroupingProperties()->where("property_id", 6)->first()) && $family->getGroupingProperties()->where("property_id", 6)->first()->value != "Not specified")
					<td>Date Weaned: <b>{{ Carbon\Carbon::parse($family->getGroupingProperties()->where("property_id", 6)->first()->value)->format('j F, Y') }}</b></td>
				@elseif(!is_null($family->getGroupingProperties()->where("property_id", 6)->first()) && $family->getGroupingProperties()->where("property_id", 6)->first()->value == "Not specified")
					<td>Date Weaned: No offsprings to wean</td>
				@endif
			@endif
		</tr>
	</tbody>
</table>
<h5 style="text-align: center;">Offspring Record</h5>
<table>
	<tbody>
		<tr>
			<td style="text-align: center;"><b>Offspring ID</b></td>
			<td style="text-align: center;"><b>Sex</b></td>
			<td style="text-align: center;"><b>Birth Weight, kg</b></td>
			<td style="text-align: center;"><b>Weaning Weight, kg</b></td>
		</tr>
		@forelse($offsprings as $offspring)
			<tr>
				<td style="text-align: center;">{{ $offspring->getChild()->registryid }}</td>
				<td style="text-align: center;">{{ $offspring->getAnimalProperties()->where("property_id", 2)->first()->value }}</td>
				<td style="text-align: center;">{{ $offspring->getAnimalProperties()->where("property_id", 5)->first()->value }}</td>
				@if(is_null($family->getGroupingProperties()->where("property_id", 6)->first()))
					@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
						<td style="text-align: center;">No weaning weight available</td>
					@else
						<td style="text-align: center;">{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }}</td>
					@endif
				@else
					@if(is_null($offspring->getAnimalProperties()->where("property_id", 7)->first()))
						<td style="text-align: center;">No weaning weight available</td>
					@else
						<td style="text-align: center;">{{ $offspring->getAnimalProperties()->where("property_id", 7)->first()->value }}</td>
					@endif
				@endif
			</tr>
		@empty
			<tr>
				<td colspan="4" style="text-align: center;">No offspring data found</td>
			</tr>
		@endforelse
	</tbody>
</table>
<h5 style="text-align: center;">Reproductive Performance</h5>
<table>
	<tbody>
		<tr>
			<td>Total Littersize Born</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 49)->first()))
					<td style="text-align: center;">{{ $properties->where("property_id", 49)->first()->value }}</td>
				@else
					<td style="text-align: center;">{{ $properties->where("property_id", 45)->first()->value + $properties->where("property_id", 46)->first()->value + count($offsprings) }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
			<td>Total Littersize Born Alive</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 50)->first()))
					<td style="text-align: center;">{{ $properties->where("property_id", 50)->first()->value }}</td>
				@else
					<td style="text-align: center;">	{{ count($offsprings) }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
		</tr>
		<tr>
			<td>Number Stillborn</td>
			@if(is_null($family->getGroupingProperties()->where("property_id", 45)->first()))
				<td style="text-align: center;">Not specified</td>
			@else
				<td style="text-align: center;">{{ $family->getGroupingProperties()->where("property_id", 45)->first()->value }}</td>
			@endif
			<td>Number Mummified</td>
			@if(is_null($family->getGroupingProperties()->where("property_id", 46)->first()))
				<td style="text-align: center;">Not specified</td>
			@else
				<td style="text-align: center;">{{ $family->getGroupingProperties()->where("property_id", 46)->first()->value }}</td>
			@endif
		</tr>
		<tr>
			<td>Number of Males Born</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 51)->first()))
					<td style="text-align: center;">{{ $properties->where("property_id", 51)->first()->value }}</td>
				@else
					<td style="text-align: center;">{{ $countMales }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
			<td>Number of Females Born</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 52)->first()))
					<td style="text-align: center;">{{ $properties->where("property_id", 52)->first()->value }}</td>
				@else
					<td style="text-align: center;">{{ $countFemales }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
		</tr>
		<tr>
			<td>Sex Ratio (Male to Female)</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 53)->first()))
					<td style="text-align: center;">{{ $properties->where("property_id", 53)->first()->value }}</td>
				@else
					<td style="text-align: center;">{{ $countMales }}:{{ $countFemales }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
			<td>Average Birth Weight, kg</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 56)->first()))
					<td style="text-align: center;">{{ round($properties->where("property_id", 56)->first()->value, 3) }}</td>
				@else
					<td style="text-align: center;">{{ round($aveBirthWeight, 3) }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
		</tr>
		<tr>
			<td>Number Weaned</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 57)->first()))
					<td style="text-align: center;">{{ $properties->where("property_id", 57)->first()->value }}</td>
				@else
					<td style="text-align: center;">{{ $weaned }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
			<td>Average Weaning Weight, kg</td>
			@if($family->members == 1)
				@if(!is_null($properties->where("property_id", 58)->first()))
					<td style="text-align: center;">{{ round($properties->where("property_id", 58)->first()->value, 3) }}</td>
				@else
					<td style="text-align: center;">{{ round($aveWeaningWeight, 3) }}</td>
				@endif
			@else
				<td style="text-align: center;">No data available yet</td>
			@endif
		</tr>
	</tbody>
</table>