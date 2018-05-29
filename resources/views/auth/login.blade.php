@extends('layouts.default')

@section('title')
  Login - Native Animals PH
@endsection

@section('content')
  <div class="row center">
    <img id="login_logo" src="{{asset('images/logo-default.png')}}" alt="Native Animals" width="20%">
    <a id="login_button" class="amber darken-1 waves-effect waves-light btn btn-social" href="{{url('login/google')}}"><span class="fa fa-google"></span> Login with Google</a>
  </div>
@endsection
