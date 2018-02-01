@extends('layouts.swinedefault')

@section('title')
  Sow Record
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.animal_record')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Sow Record</h4>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.fetch_sow_record_id', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $sow->id }}">
        <ul class="collapsible" data-collapsible="expandable">
          <!--GROSS MORPHOLOGY-->
          <li>
            <div class="collapsible-header red lighten-4">GROSS MORPHOLOGY</div>
            <div class="collapsible-body">
              <ul class="collection">
                <li class="collection-item">
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
                    <div class="col s3">
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
                    <div class="col s3">
                      <input class="with-gap" name="ear_type" type="radio" id="ear_type_erect" value="Erect" />
                      <label for="ear_type_erect">Erect</label>
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
                </li>
              </ul>
            </div>
          </li>
          <!--MORPHOMETRIC CHARACTERISTICS-->
          <li>
            <div class="collapsible-header red lighten-4">MORPHOMETRIC CHARACTERISTICS</div>
            <div class="collapsible-body">
              <ul class="collection">
                <li class="collection-item">
                  <div class="row">
                    <div class="col s5">
                      Age at First Mating, months
                    </div>
                    <div class="col s7">
                      <input id="age_at_first_mating" type="text" name="age_at_first_mating" class="validate">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s5">
                      Final Weight at 8 Months, kg
                    </div>
                    <div class="col s7">
                      <input id="final_weight_at_8_months" type="text" name="final_weight_at_8_months" class="validate">
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
                      Body Length, cm
                    </div>
                    <div class="col s7">
                      <input id="body_length" type="text" name="body_length" class="validate">
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
                      Heart Girth, cm
                    </div>
                    <div class="col s7">
                      <input id="heart_girth" type="text" name="heart_girth" class="validate">
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
                  <div class="row">
                    <div class="col s5">
                      Number of Normal Teats
                    </div>
                    <div class="col s7">
                      <p class="range-field">
                        <input type="range" id="number_of_normal_teats" name="number_of_normal_teats" min="8" max="16" />
                      </p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </li>
          <!-- BODY WEIGHTS -->
          <li>
            <div class="collapsible-header red lighten-4">BODY WEIGHTS</div>
            <div class="collapsible-body">
              <ul class="collection">
                <li class="collection-item">
                  <div class="row">
                    <div class="col s4">
                      Body Weight at 45 Days
                    </div>
                    <div class="col s4">
                      <input id="body_weight_at_45_days" type="text" placeholder="Weight" name="body_weight_at_45_days" class="validate">
                    </div>
                    <div class="col s4">
                      <input id="date_collected_45_days" type="text" placeholder="Date" name="date_collected_45_days" class="datepicker">
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
                      <input id="date_collected_60_days" type="text" placeholder="Date" name="date_collected_60_days" class="datepicker">
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
                      <input id="date_collected_180_days" type="text" placeholder="Date" name="date_collected_180_days" class="datepicker">
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </li>
        </ul>
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