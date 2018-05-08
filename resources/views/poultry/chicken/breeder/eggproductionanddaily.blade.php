@extends('layouts.newLayout')

@section('title')
  Breeder - Egg Production and Daily Record {{-- Specify if breeder or replacement when backend added through variable passed --}}
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Egg Production and Daily Record</h4> {{-- Specify if breeder or replacement when backend added through variable passed --}}
      <div class="divider"></div>
      <div class="row">
        <div class="row">
          <div class="col s12 m12 l12">
            <div class="card-panel">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Province: <strong><u></u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Generation: <strong><u></u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Farm ID: <strong><u></u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Line: <strong><u></u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Breed Name: <strong><u></u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Family: <strong><u></u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Date Collected: <strong><u></u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Animal Type: <strong><u>Chicken</u></strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      Pen No: <strong><u></u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Date of Hatch: <strong><u></u></strong>
                    </div>
                  </div>
                </div>
              </div>
              {!! Form::open([ 'method' => 'post']) !!}
                {{-- structure  row -> col -> col: input-field --}}
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s6 m6 l6">
                        <select>
                          <option value="" disabled selected>Select Gender</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select>
                        <label>Gender</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="id_no" type="text" class="validate" name="id_no">
                        <label for="id_no">ID Number</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="date_eggs_collected" type="text" class="datepicker">
                        <label for="date_eggs_collected">Date Eggs Collected</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="total_eggs_collected" type="number" min=0 class="validate" name="total_eggs_collected">
                        <label for="total_eggs_collected">Total Eggs Collected</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="total_egg_weight" type="text" class="validate" name="total_egg_weight">
                        <label for="total_egg_weight">Total Egg Weight (g)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="no_broken" type="number" min=0 class="validate" name="no_broken">
                        <label for="no_broken">No. of Broken Eggs</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="no_shell" type="number" min=0 class="validate" name="no_shell">
                        <label for="no_shell">No. of Soft-shelled/Shell-less</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="feed_offered" type="number" min=0 class="validate" name="feed_offered">
                        <label for="feed_offered">Feed Offered (g)</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="feed_refused" type="number" min=0 class="validate" name="feed_refused">
                        <label for="feed_refused">Feed Refused (g)</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="mortality" type="number" min=0 class="validate" name="mortality">
                        <label for="mortality">Mortality</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="culled" type="number" min=0 class="validate" name="culled">
                        <label for="culled">Culled</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input id="remarks" type="text" class="validate" name="remarks">
                        <label for="remarks">Remarks</label>
                      </div>
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
