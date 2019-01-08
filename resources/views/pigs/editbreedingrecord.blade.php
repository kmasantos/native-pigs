@extends('layouts.swinedefault')

@section('title')
	Edit Breeding Record
@endsection

@section('content')
	<div class="container">
		<h4><a href="{{route('farm.pig.breeding_record')}}"><img src="{{asset('images/back.png')}}" width="4.5%"></a> Edit Breeding Record</h4>
		<div class="divider"></div>
		{!! Form::open(['route' => 'farm.pig.update_breeding_record', 'method' => 'post']) !!}
		<div class="row" style="padding-top: 10px;">
			<input type="hidden" name="grouping_id" value="{{ $family->id }}">
			<div class="col s2 offset-s2">
				<p>Sow Used</p>
			</div>
			<div class="col s6">
				<select name="sow_id" class="browser-default">
					<option selected value="{{ $family->getMother()->registryid }}">{{ $family->getMother()->registryid }}</option>
						@foreach($sows as $sow)	
							<option value="{{ $sow->registryid }}">{{ $sow->registryid }}</option>
						@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col s2 offset-s2">
				<p>Boar Used</p>
			</div>
			<div class="col s6">
				<select id="boar_id" name="boar_id" class="browser-default">
					<option selected value="{{ $family->getFather()->registryid }}">{{ $family->getFather()->registryid }}</option>
						@foreach($boars as $boar)
							<option value="{{ $boar->registryid }}">{{ $boar->registryid }}</option>
						@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col s2">
				<p>Date Bred:</p>
			</div>
			<div class="col s4">
				@if(!is_null($properties->where("property_id", 42)->first()))
					<input id="date_bred" type="text" value="{{ Carbon\Carbon::parse($properties->where("property_id", 42)->first()->value)->format('Y-m-d') }}" name="date_bred" class="datepicker">
					<label for="date_bred">{{ Carbon\Carbon::parse($properties->where("property_id", 42)->first()->value)->format('j F, Y') }}</label>
				@else
					<input id="date_bred" type="text" name="date_bred" class="datepicker">
				@endif
			</div>
			<div class="col s6 center">
				<p>Expected Date of Farrowing: {{ Carbon\Carbon::parse($properties->where("property_id", 43)->first()->value)->format('j F, Y') }}</p>
			</div>
		</div>
		<div class="row">
			@if($properties->where("property_id", 60)->first()->value == "Bred")
				<div class="col s3">
          Status
        </div>
        <div class="col s3">
          <input class="with-gap" name="status" type="radio" id="status_bred" value="Bred" checked />
          <label for="status_bred">Bred</label>
        </div>
        <div class="col s3">
          <input class="with-gap" name="status" type="radio" id="status_pregnant" value="Pregnant" />
          <label for="status_pregnant">Pregnant</label>
        </div>
        <div class="col s3">
          <input class="with-gap" name="status" type="radio" id="status_recycled" value="Recycled" />
          <label for="status_recycled">Recycled</label>
        </div>
			@elseif($properties->where("property_id", 60)->first()->value == "Pregnant")
				<div class="col s2 offset-s1">
          Status
        </div>
        <div class="col s2">
          <input class="with-gap" name="status" type="radio" id="status_pregnant" value="Pregnant" checked />
          <label for="status_pregnant">Pregnant</label>
        </div>
        <div class="col s2">
          <input class="with-gap" name="status" type="radio" id="status_farrowed" value="Farrowed" />
          <label for="status_farrowed">Farrowed</label>
        </div>
        <div class="col s2">
          <input class="with-gap" name="status" type="radio" id="status_recycled" value="Recycled" />
          <label for="status_recycled">Recycled</label>
        </div>
        <div class="col s2">
          <input class="with-gap" name="status" type="radio" id="status_aborted" value="Aborted" />
          <label for="status_aborted">Aborted</label>
        </div>
      @elseif($properties->where("property_id", 60)->first()->value == "Farrowed" || $properties->where("property_id", 60)->first()->value == "Recycled" || $properties->where("property_id", 60)->first()->value == "Aborted")
      	<input type="hidden" name="status" value="{{ $properties->where("property_id", 60)->first()->value }}">
			@endif
		</div>
		<div class="row center">
			<button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Saved successfully!', 4000)">Update
        <i class="material-icons right">done</i>
      </button>
		</div>
		{!! Form::close() !!}
	</div>
@endsection