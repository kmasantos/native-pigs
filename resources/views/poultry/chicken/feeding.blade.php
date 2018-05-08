@extends('layouts.newLayout')

@section('title')
  Feeding Performance
@endsection

@section('initScriptsAndStyles')

@endsection

@section('content')
  <div class="row">
    <div class="col s12 m12 1l2">
      <h4>Feeding Performance</h4>
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
                      Entry Date: <strong><u></u></strong>
                    </div>
                    <div class="col s12 m6 l6">
                      Exit Date: <strong><u>Chicken</u></strong>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col s12 m6 l6">
                      Pen No./Batch No.: <strong><u></u></strong>
                    </div>
                  </div>
                </div>
              </div>
              {!! Form::open([ 'method' => 'post']) !!}
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="input-field col s6 m6 l6">
                        <select>
                          <option value="" disabled selected>Select Month</option>
                          <option value="January">January</option>
                          <option value="February">February</option>
                          <option value="March">March</option>
                          <option value="April">April</option>
                          <option value="May">May</option>
                          <option value="June">June</option>
                          <option value="July">July</option>
                          <option value="August">August</option>
                          <option value="September">September</option>
                          <option value="October">October</option>
                          <option value="November">November</option>
                          <option value="December">December</option>
                        </select>
                        <label>Month</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    Classification
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_0" />
                    <label for="weight_at_0">Brooding</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_21" />
                    <label for="weight_at_21">Hardening</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_45" />
                    <label for="weight_at_45">Growing</label>
                  </div>
                  <div class="col s12 m3 l3">
                    <input class="with-gap" name="weight_at" type="radio" id="weight_at_75" />
                    <label for="weight_at_75">Replacement Stocks</label>
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
                      <input id="type_offered" type="text" class="validate" name="type_offered" placeholder="i.e. Concentrates, Vegetables, Trimmings, etc">
                      <label for="type_offered">Type of Feed Offered</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="amount_offered" type="number" min=0 class="validate" name="amount_offered">
                      <label for="amount_offered">Amount of Feed Offered (g)</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="amount_refused" type="number" min=0 class="validate" name="amount_refused">
                      <label for="amount_refused">Amount of Feed Refusal (g)</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="mortality" type="text" class="validate" name="mortality">
                      <label for="mortality">Mortality</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="culled" type="text" class="validate" name="culled">
                      <label for="culled">Culled</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6">
                      <input id="remarks" type="text" class="validate" name="remarks">
                      <label for="remarks">Remarks</label>
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
