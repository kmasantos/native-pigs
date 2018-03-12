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
  				<td>Ear Length</td>
  				<td>{{ min($earlengths) }} cm</td>
  				<td>{{ max($earlengths) }} cm</td>
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
  				<td>Head Length</td>
  				<td>{{ min($headlengths) }} cm</td>
  				<td>{{ max($headlengths) }} cm</td>
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
  				<td>Snout Length</td>
  				<td>{{ min($snoutlengths) }} cm</td>
  				<td>{{ max($snoutlengths) }} cm</td>
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
  				<td>Body Length</td>
  				<td>{{ min($bodylengths) }} cm</td>
  				<td>{{ max($bodylengths) }} cm</td>
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
  				<td>Heart Girth</td>
  				<td>{{ min($heartgirths) }} cm</td>
  				<td>{{ max($heartgirths) }} cm</td>
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
  				<td>Pelvic Width</td>
  				<td>{{ min($pelvicwidths) }} cm</td>
  				<td>{{ max($pelvicwidths) }} cm</td>
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
  				<td>Tail Length</td>
  				<td>{{ min($taillengths) }} cm</td>
  				<td>{{ max($taillengths) }} cm</td>
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
  				<td>Height at Withers</td>
  				<td>{{ min($heightsatwithers) }} cm</td>
  				<td>{{ max($heightsatwithers) }} cm</td>
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