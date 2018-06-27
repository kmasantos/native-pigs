@extends('layouts.swinedefault')

@section('title')
	Average Daily Gain
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.grower_records')}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Average Daily Gain</h4>
		<div class="divider"></div>
		<div class="row" style="padding-top: 10px;">
		</div>
	</div>
@endsection