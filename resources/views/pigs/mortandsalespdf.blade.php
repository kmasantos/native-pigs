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
<h4 class="center">Mortality and Sales Report for <strong>{{ Carbon\Carbon::parse($now)->format('F, Y') }}</strong> as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h4>
<table class="centered">
	<tbody>
		<tr class="green lighten-1">
			<td colspan="2">Dead Pigs</td>
			<td>Culled/Donated Pigs</td>
		</tr>
		<tr>
			<td>Total</td>
			<td>Average Age, months</td>
			<td>Total</td>
		</tr>
		<tr>
			<td>
				@if(!is_null($currentdeadpigs))
          {{ count($currentdeadpigs) }}
        @else
          No data available
        @endif
			</td>
			<td>
				@if($ages_dead == [])
          No data available
        @else
          {{ round(array_sum($ages_dead)/count($ages_dead), 2) }}
        @endif
			</td>
			<td>
				{{ count($currentremoved) }}
			</td>
		</tr>
		<tr class="green lighten-1">
			<td colspan="3">Sold Pigs</td>
		</tr>
		<tr class="grey lighten-2">
			<td colspan="3">Breeders</td>
		</tr>
		<tr>
			<td>Total</td>
			<td>Average Age when Sold, months</td>
			<td>Average Weight when Sold, kg</td>
		</tr>
		<tr>
			<td>
				{{ count($currentsoldbreeders) }}
			</td>
			<td>
				@if($ages_currentsoldbreeder == [])
          No data available
        @else
          {{ round(array_sum($ages_currentsoldbreeder)/count($ages_currentsoldbreeder), 2) }}
        @endif
			</td>
			<td>
				@if($weights_currentsoldbreeder == [])
          No data available
        @else
          {{ round(array_sum($weights_currentsoldbreeder)/count($weights_currentsoldbreeder), 2) }}
        @endif
			</td>
		</tr>
		<tr class="grey lighten-2">
			<td colspan="3">Growers</td>
		</tr>
		<tr>
			<td>Total</td>
			<td>Average Age when Sold, months</td>
			<td>Average Weight when Sold, kg</td>
		</tr>
		<tr>
			<td>
				{{ count($currentsoldgrowers) }}
			</td>
			<td>
				@if($ages_currentsoldgrower == [])
          No data available
        @else
          {{ round(array_sum($ages_currentsoldgrower)/count($ages_currentsoldgrower), 2) }}
        @endif
			</td>
			<td>
				@if($weights_currentsoldgrower == [])
          No data available
        @else
          {{ round(array_sum($weights_currentsoldgrower)/count($weights_currentsoldgrower), 2) }}
        @endif
			</td>
		</tr>
	</tbody>
</table>