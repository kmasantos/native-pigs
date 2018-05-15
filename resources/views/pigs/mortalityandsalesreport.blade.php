@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales Report
@endsection

@section('content')
	<div class="container">
		<h4>Mortality &amp; Sales Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12 m10 l8">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Dead Pigs</h5>
            <div class="row">
              <div class="col s6">
                <h2>{{ count($dead) }}</h2>
              </div>
              <div class="col s6">
                @if($ages_dead == [])
                  <h4>No data available</h4>
                  <p>Average age, months</p>
                @else
                  <h4>{{ round(array_sum($ages_dead)/count($ages_dead), 2) }}</h4>
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
            <h5>Culled/Donated Pigs</h5>
            <div class="row">
              <h2>{{ count($removed) }}</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l12">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Sold Pigs</h5>
           	<div class="row">
	            <div class="col s6">
                <h3>{{ count($sold_breeders) }}</h3>
	            	<p>Breeders</p>
	            </div>
	            <div class="col s6">
	            	<h3>{{ count($sold_growers) }}</h3>
	            	<p>Growers</p>
	            </div>
	          </div>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l12">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Average Age when Sold, months</h5>
            <div class="row">
              <div class="col s6">
                @if($ages_sold_breeder == [])
                  <h5>No data available</h5>
                  <p>Breeders</p>
                @else
                  <h4>{{ round(array_sum($ages_sold_breeder)/count($ages_sold_breeder), 2) }}</h4>
                  <p>Breeders</p>
                @endif
              </div>
              <div class="col s6">
               @if($ages_sold_grower == [])
                  <h5>No data available</h5>
                  <p>Growers</p>
                @else
                  <h4>{{ round(array_sum($ages_sold_grower)/count($ages_sold_grower), 2) }}</h4>
                  <p>Growers</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l12">
        <div class="card">
          <div class="card-content grey lighten-2">
            <h5>Average Weight when Sold, kg</h5>
            <div class="row">
              <div class="col s6">
                @if($weights_sold_breeder == [])
                  <h5>No data available</h5>
                  <p>Breeders</p>
                @else
                  <h4>{{ round(array_sum($weights_sold_breeder)/count($weights_sold_breeder), 2) }}</h4>
                  <p>Breeders</p>
                @endif
              </div>
              <div class="col s6">
                @if($weights_sold_grower == [])
                  <h5>No data available</h5>
                  <p>Growers</p>
                @else
                  <h4>{{ round(array_sum($weights_sold_grower)/count($weights_sold_grower), 2) }}</h4>
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