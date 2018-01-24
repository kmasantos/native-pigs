@extends('layouts.newLayout')

@section('title')
  Breeder - Family Record
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Family Record</h4>
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              {!! Form::open(['route' => 'farm.chicken.submit_family_record', 'method' => 'post']) !!}
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="family_id" type="text" class="validate" name="family_id">
                      <label for="family_id">Family ID</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="date_transferred" type="text" class="datepicker" name="date_transferred">
                      <label for="date_transferred">Date Transferred to Breeder Area</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="generation" type="text" class="validate" name="generation">
                      <label for="generation">Generation</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input id="date_hatched" type="text" class="datepicker" name="date_hatched">
                      <label for="date_hatched">Date Hatched</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="line" type="text" class="validate" name="line">
                      <label for="line">Line</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input id="age_first_egg" type="text" class="validate" name="age_first_egg">
                      <label for="age_first_egg">Age at First Egg</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input disabled id="no_male" type="text">
                      <label for="no_male">No. of Males in the Family</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input disabled id="no_female" type="text">
                      <label for="no_female">No. of Females in the Family</label>
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
