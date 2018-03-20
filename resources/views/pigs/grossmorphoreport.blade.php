@extends('layouts.swinedefault')

@section('title')
	Gross Morphology Report
@endsection

@section('content')
	<div class="container">
		<h4>Gross Morphology Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			{!! Form::open(['route' => 'farm.pig.filter_gross_morphology_report', 'method' => 'post', 'id' => 'report_filter']) !!}
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
					<select id="filter_keywords" name="filter_keywords" class="browser-default" onchange="document.getElementById('report_filter').submit();">
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
	      <ul class="tabs">
	        <li class="tab col s2 offset-s4"><a href="#tableview"><i class="material-icons">border_all</i></a></li>
	        <li class="tab col s2"><a href="#chartview"><i class="material-icons">pie_chart</i></a></li>
	      </ul>
	    </div>
	    <!-- TABLE -->
	    <div id="tableview" class="col s12">
	    	<table>
		  		<thead>
		  			<tr>
		  				<th>Property</th>
		  				<th colspan="4" class="center">Values</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			<tr>
		  				<td>Hair Type</td>
		  				@if($curlyhairs == [] && $straighthairs == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Curly: {{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($sows))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighthairs) }} ({{ round((count($straighthairs)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($curlyhairs)+count($straighthairs))) }} ({{ round(((count($sows)-(count($curlyhairs)+count($straighthairs)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Curly: {{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighthairs) }} ({{ round((count($straighthairs)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($curlyhairs)+count($straighthairs))) }} ({{ round(((count($boars)-(count($curlyhairs)+count($straighthairs)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Curly: {{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighthairs) }} ({{ round((count($straighthairs)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($curlyhairs)+count($straighthairs))) }} ({{ round(((count($pigs)-(count($curlyhairs)+count($straighthairs)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  			<tr>
		  				<td>Hair Length</td>
		  				@if($shorthairs == [] && $longhairs == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Short: {{ count($shorthairs) }} ({{ round((count($shorthairs)/count($sows))*100, 2) }}%)</td>
			    				<td>Long: {{ count($longhairs) }} ({{ round((count($longhairs)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($shorthairs)+count($longhairs))) }} ({{ round(((count($sows)-(count($shorthairs)+count($longhairs)))/count($sows))*100, 2) }}%)</td>
		    				@elseif($filter == "Boar")
		    					<td>Short: {{ count($shorthairs) }} ({{ round((count($shorthairs)/count($boars))*100, 2) }}%)</td>
			    				<td>Long: {{ count($longhairs) }} ({{ round((count($longhairs)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($shorthairs)+count($longhairs))) }} ({{ round(((count($boars)-(count($shorthairs)+count($longhairs)))/count($boars))*100, 2) }}%)</td>
		    				@elseif($filter == "All")
		    					<td>Short: {{ count($shorthairs) }} ({{ round((count($shorthairs)/count($pigs))*100, 2) }}%)</td>
			    				<td>Long: {{ count($longhairs) }} ({{ round((count($longhairs)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($shorthairs)+count($longhairs))) }} ({{ round(((count($pigs)-(count($shorthairs)+count($longhairs)))/count($pigs))*100, 2) }}%)</td>
		    				@endif
			    		@endif
		  			</tr>
		  			<tr>
		  				<td>Coat Color</td>
		  				@if($blackcoats == [] && $nonblackcoats == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Black: {{ count($blackcoats) }} ({{ round((count($blackcoats)/count($sows))*100, 2) }}%)</td>
			    				<td>Others: {{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($blackcoats)+count($nonblackcoats))) }} ({{ round(((count($sows)-(count($blackcoats)+count($nonblackcoats)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Black: {{ count($blackcoats) }} ({{ round((count($blackcoats)/count($boars))*100, 2) }}%)</td>
			    				<td>Others: {{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($blackcoats)+count($nonblackcoats))) }} ({{ round(((count($boars)-(count($blackcoats)+count($nonblackcoats)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Black: {{ count($blackcoats) }} ({{ round((count($blackcoats)/count($pigs))*100, 2) }}%)</td>
			    				<td>Others: {{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($blackcoats)+count($nonblackcoats))) }} ({{ round(((count($pigs)-(count($blackcoats)+count($nonblackcoats)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  			<tr>
		  				<td>Color Pattern</td>
		  				@if($plains == [] && $socks == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Plain: {{ count($plains) }} ({{ round((count($plains)/count($sows))*100, 2) }}%)</td>
			    				<td>Socks: {{ count($socks) }} ({{ round((count($socks)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($plains)+count($socks))) }} ({{ round(((count($sows)-(count($plains)+count($socks)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Plain: {{ count($plains) }} ({{ round((count($plains)/count($boars))*100, 2) }}%)</td>
			    				<td>Socks: {{ count($socks) }} ({{ round((count($socks)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($plains)+count($socks))) }} ({{ round(((count($boars)-(count($plains)+count($socks)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Plain: {{ count($plains) }} ({{ round((count($plains)/count($pigs))*100, 2) }}%)</td>
			    				<td>Socks: {{ count($socks) }} ({{ round((count($socks)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($plains)+count($socks))) }} ({{ round(((count($pigs)-(count($plains)+count($socks)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  			<tr>
		  				<td>Head Shape</td>
		  				@if($concaves == [] && $straightheads == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Concave: {{ count($concaves) }} ({{ round((count($concaves)/count($sows))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightheads) }} ({{ round((count($straightheads)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($concaves)+count($straightheads))) }} ({{ round(((count($sows)-(count($concaves)+count($straightheads)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Concave: {{ count($concaves) }} ({{ round((count($concaves)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightheads) }} ({{ round((count($straightheads)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($concaves)+count($straightheads))) }} ({{ round(((count($boars)-(count($concaves)+count($straightheads)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Concave: {{ count($concaves) }} ({{ round((count($concaves)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightheads) }} ({{ round((count($straightheads)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($concaves)+count($straightheads))) }} ({{ round(((count($pigs)-(count($concaves)+count($straightheads)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  			<tr>
		  				<td>Skin Type</td>
		  				@if($smooths == [] && $wrinkleds == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Smooth: {{ count($smooths) }} ({{ round((count($smooths)/count($sows))*100, 2) }}%)</td>
			    				<td>Wrinkled: {{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($smooths)+count($wrinkleds))) }} ({{ round(((count($sows)-(count($smooths)+count($wrinkleds)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Smooth: {{ count($smooths) }} ({{ round((count($smooths)/count($boars))*100, 2) }}%)</td>
			    				<td>Wrinkled: {{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($smooths)+count($wrinkleds))) }} ({{ round(((count($boars)-(count($smooths)+count($wrinkleds)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Smooth: {{ count($smooths) }} ({{ round((count($smooths)/count($pigs))*100, 2) }}%)</td>
			    				<td>Wrinkled: {{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($smooths)+count($wrinkleds))) }} ({{ round(((count($pigs)-(count($smooths)+count($wrinkleds)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
		  				@endif
		  			</tr>
		  			<tr>
		  				<td>Ear Type</td>
		  				@if($droopingears == [] && $semilops == [] && $erectears == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Drooping: {{ count($droopingears) }} ({{ round((count($droopingears)/count($sows))*100, 2) }}%)</td>
			    				<td>Semi-lop: {{ count($semilops) }} ({{ round((count($semilops)/count($sows))*100, 2) }}%)</td>
			    				<td>Erect: {{ count($erectears) }} ({{ round((count($erectears)/count($sows))*100, 2) }}%)</td>
			    				<td>No Record: {{ (count($sows)-(count($droopingears)+count($semilops)+count($erectears))) }} ({{ round(((count($sows)-(count($droopingears)+count($semilops)+count($erectears)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Drooping: {{ count($droopingears) }} ({{ round((count($droopingears)/count($boars))*100, 2) }}%)</td>
			    				<td>Semi-lop: {{ count($semilops) }} ({{ round((count($semilops)/count($boars))*100, 2) }}%)</td>
			    				<td>Erect: {{ count($erectears) }} ({{ round((count($erectears)/count($boars))*100, 2) }}%)</td>
			    				<td>No Record: {{ (count($boars)-(count($droopingears)+count($semilops)+count($erectears))) }} ({{ round(((count($boars)-(count($droopingears)+count($semilops)+count($erectears)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Drooping: {{ count($droopingears) }} ({{ round((count($droopingears)/count($pigs))*100, 2) }}%)</td>
			    				<td>Semi-lop: {{ count($semilops) }} ({{ round((count($semilops)/count($pigs))*100, 2) }}%)</td>
			    				<td>Erect: {{ count($erectears) }} ({{ round((count($erectears)/count($pigs))*100, 2) }}%)</td>
			    				<td>No Record: {{ (count($pigs)-(count($droopingears)+count($semilops)+count($erectears))) }} ({{ round(((count($pigs)-(count($droopingears)+count($semilops)+count($erectears)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  			<tr>
		  				<td>Tail Type</td>
		  				@if($curlytails == [] && $straighttails == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Curly: {{ count($curlytails) }} ({{ round((count($curlytails)/count($sows))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighttails) }} ({{ round((count($straighttails)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($curlytails)+count($straighttails))) }} ({{ round(((count($sows)-(count($curlytails)+count($straighttails)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Curly: {{ count($curlytails) }} ({{ round((count($curlytails)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighttails) }} ({{ round((count($straighttails)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($curlytails)+count($straighttails))) }} ({{ round(((count($boars)-(count($curlytails)+count($straighttails)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Curly: {{ count($curlytails) }} ({{ round((count($curlytails)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighttails) }} ({{ round((count($straighttails)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($curlytails)+count($straighttails))) }} ({{ round(((count($pigs)-(count($curlytails)+count($straighttails)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  			<tr>
		  				<td>Backline</td>
		  				@if($swaybacks == [] && $straightbacks == [])
		  					<td colspan="4" class="center">No data available</td>
		  				@else
		  					@if($filter == "Sow")
			    				<td>Swayback: {{ count($swaybacks) }} ({{ round((count($swaybacks)/count($sows))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightbacks) }} ({{ round((count($straightbacks)/count($sows))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($sows)-(count($swaybacks)+count($straightbacks))) }} ({{ round(((count($sows)-(count($swaybacks)+count($straightbacks)))/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Swayback: {{ count($swaybacks) }} ({{ round((count($swaybacks)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightbacks) }} ({{ round((count($straightbacks)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($boars)-(count($swaybacks)+count($straightbacks))) }} ({{ round(((count($boars)-(count($swaybacks)+count($straightbacks)))/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Swayback: {{ count($swaybacks) }} ({{ round((count($swaybacks)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightbacks) }} ({{ round((count($straightbacks)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ (count($pigs)-(count($swaybacks)+count($straightbacks))) }} ({{ round(((count($pigs)-(count($swaybacks)+count($straightbacks)))/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  		</tbody>
		  	</table>
	    </div>
	    <!-- PIE CHARTS -->
	    <div id="chartview" class="col s12">

	    </div>
	  </div>
  </div>
@endsection