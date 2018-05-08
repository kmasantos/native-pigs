@extends('layouts.newLayout')

@section('title')
  Dashboard
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Dashboard</h4>
      <div class="divider"></div>
      <div class="row">

        <div class="col s12 m6 l6">
          <div class="card-panel yellow lighten-3">
            <h4>Breeder Status</h4>
            <div class="row">
              <div class="col s6 m6 l6">
                Male
              </div>
              <div class="col s6 m6 l6">
                Female
              </div>
            </div>
          </div>
        </div>

        <div class="col s12 m6 l6">
          <div class="card-panel yellow lighten-3">
            <h4>Replacement Status</h4>
          </div>
        </div>

        <div class="col s12 m12 l12">
          <div class="card-panel yellow lighten-3">
            <h4>Overall</h4>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('scripts')

@endsection
