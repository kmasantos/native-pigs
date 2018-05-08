@extends('layouts.newLayout')

@section('title')
  Replacement - Growth Performance
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Growth Performance</h4>
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              {!! Form::open([ 'method' => 'post']) !!}
                <div class="row">
                  <div class="col s12 m12 l12">
                    Weight at
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_0" />
                    <label for="weight_at_0">0 days</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_21" />
                    <label for="weight_at_21">21 days</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_45" />
                    <label for="weight_at_45">45 days</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_75" />
                    <label for="weight_at_75">75 days</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_100" />
                    <label for="weight_at_100">100 days</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_120" />
                    <label for="weight_at_120">120 days</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                      <div class="input-field col s12 m6 l6">
                        <input id="date_collected" type="text" class="datepicker" name="date_collected">
                        <label for="date_collected">Date Collected</label>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="pen" type="text" class="validate" name="pen">
                      <label for="pen">Pen No.</label>
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
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <div class="input-field col s6 m6 l6">
                          <select>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
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
                      <input id="family" type="text" class="validate" name="family">
                      <label for="family">Family</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="weight" type="number" min=0 class="validate" name="weight">
                      <label for="weight">Weight</label>
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
