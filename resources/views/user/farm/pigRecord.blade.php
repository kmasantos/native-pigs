@extends('layouts.farm')

@section('initScripts')
	<link type="text/css" rel="stylesheet" href="{{asset('css/pigrecord.css')}}"  media="screen,projection"/>
@endsection

@section('title')
	Native Animals PH | Farm Details
@endsection

@section('content')
	<div class="row">
        <div class="col s12 card-panel">
          <h4 class="center">Individual Records</h4><br>

          <div class="row">
            <div class="col s4 offset-s2 center">
              <div class="imgoverlay">
                <img src="{{asset('images/sow.jpg')}}" height="200" width="200" style="border:1px solid black" />
                <div class="overlay"></div>
                <div class="buttons">
                  <a href="{{ route('farm.addsow') }}" class="btn-floating waves-effect waves-light green"><i class="material-icons">add</i></a>
                  <a href="{{ route('farm.editrecord') }}" class="btn-floating waves-effect waves-light yellow"><i class="material-icons">edit</i></a>
                </div>
              </div>
              <h5 class="center">Sow</h5>
            </div>
            <div class="col s4 center">
              <div class="imgoverlay">
                <img src="{{asset('images/boar.jpg')}}" height="200" width="200" style="border:1px solid black" />
                <div class="overlay"></div>
                <div class="buttons">
                  <a href="{{ route('farm.addboar') }}" class="btn-floating waves-effect waves-light green"><i class="material-icons">add</i></a>
                  <a href="{{ route('farm.editrecord') }}" class="btn-floating waves-effect waves-light yellow"><i class="material-icons">edit</i></a>
                </div>
              </div>
              <h5 class="center">Boar</h5>
            </div>
          </div>
        </div>
      </div>
@endsection