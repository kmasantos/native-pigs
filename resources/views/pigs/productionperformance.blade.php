@extends('layouts.swinedefault')

@section('title')
	Production Performance Report
@endsection

@section('content')
	<div class="container">
		<h4>Production Performance Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12">
	      <ul class="tabs tabs-fixed-width green lighten-1">
	        <li class="tab"><a href="#persowview">Per sow</a></li>
	        <li class="tab"><a href="#perboarview">Per boar</a></li>
	        <li class="tab"><a href="#perparityview">Per parity</a></li>
	        <li class="tab"><a href="#permonthview">Per month</a></li>
	        <li class="tab"><a href="#perbreedview">Per breed</a></li>
	      </ul>
	    </div>
	    <!-- PER SOW -->
	    <div id="persowview" class="col s12">	    	
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Registration ID</th>
	    				<th class="center">View Production Performance</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			@foreach($sowbreeders as $sowbreeder)
		    			<tr>
		    				<td>{{ $sowbreeder->registryid }}</td>
		    				<td class="center"><a href="{{ URL::route('farm.pig.sow_production_performance', [$sowbreeder->id]) }}"><i class="material-icons">visibility</i></a></td>
		    			</tr>
		    		@endforeach
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER BOAR -->
	    <div id="perboarview" class="col s12">
	    	<table>
	    		<thead>
	    			<tr>
	    				<th>Registration ID</th>
	    				<th class="center">View Production Performance</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			@foreach($boarbreeders as $boarbreeder)
		    			<tr>
		    				<td>{{ $boarbreeder->registryid }}</td>
		    				<td class="center"><a href="{{ URL::route('farm.pig.boar_production_performance', [$boarbreeder->id]) }}"><i class="material-icons">visibility</i></a></td>
		    			</tr>
		    		@endforeach
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER PARITY -->
	    <div id="perparityview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Generate Reports by:</p>
		  		</div>
	    		<div class="col s5">
	    		{{-- {!! Form::open(['route' => 'farm.pig.filter_production_performance_per_parity', 'method' => 'post', 'id' => 'report_filter']) !!} --}}
						<select id="filter_parity" name="filter_parity" class="browser-default" {{-- onchange="document.getElementById('report_filter').submit();" --}}>
							<option disabled selected>Parity</option>
							@foreach($parity as $parity)
								<option value="{{ $parity }}">{{ $parity }}</option>
							@endforeach
						</select>
					</div>
	    	{{-- {!! Form::close() !!} --}}
	    	</div>
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER MONTH -->
	    <div id="permonthview" class="col s12">
	    	<div class="row" style="padding-top: 10px;">
		    	<div class="col s4 offset-s1">
		  			<p>Generate Reports within:</p>
		  		</div>
		  		{{-- {!! Form::open(['route' => 'farm.pig.filter_production_performance_per_month', 'method' => 'post', 'id' => 'report_filter2']) !!} --}}
	    		<div class="col s2">
						<input id="start_date" type="text" class="datepicker" name="start_date" placeholder="Start date">
					</div>
					<div class="col s2">
						<input id="end_date" type="text" class="datepicker" name="end_date" placeholder="End date">
					</div>
	    		{{-- {!! Form::close() !!} --}}
	    	</div>
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
	    <!-- PER BREED -->
	    <div id="perbreedview" class="col s12">
	    	<table>
	    		<tbody>
	    			<tr>
	    				<td>Litter-size Born Alive</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Male Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Female Born</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Birth Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Stillborn</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Mummified</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Litter Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Average Weaning Weight</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Adjusted Weaning Weight at 45 Days</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Number Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Age Weaned</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>Pre-weaning Mortality</td>
	    				<td></td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </div>
		</div>
	</div>
@endsection