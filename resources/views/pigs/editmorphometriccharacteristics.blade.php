@extends('layouts.swinedefault')

@section('title')
  Edit Morphometric Characteristics
@endsection

@section('content')
  <h5 class="headline"><a href="{{route('farm.pig.breeder_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Edit Morphometric Characteristics: <strong>{{ $animal->registryid }}</strong></h5>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.update_morphometric_characteristics', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s5">
              Ear Length, cm
            </div>
            <div class="col s7">
              <input id="ear_length" type="text" name="ear_length" value="{{ $properties->where("property_id", 64)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Head Length, cm
            </div>
            <div class="col s7">
              <input id="head_length" type="text" name="head_length" value="{{ $properties->where("property_id", 39)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Snout Length, cm
            </div>
            <div class="col s7">
              <input id="snout_length" type="text" name="snout_length" value="{{ $properties->where("property_id", 63)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Body Length, cm
            </div>
            <div class="col s7">
              <input id="body_length" type="text" name="body_length" value="{{ $properties->where("property_id", 40)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Heart Girth, cm
            </div>
            <div class="col s7">
              <input id="heart_girth" type="text" name="heart_girth" value="{{ $properties->where("property_id", 42)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">   
            <div class="col s5">
              Pelvic Width, cm
            </div>
            <div class="col s7">
              <input id="pelvic_width" type="text" name="pelvic_width" value="{{ $properties->where("property_id", 41)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Tail Length, cm
            </div>
            <div class="col s7">
              <input id="tail_length" type="text" name="tail_length" value="{{ $properties->where("property_id", 65)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">   
            <div class="col s5">
              Height at Withers, cm
            </div>
            <div class="col s7">
              <input id="height_at_withers" type="text" name="height_at_withers" value="{{ $properties->where("property_id", 66)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s5">
              Number of Normal Teats
            </div>
            <div class="col s7">
              <p class="range-field">
                <input type="range" id="number_of_normal_teats" name="number_of_normal_teats" value="{{ $properties->where("property_id", 44)->first()->value }}" min="6" max="18" />
              </p>
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