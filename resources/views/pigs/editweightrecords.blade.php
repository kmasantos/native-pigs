@extends('layouts.swinedefault')

@section('title')
  Edit Weight Records
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.individual_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Edit Weight Records: {{ $animal->registryid }}</h4>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.update_weight_records', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s4">
              Body Weight at 45 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_45_days" type="text" placeholder="Weight" name="body_weight_at_45_days" value="{{ $properties->where("property_id", 45)->first()->value }}" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_45_days" type="text" placeholder="Date Collected" name="date_collected_45_days" value="{{ $properties->where("property_id", 58)->first()->value }}" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 60 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_60_days" type="text" placeholder="Weight" name="body_weight_at_60_days" value="{{ $properties->where("property_id", 46)->first()->value }}" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_60_days" type="text" placeholder="Date Collected" name="date_collected_60_days" value="{{ $properties->where("property_id", 59)->first()->value }}" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 90 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_90_days" type="text" placeholder="Weight" name="body_weight_at_90_days" value="{{ $properties->where("property_id", 69)->first()->value }}" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_90_days" type="text" placeholder="Date Collected" name="date_collected_90_days" value="{{ $properties->where("property_id", 70)->first()->value }}" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 180 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_180_days" type="text" placeholder="Weight" name="body_weight_at_180_days" value="{{ $properties->where("property_id", 47)->first()->value }}" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_180_days" type="text" placeholder="Date Collected" name="date_collected_180_days" value="{{ $properties->where("property_id", 60)->first()->value }}" class="datepicker">
            </div>
          </div>
        </div>
        <div class="row center">
          <button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully updated!', 4000)">Update
            <i class="material-icons right">done</i>
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection