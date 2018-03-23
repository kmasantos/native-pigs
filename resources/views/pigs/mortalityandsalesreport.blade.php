@extends('layouts.swinedefault')

@section('title')
	Mortality &amp; Sales Report
@endsection

@section('content')
	<div class="container">
		<h4>Mortality &amp; Sales Report</h4>
		<div class="divider"></div>
		<div class="row center" style="padding-top: 10px;">
			<div class="col s12 m10 l4">
        <div class="card">
          <div class="card-content grey lighten-1">
            <h5>Mortality</h5>
            <h3>{{ count($dead) }}</h3>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l4">
        <div class="card">
          <div class="card-content grey lighten-1">
            <h5>Sold</h5>
            <h3>{{ count($sold) }}</h3>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l4">
        <div class="card">
          <div class="card-content grey lighten-1">
            <h5>Culled/Donated</h5>
            <h3>{{ count($removed) }}</h3>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l6">
        <div class="card">
          <div class="card-content grey lighten-1">
            <h5>Average Age, months</h5>
           	<div class="row">
	            <div class="col s6">
	            	<h3>#</h3>
	            	<p>Died</p>
	            </div>
	            <div class="col s6">
	            	<h3>#</h3>
	            	<p>Sold</p>
	            </div>
	          </div>
          </div>
        </div>
      </div>
      <div class="col s12 m10 l6">
        <div class="card">
          <div class="card-content grey lighten-1">
            <h5>Average Weight</h5>
            <div class="row">
            	<div class="col s12">
		            <h3>#</h3>
		            <p>kg</p>
		          </div>
	          </div>
          </div>
        </div>
      </div>
		</div>
	</div>
@endsection