@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales Report
@endsection

@section('content')
	<div class="container">
		<h4>Mortality &amp; Sales Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
      <h5>Inventory for {{ Carbon\Carbon::parse($now)->format('F, Y') }} as of {{ Carbon\Carbon::parse($now)->format('F j, Y') }}</h5>
			<div class="col s12 m10 l8">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Dead Pigs</h5>
            <div class="row">
              <div class="col s6">
                @if($dead_breeders != [] || $dead_growers != [])
                  <h3>{{ count($currentdeadbreeders) + count($currentdeadgrowers) }}</h3>
                @else
                  <h4>No data available</h4>
                @endif
                <p>Total</p>
              </div>
              <div class="col s6">
                @if($ages_dead == [])
                  <h4>No data available</h4>
                  <p>Average age, months</p>
                @else
                  <h3>{{ round(array_sum($ages_dead)/count($ages_dead), 2) }}</h3>
                  <p>Average Age, months</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l4">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Donated Pigs</h5>
              <h1>{{ count($currentremoved) }}</h1>
              <p>Total</p>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l12">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Sold Pigs</h5>
           	<div class="row">
	            <div class="col s6">
                <h4>{{ count($currentsoldbreeders) }}</h4>
	            	<p>Breeders</p>
	            </div>
	            <div class="col s6">
                <h4>{{ count($currentsoldgrowers) }}</h4>
	            	<p>Growers</p>
	            </div>
	          </div>
            <h5>Average Age when Sold, months</h5>
            <div class="row">
              <div class="col s6">
                @if($ages_currentsoldbreeder == [])
                  <h4>No data available</h4>
                  <p>Breeders</p>
                @else
                  <h4>{{ round(array_sum($ages_currentsoldbreeder)/count($ages_currentsoldbreeder), 2) }}</h4>
                  <p>Breeders</p>
                @endif
              </div>
              <div class="col s6">
               @if($ages_currentsoldgrower == [])
                  <h4>No data available</h4>
                  <p>Growers</p>
                @else
                  <h4>{{ round(array_sum($ages_currentsoldgrower)/count($ages_currentsoldgrower), 2) }}</h4>
                  <p>Growers</p>
                @endif
              </div>
            </div>
            <h5>Average Weight when Sold, kg</h5>
            <div class="row">
              <div class="col s6">
                @if($weights_currentsoldbreeder == [])
                  <h4>No data available</h4>
                  <p>Breeders</p>
                @else
                  <h4>{{ round(array_sum($weights_currentsoldbreeder)/count($weights_currentsoldbreeder), 2) }}</h4>
                  <p>Breeders</p>
                @endif
              </div>
              <div class="col s6">
                @if($weights_currentsoldgrower == [])
                  <h4>No data available</h4>
                  <p>Growers</p>
                @else
                  <h4>{{ round(array_sum($weights_currentsoldgrower)/count($weights_currentsoldgrower), 2) }}</h4>
                  <p>Growers</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
		</div>
	</div>
@endsection