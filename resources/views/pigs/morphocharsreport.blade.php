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

  	<table class="centered">
  		<thead>
  			<tr>
    			<th>Property</th>
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
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($earlengths) }}</td>
    				<td>{{ max($earlengths) }}</td>
    				<td>{{ round((array_sum($earlengths)/count($earlengths)), 4) }}</td>
    				<td>{{ round($earlengths_sd, 4) }}</td>
          @endif
  			</tr>
  			<tr>
  				<td>Head Length, cm</td>
          @if($headlengths == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($headlengths) }}</td>
    				<td>{{ max($headlengths) }}</td>
  					<td>{{ round((array_sum($headlengths)/count($headlengths)), 4) }}</td>
    				<td>{{ round($headlengths_sd, 4) }}</td>
          @endif
  			</tr>
  			<tr>
  				<td>Snout Length, cm</td>
          @if($snoutlengths == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($snoutlengths) }}</td>
    				<td>{{ max($snoutlengths) }}</td>
    				<td>{{ round((array_sum($snoutlengths)/count($snoutlengths)), 4) }}</td>
    				<td>{{ round($snoutlengths_sd, 4) }}</td>
          @endif
  			</tr>
  			<tr>
  				<td>Body Length, cm</td>
          @if($bodylengths == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($bodylengths) }}</td>
    				<td>{{ max($bodylengths) }}</td>
    				<td>{{ round((array_sum($bodylengths)/count($bodylengths)), 4) }}</td>
    				<td>{{ round($bodylengths_sd, 4) }}</td>
          @endif
  			</tr>
  			<tr>
  				<td>Heart Girth, cm</td>
          @if($heartgirths == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($heartgirths) }}</td>
    				<td>{{ max($heartgirths) }}</td>
    				<td>{{ round((array_sum($heartgirths)/count($heartgirths)), 4) }}</td>
    				<td>{{ round($heartgirths_sd, 4) }}</td>
          @endif
  			</tr>
  			<tr>
  				<td>Pelvic Width, cm</td>
          @if($pelvicwidths == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($pelvicwidths) }}</td>
    				<td>{{ max($pelvicwidths) }}</td>
    				<td>{{ round((array_sum($pelvicwidths)/count($pelvicwidths)), 4) }}</td>
    				<td>{{ round($pelvicwidths_sd, 4) }}</td>
          @endif
  			</tr>
        <tr>
          <td>Ponderal Index, kg/m<sup>3</sup></td>
          @if($ponderalindices == [])
            <td colspan="4" class="center">No data available</td>
          @else
            <td>{{ round(min($ponderalindices), 2) }}</td>
            <td>{{ round(max($ponderalindices), 2) }}</td>
            <td>{{ round((array_sum($ponderalindices)/count($ponderalindices)), 4) }}</td>
            <td>{{ round($ponderalindices_sd, 4) }}</td>
          @endif
        </tr>
  			<tr>
  				<td>Tail Length, cm</td>
          @if($taillengths == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($taillengths) }}</td>
    				<td>{{ max($taillengths) }}</td>
    				<td>{{ round((array_sum($taillengths)/count($taillengths)), 4) }}</td>
    				<td>{{ round($taillengths_sd, 4) }}</td>
          @endif
  			</tr>
  			<tr>
  				<td>Height at Withers, cm</td>
          @if($heightsatwithers == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($heightsatwithers) }}</td>
    				<td>{{ max($heightsatwithers) }}</td>
    				<td>{{ round((array_sum($heightsatwithers)/count($heightsatwithers)), 4) }}</td>
    				<td>{{ round($heightsatwithers_sd, 4) }}</td>
          @endif
  			</tr>
  			<tr>
  				<td>Number of Normal Teats</td>
          @if($normalteats == [])
            <td colspan="4" class="center">No data available</td>
          @else
    				<td>{{ min($normalteats) }}</td>
    				<td>{{ max($normalteats) }}</td>
    				<td>{{ round((array_sum($normalteats)/count($normalteats)), 4) }}</td>
    				<td>{{ round($normalteats_sd, 4) }}</td>
          @endif
  			</tr>
  		</tbody>
  	</table>
	</div>
@endsection