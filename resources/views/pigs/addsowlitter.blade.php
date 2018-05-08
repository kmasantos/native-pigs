@extends('layouts.swinedefault ')

@section('initScriptsAndStyles')
  <link type="text/css" rel="stylesheet" href="{{ asset('css/pig.css') }}"  media="screen,projection"/>
@endsection

@section('title')
  Sow Litter Record
@endsection

@section('content')
  <main>
    <div class="container">
      <div class="row">
          <h4>Sow Litter Record</h4>
          <div class="divider"></div>
          <form class="row">
          <div class="col s12">
            <div class="row center">
              <div class="col s11 offset-s1 card-panel red darken-4 white-text">
                <div class="input-field col s3 push-s2">
                  Sow ID
                  <input placeholder="QUEBAIBP-20161F1000" id="sowid" type="text" class="validate">
                </div>
                <div class="input-field col s3 push-s4">
                  Boar ID
                  <input placeholder="QUEBAIBP-20162M2000" id="boarid" type="text" class="validate">
                </div>
              </div>
            </div>
            <div class="row center">
              <div class="col s11 offset-s1 card-panel grey lighten-2">
                <div class="row">
                  <div class="col s8">
                    <table class="centered striped">
                      <thead>
                        <tr>
                            <th>Offspring ID</th>
                            <th>Sex</th>
                            <th>Birth weight, kg</th>
                            <th>Weaning weight, kg</th>
                            <th>Remarks</th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                          <td>3000</td>
                          <td>F</td>
                          <td>10</td>
                          <td>20</td>
                          <td>...</td>
                        </tr>
                        <tr>
                          <td>...</td>
                          <td>...</td>
                          <td>...</td>
                          <td>...</td>
                          <td>...</td>
                        </tr>
                        <tr>
                          <td>...</td>
                          <td>...</td>
                          <td>...</td>
                          <td>...</td>
                          <td>...</td>
                        </tr>
                      </tbody>
                    </table>

                    <h5 class="white">Add offspring</h5>
                    <div class="input-field col s4">
                      <input id="offspringearnotch" type="text" name="offspringearnotch" class="validate">
                      <label for="offspringearnotch">Offspring Earnotch</label>
                    </div>
                    <div class="input-field col s4">
                      <input id="sex" type="text" name="sex" class="validate">
                      <label for="sex">Sex (M/F)</label>
                    </div>
                    <div class="input-field col s4">
                      <input id="remarks" type="text" name="remarks" class="validate">
                      <label for="remarks">Remarks</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="birthweight" type="text" name="birthweight">
                      <label for="birthweight">Birth Weight, kg</label>
                    </div>
                    <div class="input-field col s6">
                      <input id="weaningweight" type="text" name="weaningweight">
                      <label for="weaningweight">Weaning Weight, kg</label>
                    </div>
                    <a href="#!" class="btn green darken-4 waves-light waves-effect">Add</a>
                  </div>
                  <div class="col s4">
                    <div class="card-panel red darken-4">
                      <ul class="collection with-header">
                        <li class="collection-header">Date Bred</li>
                        <li class="collection-item">
                          <div class="input-field">
                            <input id="datebred" type="text" placeholder="Pick date" name="datebred" class="datepicker">
                          </div>
                        </li>
                      </ul>
                      <ul class="collection with-header">
                        <li class="collection-header">Date Farrowed</li>
                        <li class="collection-item">
                          <div class="input-field">
                            <input id="datefarrowed" type="text" placeholder="Pick date" name="datefarrowed" class="datepicker">
                          </div>
                        </li>
                      </ul>
                      <ul class="collection with-header">
                        <li class="collection-header">Date Weaned</li>
                        <li class="collection-item">
                          <div class="input-field">
                            <input id="dateweaned" type="text" placeholder="Pick date" name="dateweaned" class="datepicker">
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>

@endsection

@section('scripts')
  {{-- <script type="text/javascript" src="{{asset('js/custom.js')}}"></script> --}}
@endsection
