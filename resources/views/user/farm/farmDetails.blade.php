@extends('layouts.farm')

@section('title')
	Native Animals PH | Farm Details
@endsection

@section('content')
	<div class="row">
        <div class="col s12 card-panel">
          <h4 class="center">Farm Details</h4>

          <div class="row">
            <form class="col s12">
              <div class="row">
                <div class="input-field col s10 offset-s1">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="farmname" type="text" class="validate">
                  <label for="farmname">Farm name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s4 offset-s1">
                  <i class="material-icons prefix">sim_card</i>
                  <input disabled id="farmIDdet" type="text" class="validate">
                  <label for="farmIDdet">Farm ID</label>
                </div>
                <div class="input-field col s6">
                  <i class="material-icons prefix">list</i>
                  <input id="breed" type="text" class="validate">
                  <label for="breed">Breeds</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s2 offset-s1">
                  <i class="material-icons prefix">my_location</i>
                  <input id="region" type="text" class="validate">
                  <label for="region">Region</label>
                </div>
                <div class="input-field col s4">
                  <i class="material-icons prefix">domain</i>
                  <input id="province" type="text" class="validate">
                  <label for="province">Province</label>
                </div>
                <div class="input-field col s4">
                  <i class="material-icons prefix">location_city</i>
                  <input id="town" type="text" class="validate">
                  <label for="town">Town</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6 offset-s1">
                  <i class="material-icons prefix">place</i>
                  <input id="baranggay" type="text" class="validate">
                  <label for="baranggay">Baranggay</label>
                </div>
                <div class="input-field col s4">
                  <i class="material-icons prefix">phone_iphone</i>
                  <input id="phoneno" type="text" class="validate">
                  <label for="phoneno">Phone</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6 offset-s1">
                  <i class="material-icons prefix">email</i>
                  <input id="emailadd" type="email" class="validate">
                  <label for="emailadd">Email address</label>
                </div>
                <div class="file-field input-field col s4">
                  <div class="btn teal waves-effect waves-light">
                    <i class="material-icons left">file_upload</i>Upload
                    <input type="file">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col s6 offset-s4">
                  <a href="#!" class="btn waves-effect waves-light teal"><i class="material-icons left">edit</i>Edit</a>
                  <a href="#!" class="btn waves-effect waves-light teal"><i class="material-icons left">save</i>Save</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
@endsection