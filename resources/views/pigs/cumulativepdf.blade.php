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
<h4 class="center">Cumulative Performance Report for the year <strong>{{ $filter }}</strong></h4>
<table>
  <thead>
    <tr>
      <th rowspan="2">Parameters</th>
      <th class="center" colspan="{{ count($headings) }}">Months</th>
      <th class="center" rowspan="2">Average &plusmn; SD</th>
    </tr>
    <tr>
      @foreach($headings as $heading)
        <th class="center">{{ $heading->format('F') }}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Litter-size Born Alive</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][0] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][0])/count($monthlyperformances[$heading->month - 1][0]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_lsba != [])
        <td class="center">{{ round(array_sum($all_lsba)/count($all_lsba), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_lsba, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Number Male Born</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][1] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][1])/count($monthlyperformances[$heading->month - 1][1]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_numbermales != [])
        <td class="center">{{ round(array_sum($all_numbermales)/count($all_numbermales), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_numbermales, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Number Female Born</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][2] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][2])/count($monthlyperformances[$heading->month - 1][2]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_numberfemales != [])
        <td class="center">{{ round(array_sum($all_numberfemales)/count($all_numberfemales), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_numberfemales, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Number Stillborn</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][3] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][3])/count($monthlyperformances[$heading->month - 1][3]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_stillborn != [])
        <td class="center">{{ round(array_sum($all_stillborn)/count($all_stillborn), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_stillborn, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Number Mummified</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][4] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][4])/count($monthlyperformances[$heading->month - 1][4]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_mummified != [])
        <td class="center">{{ round(array_sum($all_mummified)/count($all_mummified), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_mummified, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Litter Birth Weight, kg</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][5] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][5])/count($monthlyperformances[$heading->month - 1][5]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_litterbirthweights != [])
        <td class="center">{{ round(array_sum($all_litterbirthweights)/count($all_litterbirthweights), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_litterbirthweights, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Average Birth Weight, kg</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][6] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][6])/count($monthlyperformances[$heading->month - 1][6]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_avebirthweights != [])
        <td class="center">{{ round(array_sum($all_avebirthweights)/count($all_avebirthweights), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_avebirthweights, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Litter Weaning Weight, kg</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][7] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][7])/count($monthlyperformances[$heading->month - 1][7]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_litterweaningweights != [])
        <td class="center">{{ round(array_sum($all_litterweaningweights)/count($all_litterweaningweights), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_litterweaningweights, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Average Weaning Weight, kg</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][8] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][8])/count($monthlyperformances[$heading->month - 1][8]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_aveweaningweights != [])
        <td class="center">{{ round(array_sum($all_aveweaningweights)/count($all_aveweaningweights), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_aveweaningweights, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Adjusted Weaning Weight at 45 Days, kg</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][9] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][9])/count($monthlyperformances[$heading->month - 1][9]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_adjweaningweights != [])
        <td class="center">{{ round(array_sum($all_adjweaningweights)/count($all_adjweaningweights), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_adjweaningweights, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Number Weaned</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][10] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][10])/count($monthlyperformances[$heading->month - 1][10]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_numberweaned != [])
        <td class="center">{{ round(array_sum($all_numberweaned)/count($all_numberweaned), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_numberweaned, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Age Weaned, days</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][11] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][11])/count($monthlyperformances[$heading->month - 1][11]), 4) }}</td>
          @endif
        @endif
      @endforeach
      @if($all_agesweaned != [])
        <td class="center">{{ round(array_sum($all_agesweaned)/count($all_agesweaned), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_agesweaned, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
    <tr>
      <td>Pre-weaning Mortality, %</td>
      @foreach($headings as $heading)
        @if(!array_key_exists($heading->month - 1, $monthlyperformances))
          <td class="center">No data available</td>
        @else
          @if($monthlyperformances[$heading->month - 1][12] == [])
            <td class="center">No data available</td>
          @else
            <td class="center">{{ round(array_sum($monthlyperformances[$heading->month - 1][12])/count($monthlyperformances[$heading->month - 1][12]), 4) }}</td>
          @endif
        @endif
      @endforeach
     @if($all_preweaningmortality != [])
        <td class="center">{{ round(array_sum($all_preweaningmortality)/count($all_preweaningmortality), 4) }} &plusmn; {{ round(App\Http\Controllers\FarmController::standardDeviation($all_preweaningmortality, false), 4) }}</td>
      @else
        <td class="center">No data available</td>
      @endif
    </tr>
  </tbody>
</table>