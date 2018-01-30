@extends('layouts.swinedefault')

@section('title')
  Animal Records
@endsection

@section('content')
  <h4 class="headline">Animal Records</h4>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <form class="row">
          <div class="col s12">
            <div class="input-field">
              <input id="search" type="search">
              <label for="search"><i class="material-icons left">search</i>Search Record</label>
              <i class="material-icons">close</i>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col s12">
            <ul class="tabs tabs-fixed-width red darken-4">
              <li class="tab col s6"><a href="#sowrecords">Sow</a></li>
              <li class="tab col s6"><a href="#boarrecords">Boar</a></li>
            </ul>
          </div>
          <div id="sowrecords" class="col s12">
            <table class="centered striped">
              <thead>
                <tr>
                  <th>Registration ID</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($sows as $sow)
                  <tr>
                    <td><a class="modal-trigger" href="#modalsow">{{ $sow->registryid }}</a></td>
                    <td>
                      <a href="{{ URL::route('farm.pig.sow_record_page', [$sow->id]) }}" class="btn-floating yellow waves-light waves-effect modal-trigger"><i class="material-icons">edit</i></a>
                      <a href="#!" class="btn-floating red waves-light waves-effect"><i class="material-icons">delete</i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div id="boarrecords" class="col s12">
            <table class="centered striped">
              <thead>
                <tr>
                  <th>Registration ID</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($boars as $boar)
                  <tr>
                    <td><a class="modal-trigger" href="#modalboar"> {{ $boar->registryid }}</a></td>
                    <td>
                      <a href="{{ URL::route('farm.pig.boar_record_page', [$boar->id]) }}" class="btn-floating yellow waves-light waves-effect modal-trigger"><i class="material-icons">edit</i></a>
                      <a href="#!" class="btn-floating red waves-light waves-effect"><i class="material-icons">delete</i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- Modal Structure -->
            <div id="modalsow" class="modal modal-fixed-footer">
              <div class="modal-content red darken-4 white-text">
                <div class="row">
                  <div class="col s4">
                    <img src="{{asset('images/sow.jpg')}}" width="90%">
                  </div>
                  <div class="col s8">
                    <div class="white black-text">
                      <h5>Registration ID</h5>
                    </div>
                    <div style="margin-top:10px;">
                      <div class="col s5 card-panel white black-text center">
                        <h5>? months</h5>
                        <p>Age</p>
                      </div>
                      <div class="col s5 push-s2 card-panel white black-text center">
                        <h5>? kg</h5>
                        <p>Body Weight</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s6">
                    <table>
                      <tbody>
                        <tr>
                          <td>Hair Type</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Coat Color</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Color Pattern</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Head Shape</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Skin Type</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Ear Type</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Backline</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Other Marks</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col s6">
                    <table>
                      <tbody>
                        <tr>
                          <td>Age at First Mating</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Final Weight at 8 Months</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Head Length</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Body Length</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Pelvic Width</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Heart Girth</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Ponderal Index</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Number of Normal Teats</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row center">
                  <div class="col s6 push-s3">
                    <table>
                      <tbody>
                        <tr>
                          <td>Body Weight at 45 Days</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Body Weight at 60 Days</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Body Weight at 180 Days</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer red lighten-2">
                <a href="#!" class="modal-action modal-close waves-effect waves-light btn-flat">Close</a>
              </div>
            </div>
            <div id="modalboar" class="modal modal-fixed-footer">
              <div class="modal-content red darken-4 white-text">
                <div class="row">
                  <div class="col s4">
                    <img src="{{asset('images/boar.jpg')}}" width="90%">
                  </div>
                  <div class="col s8">
                    <div class="white black-text">
                      <h5>Registration ID</h5>
                    </div>
                    <div style="margin-top:10px;">
                      <div class="col s5 card-panel white black-text center">
                        <h5>? months</h5>
                        <p>Age</p>
                      </div>
                      <div class="col s5 push-s2 card-panel white black-text center">
                        <h5>? kg</h5>
                        <p>Body Weight</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s6">
                    <table>
                      <tbody>
                        <tr>
                          <td>Hair Type</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Coat Color</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Color Pattern</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Head Shape</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Skin Type</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Ear Type</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Backline</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Other Marks</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col s6">
                    <table>
                      <tbody>
                        <tr>
                          <td>Age at First Mating</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Final Weight at 8 Months</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Head Length</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Body Length</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Pelvic Width</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Heart Girth</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Ponderal Index</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Number of Normal Teats</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row center">
                  <div class="col s6 push-s3">
                    <table>
                      <tbody>
                        <tr>
                          <td>Body Weight at 45 Days</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Body Weight at 60 Days</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Body Weight at 180 Days</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer red lighten-2">
                <a href="#!" class="modal-action modal-close waves-effect waves-light btn-flat">Close</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection