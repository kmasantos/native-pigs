@extends('layouts.swinedefault')

@section('title')
	Morphometric Characteristics Report
@endsection

@section('content')
	<div class="container">
		<h4>Morphometric Characteristics Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
      {!! Form::open(['route' => 'farm.pig.filter_morpho_chars_report', 'method' => 'post', 'id' => 'report_filter2']) !!}
      <div class="col s12">
        @if($filter == "All")
          <p class="center">Total number of pigs in the herd: {{ count($pigs) }}</p>
        @elseif($filter == "Sow")
          <p class="center">Total number of sows in the herd: {{ count($sows) }}</p>
        @elseif($filter == "Boar")
          <p class="center">Total number of boars in the herd: {{ count($boars) }}</p>
        @endif
      </div>
      <div class="row">
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
            <li class="tab col s6"><a href="#herdview">Herd</a></li>
            <li class="tab col s6"><a href="#yearofbirthview">Year of Birth</a></li>
          </ul>
        </div>
        <!-- HERD VIEW -->
        <div id="herdview" class="col s12">
        	<table class="centered">
        		<thead>
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
      <div id="yearofbirthview" class="col s12">
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 64, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 64, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 64, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 64, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 64, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 64, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 64, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 39, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 39, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 39, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 39, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 39, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 39, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 39, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 63, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 63, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 63, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 63, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 63, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 63, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 63, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 40, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 40, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 40, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 40, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 40, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 40, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 40, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 42, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 42, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 42, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 42, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 42, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 42, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 42, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 41, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 41, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 41, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 41, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 41, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 41, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 41, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 43, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 43, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ round(min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 43, $filter)), 4) }}</td>
                    <td>{{ round(max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 43, $filter)), 4) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 43, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 43, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 43, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 65, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 65, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 65, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 65, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 65, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 65, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 65, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 66, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 66, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 66, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 66, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 66, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 66, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 66, $filter), false), 2) }}</td>
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
                  <td>{{ count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 44, $filter)) }}</td>
                  @if(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 44, $filter) == [])
                    <td colspan="4" class="center">No data available</td>
                  @else
                    <td>{{ min(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 44, $filter)) }}</td>
                    <td>{{ max(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 44, $filter)) }}</td>
                    <td>{{ round(array_sum(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 44, $filter))/count(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 44, $filter)), 2) }}</td>
                    <td>{{ round(App\Http\Controllers\FarmController::standardDeviation(App\Http\Controllers\FarmController::getMorphometricCharacteristicsPerYearOfBirth($year, 44, $filter), false), 2) }}</td>
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