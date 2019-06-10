@extends('layouts.swinedefault')

@section('title')
	Page Not Found
@endsection

@section('content')
	<div class="row">
		<div class="col s12 center">
			<h1>OOPS!</h1>
			<img src="{{asset('images/working_black.gif')}}">
			<h4>PAGE NOT FOUND</h4>
		</div>
	</div>
@endsection
