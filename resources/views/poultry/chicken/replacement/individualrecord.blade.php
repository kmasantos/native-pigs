@extends('layouts.newLayout')

@section('title')
  Replacement - Individual Record
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Individual Record</h4>
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              {!! Form::open(['route' => 'farm.poultry.get_replacement_individual_record', 'method' => 'post']) !!}
                <div class="row">
                  <div class="col s12 m12 l12">
                      <div class="input-field col s12 m6 l6">
                        <input id="date_hatched" type="text" class="datepicker" name="date_hatched">
                        <label for="date_hatched">Date Hatched</label>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="individual_id" type="text" class="validate" name="individual_id">
                      <label for="individual_id">Individual ID</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="generation" type="text" class="validate" name="generation">
                      <label for="generation">Generation</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="line" type="text" class="validate" name="line">
                      <label for="line">Line</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="family" type="text" class="validate" name="family">
                      <label for="family">Family</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <div class="input-field col s6 m6 l6">
                          <select name="gender">
                            <option value="" disabled selected>Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                          </select>
                          <label>Gender</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                      <div class="input-field col s12 m6 l6">
                        <input id="date_transferred" type="text" class="datepicker" name="date_transferred">
                        <label for="date_transferred">Date Transferred</label>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12 center">
                    <button class="btn waves-effect waves-light yellow darken-3" type="submit">Submit
                      <i class="material-icons right">send</i>
                    </button>
                  </div>
                </div>
              {!!Form::close()!!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

@endsection
