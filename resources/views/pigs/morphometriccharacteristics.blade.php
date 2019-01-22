@extends('layouts.swinedefault')

@section('title')
  Morphometric Characteristics
@endsection

@section('content')
  <h5 class="headline"><a href="{{route('farm.pig.breeder_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Morphometric Characteristics: <strong>{{ $animal->registryid }}</strong></h5>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.fetch_morphometric_characteristics', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s5">
              Date Collected
            </div>
            <div class="col s7">
              <input id="date_collected_morpho" type="text" placeholder="Date Collected" name="date_collected_morpho" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Ear Length, cm
            </div>
            <div class="col s7">
              <input id="ear_length" type="text" name="ear_length" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Head Length, cm
            </div>
            <div class="col s7">
              <input id="head_length" type="text" name="head_length" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Snout Length, cm
            </div>
            <div class="col s7">
              <input id="snout_length" type="text" name="snout_length" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Body Length, cm
            </div>
            <div class="col s7">
              <input id="body_length" type="text" name="body_length" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Heart Girth, cm
            </div>
            <div class="col s7">
              <input id="heart_girth" type="text" name="heart_girth" class="validate">
            </div>
          </div>
          <div class="row">   
            <div class="col s5">
              Pelvic Width, cm
            </div>
            <div class="col s7">
              <input id="pelvic_width" type="text" name="pelvic_width" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Tail Length, cm
            </div>
            <div class="col s7">
              <input id="tail_length" type="text" name="tail_length" class="validate">
            </div>
          </div>
          <div class="row">   
            <div class="col s5">
              Height at Withers, cm
            </div>
            <div class="col s7">
              <input id="height_at_withers" type="text" name="height_at_withers" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Number of Normal Teats
            </div>
            <div class="col s7">
              <p class="range-field">
                <input type="range" id="number_normal_teats" name="number_normal_teats" min="6" max="18" />
              </p>
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

@section('scripts')
  <script type="text/javascript">
      $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false, // Close upon selecting a date,
        format: 'yyyy-mm-dd', 
        max: new Date()
      });
  </script>
@endsection