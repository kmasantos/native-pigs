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
<h4 class="center">Grower Inventory Report for the year <strong>{{ Carbon\Carbon::parse($now)->format('Y') }}</strong></h4>
<table class="centered">
	<thead>
		<tr>
			<th rowspan="3">Month</th>
			<th colspan="16">Age, months</th>
		</tr>
		<tr>
			<th colspan="2">0</th>
			<th colspan="2">1</th>
			<th colspan="2">2</th>
			<th colspan="2">3</th>
			<th colspan="2">4</th>
			<th colspan="2">5</th>
			<th colspan="2">6</th>
			<th colspan="2">>6</th>
		</tr>
		<tr>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
			<th style="color: #ff6384;">Female</th>
			<th style="color: #4bc0c0;">Male</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>January</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[0][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[0][7] }}</td>
		</tr>
		<tr>
			<td>February</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[1][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[1][7] }}</td>
		</tr>
		<tr>
			<td>March</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[2][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[2][7] }}</td>
		</tr>
		<tr>
			<td>April</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[3][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[3][7] }}</td>
		</tr>
		<tr>
			<td>May</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[4][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[4][7] }}</td>
		</tr>
		<tr>
			<td>June</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[5][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[5][7] }}</td>
		</tr>
		<tr>
			<td>July</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[6][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[6][7] }}</td>
		</tr>
		<tr>
			<td>August</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[7][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[7][7] }}</td>
		</tr>
		<tr>
			<td>September</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[8][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[8][7] }}</td>
		</tr>
		<tr>
			<td>October</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[9][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[9][7] }}</td>
		</tr>
		<tr>
			<td>November</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[10][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[10][7] }}</td>
		</tr>
		<tr>
			<td>December</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][0] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][0] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][1] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][1] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][2] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][2] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][3] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][3] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][4] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][4] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][5] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][5] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][6] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][6] }}</td>
			<td style="color: #ff6384;">{{ $monthlysows[11][7] }}</td>
			<td style="color: #4bc0c0;">{{ $monthlyboars[11][7] }}</td>
		</tr>
	</tbody>
</table>