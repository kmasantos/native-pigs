@extends('layouts.swinedefault')

@section('title')
	Morphometric Characteristics Report
@endsection

@section('content')
	<div class="container">
		<h4>Morphometric Characteristics Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
  		<div class="col s12">
  			<p>Total number of pigs in the herd: {{ $pigcount }}</p>
  			<div class="row">
  				<div class="col s6">
  					<p>Total number of sows: {{ count($sows) }}</p>
  				</div>
  				<div class="col s6">
  					<p>Total number of boars: {{ count($boars) }}</p>
  				</div>
  			</div>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col s4 offset-s1">
  			<p>Generate Reports by:</p>
  		</div>
  		{!! Form::open(['route' => 'farm.pig.filter_morpho_chars_report', 'method' => 'post', 'id' => 'report_filter2']) !!}
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

  	<table>
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
  				<td>{{ min($earlengths) }}</td>
  				<td>{{ max($earlengths) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Head Length, cm</td>
  				<td>{{ min($headlengths) }}</td>
  				<td>{{ max($headlengths) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Snout Length, cm</td>
  				<td>{{ min($snoutlengths) }}</td>
  				<td>{{ max($snoutlengths) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Body Length, cm</td>
  				<td>{{ min($bodylengths) }}</td>
  				<td>{{ max($bodylengths) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Heart Girth, cm</td>
  				<td>{{ min($heartgirths) }}</td>
  				<td>{{ max($heartgirths) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Pelvic Width, cm</td>
  				<td>{{ min($pelvicwidths) }}</td>
  				<td>{{ max($pelvicwidths) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Tail Length, cm</td>
  				<td>{{ min($taillengths) }}</td>
  				<td>{{ max($taillengths) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Height at Withers, cm</td>
  				<td>{{ min($heightsatwithers) }}</td>
  				<td>{{ max($heightsatwithers) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  			<tr>
  				<td>Number of Normal Teats</td>
  				<td>{{ min($normalteats) }}</td>
  				<td>{{ max($normalteats) }}</td>
  				@if($filter == "Sow")
  					<td></td>
  				@elseif($filter == "Boar")
  					<td></td>
  				@elseif($filter == "All")
  					<td></td>
  				@endif
  				<td></td>
  			</tr>
  		</tbody>
  	</table>
	</div>
@endsection