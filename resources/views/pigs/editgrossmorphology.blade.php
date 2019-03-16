@extends('layouts.swinedefault')

@section('title')
  Edit Gross Morphology
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.breeder_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Edit Gross Morphology: <strong>{{ $animal->registryid }}</strong></h4>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.update_gross_morphology', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s4">
              Date Collected
            </div>
            <div class="col s8">
              <input id="date_collected_gross" type="text" value="{{ Carbon\Carbon::parse($properties->where("property_id", 10)->first()->value)->format('j F, Y') }}" name="date_collected_gross" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Hair Type
            </div>
            @if($properties->where("property_id", 11)->first()->value == "Curly")
              <div class="col s4">
                <input class="with-gap" name="hair_type" type="radio" id="hair_type_curly" checked="checked" value="Curly" />
                <label for="hair_type_curly">Curly</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="hair_type" type="radio" id="hair_type_straight" value="Straight" />
                <label for="hair_type_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 11)->first()->value == "Straight")
              <div class="col s4">
                <input class="with-gap" name="hair_type" type="radio" id="hair_type_curly" value="Curly" />
                <label for="hair_type_curly">Curly</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="hair_type" type="radio" id="hair_type_straight" checked="checked" value="Straight" />
                <label for="hair_type_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 11)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="hair_type" type="radio" id="hair_type_curly" value="Curly" />
                <label for="hair_type_curly">Curly</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="hair_type" type="radio" id="hair_type_straight" value="Straight" />
                <label for="hair_type_straight">Straight</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Hair Length
            </div>
            @if($properties->where("property_id", 12)->first()->value == "Short")
              <div class="col s4">
                <input class="with-gap" name="hair_length" type="radio" id="hair_length_short" checked="checked" value="Short" />
                <label for="hair_length_short">Short</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="hair_length" type="radio" id="hair_length_long" value="Long" />
                <label for="hair_length_long">Long</label>
              </div>
            @elseif($properties->where("property_id", 12)->first()->value == "Long")
              <div class="col s4">
                <input class="with-gap" name="hair_length" type="radio" id="hair_length_short" value="Short" />
                <label for="hair_length_short">Short</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="hair_length" type="radio" id="hair_length_long" checked="checked" value="Long" />
                <label for="hair_length_long">Long</label>
              </div>
            @elseif($properties->where("property_id", 12)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="hair_length" type="radio" id="hair_length_short" value="Short" />
                <label for="hair_length_short">Short</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="hair_length" type="radio" id="hair_length_long" value="Long" />
                <label for="hair_length_long">Long</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Coat Color
            </div>
            @if($properties->where("property_id", 13)->first()->value == "Black")
              <div class="col s4">
                <input class="with-gap" name="coat_color" type="radio" id="coat_color_black" checked="checked" value="Black" />
                <label for="coat_color_black">Black</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="coat_color" type="radio" id="coat_color_others" value="Others" />
                <label for="coat_color_others">Others</label>
              </div>
            @elseif($properties->where("property_id", 13)->first()->value == "Others")
              <div class="col s4">
                <input class="with-gap" name="coat_color" type="radio" id="coat_color_black" value="Black" />
                <label for="coat_color_black">Black</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="coat_color" type="radio" id="coat_color_others" checked="checked" value="Others" />
                <label for="coat_color_others">Others</label>
              </div>
            @elseif($properties->where("property_id", 13)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="coat_color" type="radio" id="coat_color_black" value="Black" />
                <label for="coat_color_black">Black</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="coat_color" type="radio" id="coat_color_others" value="Others" />
                <label for="coat_color_others">Others</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Color Pattern
            </div>
            @if($properties->where("property_id", 14)->first()->value == "Plain")
              <div class="col s4">
                <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_plain" checked="checked" value="Plain" />
                <label for="color_pattern_plain">Plain</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_socks" value="Socks" />
                <label for="color_pattern_socks">Socks</label>
              </div>
            @elseif($properties->where("property_id", 14)->first()->value == "Socks")
              <div class="col s4">
                <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_plain" value="Plain" />
                <label for="color_pattern_plain">Plain</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_socks" checked="checked" value="Socks" />
                <label for="color_pattern_socks">Socks</label>
              </div>
            @elseif($properties->where("property_id", 14)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_plain" value="Plain" />
                <label for="color_pattern_plain">Plain</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_socks" value="Socks" />
                <label for="color_pattern_socks">Socks</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Head Shape
            </div>
            @if($properties->where("property_id", 15)->first()->value == "Concave")
              <div class="col s4">
                <input class="with-gap" name="head_shape" type="radio" id="head_shape_concave" checked="checked" value="Concave" />
                <label for="head_shape_concave">Concave</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="head_shape" type="radio" id="head_shape_straight" value="Straight" />
                <label for="head_shape_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 15)->first()->value == "Straight")
              <div class="col s4">
                <input class="with-gap" name="head_shape" type="radio" id="head_shape_concave" value="Concave" />
                <label for="head_shape_concave">Concave</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="head_shape" type="radio" id="head_shape_straight" checked="checked" value="Straight" />
                <label for="head_shape_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 15)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="head_shape" type="radio" id="head_shape_concave" value="Concave" />
                <label for="head_shape_concave">Concave</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="head_shape" type="radio" id="head_shape_straight" value="Straight" />
                <label for="head_shape_straight">Straight</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Skin Type
            </div>
            @if($properties->where("property_id", 16)->first()->value == "Smooth")
              <div class="col s4">
                <input class="with-gap" name="skin_type" type="radio" id="skin_type_smooth" checked="checked" value="Smooth" />
                <label for="skin_type_smooth">Smooth</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="skin_type" type="radio" id="skin_type_wrinkled" value="Wrinkled" />
                <label for="skin_type_wrinkled">Wrinkled</label>
              </div>
            @elseif($properties->where("property_id", 16)->first()->value == "Wrinkled")
              <div class="col s4">
                <input class="with-gap" name="skin_type" type="radio" id="skin_type_smooth" value="Smooth" />
                <label for="skin_type_smooth">Smooth</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="skin_type" type="radio" id="skin_type_wrinkled" checked="checked" value="Wrinkled" />
                <label for="skin_type_wrinkled">Wrinkled</label>
              </div>
            @elseif($properties->where("property_id", 16)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="skin_type" type="radio" id="skin_type_smooth" value="Smooth" />
                <label for="skin_type_smooth">Smooth</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="skin_type" type="radio" id="skin_type_wrinkled" value="Wrinkled" />
                <label for="skin_type_wrinkled">Wrinkled</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Ear Type
            </div>
            @if($properties->where("property_id", 17)->first()->value == "Drooping")
              <div class="col s3">
                <input class="with-gap" name="ear_type" type="radio" id="ear_type_drooping" checked="checked" value="Drooping" />
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
            @elseif($properties->where("property_id", 17)->first()->value == "Semi-lop")
              <div class="col s3">
                <input class="with-gap" name="ear_type" type="radio" id="ear_type_drooping" value="Drooping" />
                <label for="ear_type_drooping">Drooping</label>
              </div>
              <div class="col s3">
                <input class="with-gap" name="ear_type" type="radio" id="ear_type_semilop" checked="checked" value="Semi-lop" />
                <label for="ear_type_semilop">Semi-lop</label>
              </div>
              <div class="col s2">
                <input class="with-gap" name="ear_type" type="radio" id="ear_type_erect" value="Erect" />
                <label for="ear_type_erect">Erect</label>
              </div>
            @elseif($properties->where("property_id", 17)->first()->value == "Erect")
              <div class="col s3">
                <input class="with-gap" name="ear_type" type="radio" id="ear_type_drooping" value="Drooping" />
                <label for="ear_type_drooping">Drooping</label>
              </div>
              <div class="col s3">
                <input class="with-gap" name="ear_type" type="radio" id="ear_type_semilop" value="Semi-lop" />
                <label for="ear_type_semilop">Semi-lop</label>
              </div>
              <div class="col s2">
                <input class="with-gap" name="ear_type" type="radio" id="ear_type_erect" checked="checked" value="Erect" />
                <label for="ear_type_erect">Erect</label>
              </div>
            @elseif($properties->where("property_id", 17)->first()->value == "Not specified")
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
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Tail Type
            </div>
            @if($properties->where("property_id", 18)->first()->value == "Curly")
              <div class="col s4">
                <input class="with-gap" name="tail_type" type="radio" id="tail_type_curly" checked="checked" value="Curly" />
                <label for="tail_type_curly">Curly</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="tail_type" type="radio" id="tail_type_straight" value="Straight" />
                <label for="tail_type_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 18)->first()->value == "Straight")
              <div class="col s4">
                <input class="with-gap" name="tail_type" type="radio" id="tail_type_curly" value="Curly" />
                <label for="tail_type_curly">Curly</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="tail_type" type="radio" id="tail_type_straight" checked="checked" value="Straight" />
                <label for="tail_type_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 18)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="tail_type" type="radio" id="tail_type_curly" value="Curly" />
                <label for="tail_type_curly">Curly</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="tail_type" type="radio" id="tail_type_straight" value="Straight" />
                <label for="tail_type_straight">Straight</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Backline
            </div>
            @if($properties->where("property_id", 19)->first()->value == "Swayback")
              <div class="col s4">
                <input class="with-gap" name="backline" type="radio" id="backline_swayback" checked="checked" value="Swayback" />
                <label for="backline_swayback">Swayback</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="backline" type="radio" id="backline_straight" value="Straight" />
                <label for="backline_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 19)->first()->value == "Straight")
              <div class="col s4">
                <input class="with-gap" name="backline" type="radio" id="backline_swayback" value="Swayback" />
                <label for="backline_swayback">Swayback</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="backline" type="radio" id="backline_straight" checked="checked" value="Straight" />
                <label for="backline_straight">Straight</label>
              </div>
            @elseif($properties->where("property_id", 19)->first()->value == "Not specified")
              <div class="col s4">
                <input class="with-gap" name="backline" type="radio" id="backline_swayback" value="Swayback" />
                <label for="backline_swayback">Swayback</label>
              </div>
              <div class="col s4">
                <input class="with-gap" name="backline" type="radio" id="backline_straight" value="Straight" />
                <label for="backline_straight">Straight</label>
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Other Marks
            </div>
            <div class="col s8">
              <input id="other_marks" type="text" name="other_marks" placeholder="Enter values separated by commas" value="{{ $properties->where("property_id", 20)->first()->value }}" class="validate">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Upload photo<br><a href="#sample_photo" class="modal-trigger tooltipped" data-position="bottom" data-tooltip="View sample"><i class="material-icons">visibility</i></a>
            </div>
            <div class="file-field input-field col s8">
              <div class="btn green darken-3 waves-effect waves-light">
                <i class="material-icons right">file_upload</i>Upload
                <input type="file" name="display_photo" id="display_photo">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" id="display_photo">
              </div>
            </div>
          </div>
          <div class="row center">
            <button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Saved successfully!', 4000)">Update
              <i class="material-icons right">done</i>
            </button>
          </div>
        </div>
        {{-- MODAL STRUCTURE --}}
        <div id="sample_photo" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h4 class="center">Sample Photo</h4>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
          </div>
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