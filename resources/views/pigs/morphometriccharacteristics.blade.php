@extends('layouts.swinedefault')

@section('title')
  Morphometric Characteristics
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.individual_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Individual Record - Morphometric Characteristics</h4>
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
              Age at First Mating, months
            </div>
            <div class="col s7">
              <input disabled id="age_at_first_mating" type="text" name="age_at_first_mating" class="validate">
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
          <!-- AUTOMATICALLY COMPUTED -->
          <div class="row">
            <div class="col s5">
              Ponderal Index, kg/m<sup>3</sup>
            </div>
            <div class="col s7">
              <input disabled id="ponderal_index" type="text" name="ponderal_index" class="validate">
            </div>
          </div>
          @if($animal->getAnimalProperties()->where("property_id", 27)->first()->value == 'F')
            <div class="row">
              <div class="col s5">
                Number of Normal Teats
              </div>
              <div class="col s7">
                <p class="range-field">
                  <input type="range" id="number_of_normal_teats" name="number_of_normal_teats" min="6" max="18" />
                </p>
              </div>
            </div>
          @endif
        </div>
        <div class="row center">
          <button class="btn waves-effect waves-light red lighten-2" type="submit">Save
            <i class="material-icons right">save</i>
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection