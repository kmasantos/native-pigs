@extends('layouts.swinedefault')

@section('title')
  Farm Profile
@endsection

@section('content')
  <div class="container">
    <h4>Farm Profile</h4>
    <div class="divider"></div>
    <div class="row" style="padding-top: 10px;"> 
      {!! Form::open(['route' => 'farm.pig.get_farm_profile', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      <div class="col s12">
        <div class="row">
          <div class="input-field col s10 offset-s1">
            <i class="material-icons prefix">info</i>
            <input disabled id="farm_name" type="text" value="{{ $farm->name }}" name="farm_name" class="validate">
            <label for="farm_name">Farm name</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s4 offset-s1">
            <i class="material-icons prefix">account_circle</i>
            <input disabled id="farm_id" type="text" name="farm_id" value="{{ $farm->code }}" class="validate">
            <label for="farm_id">Farm ID</label>
          </div>
          <div class="input-field col s6">
            <i class="material-icons prefix">list</i>
            <input disabled id="breed" type="text" value="{{ $breed->breed }}" name="breed" class="validate">
            <label for="breed">Breed</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s2 offset-s1">
            <i class="material-icons prefix">map</i>
            @if(!is_null($farm->region))
              <input id="region" type="text" name="region" value="{{ $farm->region }}" class="validate">
            @else
              <input id="region" type="text" name="region" class="validate">
            @endif
            <label for="region">Region</label>
          </div>
          <div class="input-field col s4">
            <i class="material-icons prefix">terrain</i>
            <input id="province" type="text" name="province" value="{{ $farm->province }}" class="validate">
            <label for="province">Province</label>
          </div>
          <div class="input-field col s4">
            <i class="material-icons prefix">location_city</i>
            @if(!is_null($farm->town))
              <input id="town" type="text" name="town" value ="{{ $farm->town }}" class="validate">
            @else
              <input id="town" type="text" name="town" class="validate">
            @endif
            <label for="town">Town</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6 offset-s1">
            <i class="material-icons prefix">place</i>
            @if(!is_null($farm->barangay))
              <input id="barangay" type="text" name="barangay" value="{{ $farm->barangay }}" class="validate">
            @else
              <input id="barangay" type="text" name="baranggay" class="validate">
            @endif
            <label for="barangay">Barangay</label>
          </div>
          <div class="input-field col s4">
            <i class="material-icons prefix">smartphone</i>
            @if(!is_null($user->phone))
              <input id="phone_number" type="text" name="phone_number" value="{{ $user->phone }}" class="validate">
            @else
              <input id="phone_number" type="text" name="phone_number" class="validate">
            @endif
            <label for="phone_number">Phone number</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6 offset-s1">
            <i class="material-icons prefix">email</i>
            <input disabled id="email_address" type="email" name="email_address" value="{{ $user->email }}" class="validate">
            <label for="email_address">Email address</label>
          </div>
          <div class="file-field input-field col s4">
            <div class="btn green darken-3 waves-effect waves-light">
              <i class="material-icons right">file_upload</i>Upload
              <input type="file" name="farm_picture" id="farm_picture">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" id="farm_picture">
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