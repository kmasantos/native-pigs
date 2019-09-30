@extends('layouts.default')

@section('title')
	Administrator
@endsection

@section('content')
	<div class="container">
    <div class="row">
      <h4>Dashboard</h4>
      <div class="divider"></div>
      <div class="row center">
        <h5>Data as of <strong>{{ Carbon\Carbon::parse($now)->format('F j, Y') }}</strong></h5>
        <div class="col s12 m10 l12">
          <div class="card">
            <div class="card-content grey lighten-2">
              <h5>User Statistics</h5>
              <div class="row">
                <div class="col s6">
                  <h2>{{ count($users) }}</h2>
                  <p>Users</p>
                </div>
                <div class="col s6">
                  <div class="col s6">
                    <h3>{{ count($farms) }}</h3>
                    <p>Farms</p>
                  </div>
                  <div class="col s6">
                    <h3>{{ count($breeds) }}</h3>
                    <p>Breeds</p>
                  </div>
                  <p>Farms and Breeds</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m10 l12">
          <div class="card">
            <div class="card-content grey lighten-2">
              <h5>User Activity</h5>
              <div class="row">
                <div class="col s6">
                  <h5>{{ Carbon\Carbon::parse($latest_login)->format('j F, Y h:i A') }}</h5>
                  <p>Users' Latest Login</p>
                </div>
                <div class="col s6">
                  <h5>{{ $latest_user->getFarm()->name }}</h5>
                  <p>Recently Active Farm</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection