@extends('layouts.swinedefault')

@section('title')
	Morphometric Characteristics Report
@endsection

@section('content')
	<div class="container">
		<h4>Morphometric Characteristics Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
      <div class="row">
      {!! Form::open(['route' => 'farm.pig.filter_morpho_chars_report', 'method' => 'post', 'id' => 'report_filter2']) !!}
        <div class="col s12">
          <h5 class="center">Data as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
        </div>
        <div class="col s4 offset-s1">
          <p>Generate Reports by:</p>
        </div>
        <div class="col s5">
          <select id="filter_keywords2" name="filter_keywords2" class="browser-default" onchange="document.getElementById('report_filter2').submit();">
            <option disabled selected>{{ $filter }}</option>
            <option value="Sow">Sow</option>
            <option value="Boar">Boar</option>
            <option value="All">All pigs</option>
          </select>
        </div>
        {!! Form::close() !!}
      </div>

      <div class="row">
        <div class="col s12">
          <ul class="tabs tabs-fixed-width green lighten-1">
            <li class="tab col s6"><a href="#herdview">Breeders</a></li>
            <li class="tab col s6"><a href="#yearofbirthview">Year of Birth</a></li>
          </ul>
        </div>
        <!-- HERD VIEW -->
        <div id="herdview" class="col s12" style="padding-top: 10px;">
          <div class="row center">
            <div class="col s12">
             @if($filter == "All")
                <p class="center">Total number of breeders: <strong>{{ count($alive) }}</strong></p>
              @elseif($filter == "Sow")
                <p class="center">Total number of sows: <strong>{{ count($sowsalive) }}</strong></p>
              @elseif($filter == "Boar")
                <p class="center">Total number of boars: <strong>{{ count($boarsalive) }}</strong></p>
              @endif
              @if($ages_collected != [])
                <p class="center">Average age during data collection: {{ round(array_sum($ages_collected)/count($ages_collected), 2) }} months</p>
              @else
                <p class="center">Average age during data collection: No data available</p>
              @endif
            </div>
          </div>
        	<table class="centered">
        		<thead class="green lighten-1">
        			<tr>
          			<th>Property</th>
                <th>Pigs with data</th>
          			<th>Minimum</th>
          			<th>Maximum</th>
          			<th>Average</th>
          			<th>Standard Deviation</th>
          		</tr>
        		</thead>
        		<tbody>
        			<tr>
        				<td>Ear Length, cm</td>
                @if($earlengths == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($earlengths) }}</td>
          				<td>{{ min($earlengths) }}</td>
          				<td>{{ max($earlengths) }}</td>
          				<td>{{ round((array_sum($earlengths)/count($earlengths)), 2) }}</td>
          				<td>{{ round($earlengths_sd, 2) }}</td>
                @endif
        			</tr>
        			<tr>
        				<td>Head Length, cm</td>
                @if($headlengths == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($headlengths) }}</td>
          				<td>{{ min($headlengths) }}</td>
          				<td>{{ max($headlengths) }}</td>
        					<td>{{ round((array_sum($headlengths)/count($headlengths)), 2) }}</td>
          				<td>{{ round($headlengths_sd, 2) }}</td>
                @endif
        			</tr>
        			<tr>
        				<td>Snout Length, cm</td>
                @if($snoutlengths == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($snoutlengths) }}</td>
          				<td>{{ min($snoutlengths) }}</td>
          				<td>{{ max($snoutlengths) }}</td>
          				<td>{{ round((array_sum($snoutlengths)/count($snoutlengths)), 2) }}</td>
          				<td>{{ round($snoutlengths_sd, 2) }}</td>
                @endif
        			</tr>
        			<tr>
        				<td>Body Length, cm</td>
                @if($bodylengths == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($bodylengths) }}</td>
          				<td>{{ min($bodylengths) }}</td>
          				<td>{{ max($bodylengths) }}</td>
          				<td>{{ round((array_sum($bodylengths)/count($bodylengths)), 2) }}</td>
          				<td>{{ round($bodylengths_sd, 2) }}</td>
                @endif
        			</tr>
        			<tr>
        				<td>Heart Girth, cm</td>
                @if($heartgirths == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($heartgirths) }}</td>
          				<td>{{ min($heartgirths) }}</td>
          				<td>{{ max($heartgirths) }}</td>
          				<td>{{ round((array_sum($heartgirths)/count($heartgirths)), 2) }}</td>
          				<td>{{ round($heartgirths_sd, 2) }}</td>
                @endif
        			</tr>
        			<tr>
        				<td>Pelvic Width, cm</td>
                @if($pelvicwidths == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($pelvicwidths) }}</td>
          				<td>{{ min($pelvicwidths) }}</td>
          				<td>{{ max($pelvicwidths) }}</td>
          				<td>{{ round((array_sum($pelvicwidths)/count($pelvicwidths)), 2) }}</td>
          				<td>{{ round($pelvicwidths_sd, 2) }}</td>
                @endif
        			</tr>
              <tr>
                <td>Ponderal Index, kg/m<sup>3</sup></td>
                @if($ponderalindices == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($ponderalindices) }}</td>
                  <td>{{ round(min($ponderalindices), 2) }}</td>
                  <td>{{ round(max($ponderalindices), 2) }}</td>
                  <td>{{ round((array_sum($ponderalindices)/count($ponderalindices)), 2) }}</td>
                  <td>{{ round($ponderalindices_sd, 2) }}</td>
                @endif
              </tr>
        			<tr>
        				<td>Tail Length, cm</td>
                @if($taillengths == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($taillengths) }}</td>
          				<td>{{ min($taillengths) }}</td>
          				<td>{{ max($taillengths) }}</td>
          				<td>{{ round((array_sum($taillengths)/count($taillengths)), 2) }}</td>
          				<td>{{ round($taillengths_sd, 2) }}</td>
                @endif
        			</tr>
        			<tr>
        				<td>Height at Withers, cm</td>
                @if($heightsatwithers == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($heightsatwithers) }}</td>
          				<td>{{ min($heightsatwithers) }}</td>
          				<td>{{ max($heightsatwithers) }}</td>
          				<td>{{ round((array_sum($heightsatwithers)/count($heightsatwithers)), 2) }}</td>
          				<td>{{ round($heightsatwithers_sd, 2) }}</td>
                @endif
        			</tr>
        			<tr>
        				<td>Number of Normal Teats</td>
                @if($normalteats == [])
                  <td colspan="5" class="center">No data available</td>
                @else
                  <td>{{ count($normalteats) }}</td>
          				<td>{{ min($normalteats) }}</td>
          				<td>{{ max($normalteats) }}</td>
          				<td>{{ round((array_sum($normalteats)/count($normalteats)), 2) }}</td>
          				<td>{{ round($normalteats_sd, 2) }}</td>
                @endif
        			</tr>
        		</tbody>
        	</table>
      	</div>
      </div>
      <!-- YEAR OF BIRTH VIEW -->
      <div id="yearofbirthview" class="col s12" style="padding-top: 10px;">
        <div class="row center">
          <div class="col s12">
           @if($filter == "All")
              <p class="center">Total number of pigs: <strong>{{ count($pigs) }}</strong> (Active: <strong>{{ count($alive) }}</strong>, Sold: <strong>{{ count($sold) }}</strong>, Dead: <strong>{{ count($dead) }}</strong>, Removed: <strong>{{ count($removed) }}</strong>)</p>
            @elseif($filter == "Sow")
              <p class="center">Total number of sows: <strong>{{ count($sows) }}</strong> (Active: <strong>{{ count($sowsalive) }}</strong>, Sold: <strong>{{ count($soldsows) }}</strong>, Dead: <strong>{{ count($deadsows) }}</strong>, Removed: <strong>{{ count($removedsows) }}</strong>)</p>
            @elseif($filter == "Boar")
              <p class="center">Total number of boars: <strong>{{ count($boars) }}</strong> (Active: <strong>{{ count($boarsalive) }}</strong>, Sold: <strong>{{ count($soldboars) }}</strong>, Dead: <strong>{{ count($deadboars) }}</strong>, Removed: <strong>{{ count($removedboars) }}</strong>)</p>
            @endif
            @if($ages_collected_all != [])
              <p class="center">Average age during data collection: {{ round(array_sum($ages_collected_all)/count($ages_collected_all), 2) }} months</p>
            @else
              <p class="center">Average age during data collection: No data available</p>
            @endif
          </div>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Ear Length, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 22, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 22, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 22, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 22, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 22, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 22, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 22, $filter), false), 2) }}</td>
                  @endif
                </tr>
              @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Head Length, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 23, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 23, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 23, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 23, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 23, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 23, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 23, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Snout Length, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 24, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 24, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 24, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 24, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 24, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 24, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 24, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Body Length, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 25, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 25, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 25, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 25, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 25, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 25, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 25, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Heart Girth, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 26, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 26, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 26, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 26, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 26, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 26, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 26, $filter), false), 2) }}</td>
                  @endif
                </tr>
              @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Pelvic Width, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 27, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 27, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 27, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 27, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 27, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 27, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 27, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Tail Length, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 28, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 28, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 28, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 28, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 28, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 28, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 28, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Height at Withers, cm</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 29, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 29, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 29, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 29, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 29, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 29, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 29, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Number of Normal Teats</p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 30, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 30, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 30, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 30, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 30, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 30, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 30, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="row center">
          <p class="green-text text-lighten-1">Ponderal Index, kg/m<sup>3</sup></p>
          <table class="centered">
            <thead>
              <tr>
                <th>Year</th>
                <th>Pigs with data</th>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 31, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 31, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ round(min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 31, $filter)), 4) }}</td>
                    <td>{{ round(max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 31, $filter)), 4) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 31, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 31, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 31, $filter), false), 2) }}</td>
                  @endif
                </tr>
               @empty
                <tr>
                  <td colspan="6">No data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
      $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false, // Close upon selecting a date,
        format: 'yyyy-mm-dd', 
        max: new Date()
      });
  </script>
@endsection