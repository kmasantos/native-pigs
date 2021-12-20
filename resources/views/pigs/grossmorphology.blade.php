@extends('layouts.swinedefault')

@section('title')
  Gross Morphology
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.breeder_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Gross Morphology: <strong>{{ $animal->registryid }}</strong></h4>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.fetch_gross_morphology', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s4">
              Date Collected
            </div>
            <div class="col s8">
              <input id="date_collected_gross" type="date" placeholder="Date Collected" name="date_collected_gross">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Hair Type
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_type" type="radio" id="hair_type_curly" value="Curly" />
              <label for="hair_type_curly">Curly</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_type" type="radio" id="hair_type_straight" value="Straight" />
              <label for="hair_type_straight">Straight</label>
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Hair Length
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_length" type="radio" id="hair_length_short" value="Short" />
              <label for="hair_length_short">Short</label>
            </div>
            <div class="col s4">
              <input class="with-gap" name="hair_length" type="radio" id="hair_length_long" value="Long" />
              <label for="hair_length_long">Long</label>
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
          <div class="row">
            <div class="col s4">
              Upload photo<br><a href="#sample_photo" class="modal-trigger tooltipped" data-position="right" data-tooltip="View sample"><i class="material-icons">visibility</i></a>
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
            <button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Saved successfully!', 4000)">Save
              <i class="material-icons right">save</i>
            </button>
          </div>
        </div>
        {{-- MODAL STRUCTURE --}}
        <div id="sample_photo" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h5 class="center">Sample Photo</h5>
            <div class="row center">
              <img src="{{asset('images/sample.jpg')}}" width="60%">
            </div>
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
