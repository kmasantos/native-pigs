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
<h4 class="center">Monthly Performance Report for the year <strong>{{ Carbon\Carbon::parse($now)->format('Y') }}</strong></h4>
<table class="centered">
	<thead>
		<tr>
			<th>Month</th>
			<th style="color: #ff6384;">Bred</th>
			<th style="color: #36a2eb;">Farrowed</th>
			<th style="color: #ffce56;">Weaned</th>
		</tr>
	</thead>
	<tbody>
		@foreach($months as $month)
			<tr>
				<td>{{ $month }}</td>
				<td style="color: #ff6384;">{{ App\Http\Controllers\FarmController::getMonthlyBred($filter, $month) }}</td>
				<td style="color: #36a2eb;">{{ App\Http\Controllers\FarmController::getMonthlyFarrowed($filter, $month) }}</td>
				<td style="color: #ffce56;">{{ App\Http\Controllers\FarmController::getMonthlyWeaned($filter, $month) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<br><br><br><br><br>
<table class="centered">
	<thead>
		<tr>
			<th>Month</th>
			<th style="color: #ff6384;">Total Born Alive</th>
			<th style="color: #36a2eb;">Number of Males</th>
			<th style="color: #ffce56;">Number of Females</th>
			<th style="color: #4bc0c0;">Average Born Alive</th>
		</tr>
	</thead>
	<tbody>
		@foreach($months as $month)
			<tr>
				<td>{{ $month }}</td>
				<td style="color: #ff6384;">{{ App\Http\Controllers\FarmController::getMonthlyLSBA($filter, $month) }}</td>
				<td style="color: #36a2eb;">{{ App\Http\Controllers\FarmController::getMonthlyNumberMales($filter, $month) }}</td>
				<td style="color: #ffce56;">{{ App\Http\Controllers\FarmController::getMonthlyNumberFemales($filter, $month) }}</td>
				<td style="color: #4bc0c0;">{{ App\Http\Controllers\FarmController::getMonthlyAverageBorn($filter, $month) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<br><br><br><br><br><br><br><br><br><br><br>
<table class="centered">
	<thead>
		<tr>
			<th>Month</th>
			<th style="color: #ff6384;">Total Litter-size Weaned</th>
			<th style="color: #4bc0c0;">Average Weaned</th>
		</tr>
	</thead>
	<tbody>
		@foreach($months as $month)
			<tr>
				<td>{{ $month }}</td>
				<td style="color: #ff6384;">{{ App\Http\Controllers\FarmController::getMonthlyNumberWeaned($filter, $month) }}</td>
				<td style="color: #4bc0c0;">{{ App\Http\Controllers\FarmController::getMonthlyAverageWeaned($filter, $month) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<br><br><br><br><br><br><br><br><br><br><br>
<table class="centered">
	<thead>
		<tr>
			<th>Month</th>
			<th style="color: #ff6384;">Average Birth Weight</th>
			<th style="color: #4bc0c0;">Average Weaning Weight</th>
		</tr>
	</thead>
	<tbody>
		@foreach($months as $month)
			<tr>
				<td>{{ $month }}</td>
				<td style="color: #ff6384;">{{ App\Http\Controllers\FarmController::getMonthlyAverageBirthWeight($filter, $month) }}</td>
				<td style="color: #4bc0c0;">{{ App\Http\Controllers\FarmController::getMonthlyAverageWeaningWeight($filter, $month) }}</td>
			</tr>
		@endforeach
	</tbody>
</table>