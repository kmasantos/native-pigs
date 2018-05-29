@extends('layouts.swinedefault')

@section('title')
  Gross Morphology
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.breeder_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Gross Morphology: {{ $animal->registryid }}</h4>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.fetch_gross_morphology', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s4">
              Date Collected
            </div>
            <div class="col s8">
              <input id="date_collected_gross" type="text" placeholder="Date Collected" name="date_collected_gross" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Hair Type
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_type1" type="radio" id="hair_type1_curly" value="Curly" />
              <label for="hair_type1_curly">Curly</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_type1" type="radio" id="hair_type1_straight" value="Straight" />
              <label for="hair_type1_straight">Straight</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Hair Length
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_type2" type="radio" id="hair_type2_short" value="Short" />
              <label for="hair_type2_short">Short</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_type2" type="radio" id="hair_type2_long" value="Long" />
              <label for="hair_type2_long">Long</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Coat Color
            </div>
            <div class="col s4">
              <input class="with-gap" name="coat_color" type="radio" id="coat_color_black" value="Black" />
              <label for="coat_color_black">Black</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="coat_color" type="radio" id="coat_color_others" value="Others" />
              <label for="coat_color_others">Others</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Color Pattern
            </div>
            <div class="col s4">
              <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_plain" value="Plain" />
              <label for="color_pattern_plain">Plain</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_socks" value="Socks" />
              <label for="color_pattern_socks">Socks</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Head Shape
            </div>
            <div class="col s4">
              <input class="with-gap" name="head_shape" type="radio" id="head_shape_concave" value="Concave" />
              <label for="head_shape_concave">Concave</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="head_shape" type="radio" id="head_shape_straight" value="Straight" />
              <label for="head_shape_straight">Straight</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Skin Type
            </div>
            <div class="col s4">
              <input class="with-gap" name="skin_type" type="radio" id="skin_type_smooth" value="Smooth" />
              <label for="skin_type_smooth">Smooth</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="skin_type" type="radio" id="skin_type_wrinkled" value="Wrinkled" />
              <label for="skin_type_wrinkled">Wrinkled</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Ear Type
            </div>
            <div class="col s3">
              <input class="with-gap" name="ear_type" type="radio" id="ear_type_drooping" value="Drooping" />
              <label for="ear_type_drooping">Drooping</label>
            </div>
            <div class="col s3">
              <input class="with-gap" name="ear_type" type="radio" id="ear_type_semilop" value="Semi-lop" />
              <label for="ear_type_semilop">Semi-lop</label>
            </div>
            <div class="col s2">
              <input class="with-gap" name="ear_type" type="radio" id="ear_type_erect" value="Erect" />
              <label for="ear_type_erect">Erect</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Tail Type
            </div>
            <div class="col s4">
              <input class="with-gap" name="tail_type" type="radio" id="tail_type_curly" value="Curly" />
              <label for="tail_type_curly">Curly</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="tail_type" type="radio" id="tail_type_straight" value="Straight" />
              <label for="tail_type_straight">Straight</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Backline
            </div>
            <div class="col s4">
              <input class="with-gap" name="backline" type="radio" id="backline_swayback" value="Swayback" />
              <label for="backline_swayback">Swayback</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="backline" type="radio" id="backline_straight" value="Straight" />
              <label for="backline_straight">Straight</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Other Marks
            </div>
            <div class="col s8">
              <input id="other_marks" type="text" name="other_marks" placeholder="Enter values separated by commas" class="validate">
            </div>
          </div>
          <div class="row center">
            <button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Saved successfully!', 4000)">Save
              <i class="material-icons right">save</i>
            </button>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection