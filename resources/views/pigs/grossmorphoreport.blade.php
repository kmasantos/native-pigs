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
			    				<td colspan="2" class="center">No Record: {{ $nohairtypes }} ({{ round(($nohairtypes/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Curly: {{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighthairs) }} ({{ round((count($straighthairs)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nohairtypes }} ({{ round(($nohairtypes/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Curly: {{ count($curlyhairs) }} ({{ round((count($curlyhairs)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighthairs) }} ({{ round((count($straighthairs)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nohairtypes }} ({{ round(($nohairtypes/count($pigs))*100, 2) }}%)</td>
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
			    				<td colspan="2" class="center">No Record: {{ $nohairlengths }} ({{ round(($nohairlengths/count($sows))*100, 2) }}%)</td>
		    				@elseif($filter == "Boar")
		    					<td>Short: {{ count($shorthairs) }} ({{ round((count($shorthairs)/count($boars))*100, 2) }}%)</td>
			    				<td>Long: {{ count($longhairs) }} ({{ round((count($longhairs)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nohairlengths }} ({{ round(($nohairlengths/count($boars))*100, 2) }}%)</td>
		    				@elseif($filter == "All")
		    					<td>Short: {{ count($shorthairs) }} ({{ round((count($shorthairs)/count($pigs))*100, 2) }}%)</td>
			    				<td>Long: {{ count($longhairs) }} ({{ round((count($longhairs)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nohairlengths }} ({{ round(($nohairlengths/count($pigs))*100, 2) }}%)</td>
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
			    				<td colspan="2" class="center">No Record: {{ $nocoats }} ({{ round(($nocoats/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Black: {{ count($blackcoats) }} ({{ round((count($blackcoats)/count($boars))*100, 2) }}%)</td>
			    				<td>Others: {{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nocoats }} ({{ round(($nocoats/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Black: {{ count($blackcoats) }} ({{ round((count($blackcoats)/count($pigs))*100, 2) }}%)</td>
			    				<td>Others: {{ count($nonblackcoats) }} ({{ round((count($nonblackcoats)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nocoats }} ({{ round(($nocoats/count($pigs))*100, 2) }}%)</td>
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
			    				<td colspan="2" class="center">No Record: {{ $nopatterns }} ({{ round(($nopatterns/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Plain: {{ count($plains) }} ({{ round((count($plains)/count($boars))*100, 2) }}%)</td>
			    				<td>Socks: {{ count($socks) }} ({{ round((count($socks)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nopatterns }} ({{ round(($nopatterns/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Plain: {{ count($plains) }} ({{ round((count($plains)/count($pigs))*100, 2) }}%)</td>
			    				<td>Socks: {{ count($socks) }} ({{ round((count($socks)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nopatterns }} ({{ round(($nopatterns/count($pigs))*100, 2) }}%)</td>
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
			    				<td colspan="2" class="center">No Record: {{ $noheadshapes }} ({{ round(($noheadshapes/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Concave: {{ count($concaves) }} ({{ round((count($concaves)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightheads) }} ({{ round((count($straightheads)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $noheadshapes }} ({{ round(($noheadshapes/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Concave: {{ count($concaves) }} ({{ round((count($concaves)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightheads) }} ({{ round((count($straightheads)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $noheadshapes }} ({{ round(($noheadshapes/count($pigs))*100, 2) }}%)</td>
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
			    				<td colspan="2" class="center">No Record: {{ $noskintypes }} ({{ round(($noskintypes/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Smooth: {{ count($smooths) }} ({{ round((count($smooths)/count($boars))*100, 2) }}%)</td>
			    				<td>Wrinkled: {{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $noskintypes }} ({{ round(($noskintypes/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Smooth: {{ count($smooths) }} ({{ round((count($smooths)/count($pigs))*100, 2) }}%)</td>
			    				<td>Wrinkled: {{ count($wrinkleds) }} ({{ round((count($wrinkleds)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $noskintypes }} ({{ round(($noskintypes/count($pigs))*100, 2) }}%)</td>
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
			    				<td>No Record: {{ $noeartypes }} ({{ round(($noeartypes/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Drooping: {{ count($droopingears) }} ({{ round((count($droopingears)/count($boars))*100, 2) }}%)</td>
			    				<td>Semi-lop: {{ count($semilops) }} ({{ round((count($semilops)/count($boars))*100, 2) }}%)</td>
			    				<td>Erect: {{ count($erectears) }} ({{ round((count($erectears)/count($boars))*100, 2) }}%)</td>
			    				<td>No Record: {{ $noeartypes }} ({{ round(($noeartypes/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Drooping: {{ count($droopingears) }} ({{ round((count($droopingears)/count($pigs))*100, 2) }}%)</td>
			    				<td>Semi-lop: {{ count($semilops) }} ({{ round((count($semilops)/count($pigs))*100, 2) }}%)</td>
			    				<td>Erect: {{ count($erectears) }} ({{ round((count($erectears)/count($pigs))*100, 2) }}%)</td>
			    				<td>No Record: {{ $noeartypes }} ({{ round(($noeartypes/count($pigs))*100, 2) }}%)</td>
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
			    				<td colspan="2" class="center">No Record: {{ $notailtypes }} ({{ round(($notailtypes/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Curly: {{ count($curlytails) }} ({{ round((count($curlytails)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighttails) }} ({{ round((count($straighttails)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $notailtypes }} ({{ round(($notailtypes/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Curly: {{ count($curlytails) }} ({{ round((count($curlytails)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straighttails) }} ({{ round((count($straighttails)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $notailtypes }} ({{ round(($notailtypes/count($pigs))*100, 2) }}%)</td>
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
			    				<td colspan="2" class="center">No Record: {{ $nobacklines }} ({{ round(($nobacklines/count($sows))*100, 2) }}%)</td>
			    			@elseif($filter == "Boar")
			    				<td>Swayback: {{ count($swaybacks) }} ({{ round((count($swaybacks)/count($boars))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightbacks) }} ({{ round((count($straightbacks)/count($boars))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nobacklines }} ({{ round(($nobacklines/count($boars))*100, 2) }}%)</td>
			    			@elseif($filter == "All")
			    				<td>Swayback: {{ count($swaybacks) }} ({{ round((count($swaybacks)/count($pigs))*100, 2) }}%)</td>
			    				<td>Straight: {{ count($straightbacks) }} ({{ round((count($straightbacks)/count($pigs))*100, 2) }}%)</td>
			    				<td colspan="2" class="center">No Record: {{ $nobacklines }} ({{ round(($nobacklines/count($pigs))*100, 2) }}%)</td>
			    			@endif
			    		@endif
		  			</tr>
		  		</tbody>
		  	</table>
	    </div>
	    <!-- PIE CHARTS -->
	    <div id="chartview" class="col s12">
	    	<div class="row center">
	    		<div class="col s6">
	    			<p>Hair Type</p>
	    			<canvas id="hairtypecanvas"></canvas>
	    		</div>
	    		<div class="col s6">
	    			<p>Hair Length</p>
	    			<canvas id="hairlengthcanvas"></canvas>
	    		</div>
	    	</div>
	    	<div class="row center">
	    		<div class="col s6">
	    			<p>Coat Color</p>
	    			<canvas id="coatcolorcanvas"></canvas>
	    		</div>
	    		<div class="col s6">
	    			<p>Color Pattern</p>
	    			<canvas id="colorpatterncanvas"></canvas>
	    		</div>
	    	</div>
	    	<div class="row center">
	    		<div class="col s6">
	    			<p>Head Shape</p>
	    			<canvas id="headshapecanvas"></canvas>
	    		</div>
	    		<div class="col s6">
	    			<p>Skin Type</p>
	    			<canvas id="skintypecanvas"></canvas>
	    		</div>
	    	</div>
	    	<div class="row center">
	    		<div class="col s6">
	    			<p>Ear Type</p>
	    			<canvas id="eartypecanvas"></canvas>
	    		</div>
	    		<div class="col s6">
	    			<p>Tail Type</p>
	    			<canvas id="tailtypecanvas"></canvas>
	    		</div>
	    	</div>
	    	<div class="row center">
	    		<div class="col s6 offset-s3">
	    			<p>Backline</p>
	    			<canvas id="backlinecanvas"></canvas>
	    		</div>
	    	</div>
	    </div>
	  </div>
  </div>
@endsection

@section('scripts')
	<script>
		var ctx1 = document.getElementById("hairtypecanvas").getContext('2d');
		var hairtypechart = new Chart(ctx1, {
	    type: 'pie',
	    data: {
        labels: ["Curly", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Type',
          data: [{{ count($curlyhairs) }}, {{ count($straighthairs) }}, {{ $nohairtypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx2 = document.getElementById("hairlengthcanvas").getContext('2d');
		var hairlengthchart = new Chart(ctx2, {
			type: 'pie',
	    data: {
        labels: ["Short", "Long", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($shorthairs) }}, {{ count($longhairs) }}, {{ $nohairlengths }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx3 = document.getElementById("coatcolorcanvas").getContext('2d');
		var coatcolorchart = new Chart(ctx3, {
			type: 'pie',
	    data: {
        labels: ["Black", "Others", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($blackcoats) }}, {{ count($nonblackcoats) }}, {{ $nocoats }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx4 = document.getElementById("colorpatterncanvas").getContext('2d');
		var colorpatternchart = new Chart(ctx4, {
			type: 'pie',
	    data: {
        labels: ["Plain", "Socks", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($plains) }}, {{ count($socks) }}, {{ $nopatterns }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx5 = document.getElementById("headshapecanvas").getContext('2d');
		var headshapechart = new Chart(ctx5, {
			type: 'pie',
	    data: {
        labels: ["Concave", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($concaves) }}, {{ count($straightheads) }}, {{ $noheadshapes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx6 = document.getElementById("skintypecanvas").getContext('2d');
		var skintypechart = new Chart(ctx6, {
			type: 'pie',
	    data: {
        labels: ["Smooth", "Wrinkled", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($smooths) }}, {{ count($wrinkleds) }}, {{ $noskintypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx7 = document.getElementById("eartypecanvas").getContext('2d');
		var eartypechart = new Chart(ctx7, {
			type: 'pie',
	    data: {
        labels: ["Drooping", "Semi-lop", "Erect", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($droopingears) }}, {{ count($semilops) }}, {{ count($erectears)}}, {{ $noeartypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx8 = document.getElementById("tailtypecanvas").getContext('2d');
		var tailtypechart = new Chart(ctx8, {
			type: 'pie',
	    data: {
        labels: ["Curly", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($curlytails) }}, {{ count($straighttails) }}, {{ $notailtypes }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
		var ctx9 = document.getElementById("backlinecanvas").getContext('2d');
		var backlinechart = new Chart(ctx9, {
			type: 'pie',
	    data: {
        labels: ["Swayback", "Straight", "No Record"],
        datasets: [{
          label: 'Hair Length',
          data: [{{ count($swaybacks) }}, {{ count($straightbacks) }}, {{ $nobacklines }}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
          ]
        }]
	    }
		});
	</script>
@endsection