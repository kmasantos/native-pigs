@extends('layouts.swinedefault')

@section('title')
  Weight Records
@endsection

@section('content')
  <h4 class="headline"><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Weight Records: {{ $animal->registryid }}</h4>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.fetch_weight_records', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s4">
              Body Weight at 45 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_45_days" type="text" placeholder="Weight" name="body_weight_at_45_days" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_45_days" type="text" placeholder="Date Collected" name="date_collected_45_days" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 60 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_60_days" type="text" placeholder="Weight" name="body_weight_at_60_days" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_60_days" type="text" placeholder="Date Collected" name="date_collected_60_days" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 90 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_90_days" type="text" placeholder="Weight" name="body_weight_at_90_days" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_90_days" type="text" placeholder="Date Collected" name="date_collected_90_days" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 150 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_150_days" type="text" placeholder="Weight" name="body_weight_at_150_days" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_150_days" type="text" placeholder="Date Collected" name="date_collected_150_days" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 180 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_180_days" type="text" placeholder="Weight" name="body_weight_at_180_days" class="validate">
            </div>
            <div class="col s4">
              <input id="date_collected_180_days" type="text" placeholder="Date Collected" name="date_collected_180_days" class="datepicker">
            </div>
          </div>
        </div>
        <div class="row center">
          <button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Saved successfully!', 4000)">Save
            <i class="material-icons right">save</i>
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection