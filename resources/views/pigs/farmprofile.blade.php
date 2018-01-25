@extends('layouts.swinedefault')

@section('title')
  Farm Profile
@endsection

@section('content')
  <h4 class="headline">Farm Profile</h4>
  <div class="container">
    <div class="row">
      <form class="col s12">
        <div class="row">
          <div class="input-field col s10 offset-s1">
            <i class="material-icons prefix">info</i>
            <input id="farm_name" type="text" name="farm_name" class="validate">
            <label for="farm_name">Farm name</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s4 offset-s1">
            <i class="material-icons prefix">account_circle</i>
            <input disabled id="farm_id" type="text" name="farm_id" class="validate">
            <label for="farm_id">Farm ID</label>
          </div>
          <div class="input-field col s6">
            <i class="material-icons prefix">list</i>
            <input id="breed" type="text" name="breed" class="validate">
            <label for="breed">Breed</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s2 offset-s1">
            <i class="material-icons prefix">map</i>
            <input id="region" type="text" name="region" class="validate">
            <label for="region">Region</label>
          </div>
          <div class="input-field col s4">
            <i class="material-icons prefix">terrain</i>
            <input id="province" type="text" name="province" class="validate">
            <label for="province">Province</label>
          </div>
          <div class="input-field col s4">
            <i class="material-icons prefix">location_city</i>
            <input id="town" type="text" name="town" class="validate">
            <label for="town">Town</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6 offset-s1">
            <i class="material-icons prefix">place</i>
            <input id="baranggay" type="text" name="baranggay" class="validate">
            <label for="baranggay">Baranggay</label>
          </div>
          <div class="input-field col s4">
            <i class="material-icons prefix">smartphone</i>
            <input id="phone_number" type="text" name="phone_number" class="validate">
            <label for="phone_number">Phone number</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6 offset-s1">
            <i class="material-icons prefix">email</i>
            <input id="email_address" type="email" name="email_address" class="validate">
            <label for="email_address">Email address</label>
          </div>
          <div class="file-field input-field col s4">
            <div class="btn red lighten-2 waves-effect waves-light">
              <i class="material-icons right">file_upload</i>Upload
              <input type="file" name="farm_picture" id="farm_picture">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" id="farm_picture">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col s6 offset-s4">
            <a href="#!" class="btn waves-effect waves-light red lighten-2"><i class="material-icons right">edit</i>Edit</a>
            <a href="#!" class="btn waves-effect waves-light red lighten-2"><i class="material-icons right">save</i>Save</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection