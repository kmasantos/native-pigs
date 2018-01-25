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
              <li class="tab col s6"><a href="#tab1">Sow</a></li>
              <li class="tab col s6"><a href="#tab2">Boar</a></li>
            </ul>
          </div>
          <div id="tab1" class="col s12">
            <table class="centered striped">
              <thead>
                <tr>
                  <th>Registration ID</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pigs as $pig)
                  <tr>
                    <td><a class="modal-trigger" href="#modalsow">{{ $pig->registryid }}</a></td>
                    <td>
                      <a href="#modal2" class="btn-floating yellow waves-light waves-effect modal-trigger"><i class="material-icons">edit</i></a>
                      <a href="#!" class="btn-floating red waves-light waves-effect"><i class="material-icons">delete</i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div id="tab2" class="col s12">
            <table class="centered striped">
              <thead>
                <tr>
                  <th>Registration ID</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                  <tr>
                    <td><a class="modal-trigger" href="#modalboar"></a></td>
                    <td>
                      <a href="#modal2" class="btn-floating yellow waves-light waves-effect modal-trigger"><i class="material-icons">edit</i></a>
                      <a href="#!" class="btn-floating red waves-light waves-effect"><i class="material-icons">delete</i></a>
                    </td>
                  </tr>

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
                  <div class="col s12">
                    what to display, what to view
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
              </div>
              <div class="modal-footer red lighten-2">
                <a href="#!" class="modal-action modal-close waves-effect waves-light btn-flat">Close</a>
              </div>
            </div>
            <div id="modal2" class="modal modal-fixed-footer">
              <div class="modal-content red darken-4 white-text">
                <h5 class="center">Edit Record</h5>
                <form>
                  <div class="row">
                    <div class="col s10 offset-s1 black-text">
                      <div class="row">
                        <ul class="collapsible" data-collapsible="expandable">
                          <!--GROSS MORPHOLOGY-->
                          <li>
                            <div class="collapsible-header">GROSS MORPHOLOGY</div>
                            <div class="collapsible-body grey lighten-2">
                              <ul class="collection with-header">
                                <li class="collection-header">Hair Type</li>
                                <li class="collection-item">
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="hair_type1" type="radio" id="hair_type1_curly" value="Curly" />
                                      <label for="hair_type1_curly">Curly</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="hair_type1" type="radio" id="hair_type1_straight" value="Straight" />
                                      <label for="straighthair">Straight</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="hair_type2" type="radio" id="hair_type2_short" value="Short" />
                                      <label for="hair_type2_short">Short</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="hair_type2" type="radio" id="hair_type2_long" value="Long" />
                                      <label for="hair_type2_long">Long</label>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Coat Color</li>
                                <li class="collection-item">
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="coat_color" type="radio" id="coat_color_black" value="Black" />
                                      <label for="coat_color_black">Black</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="coat_color" type="radio" id="coat_color_others" value="Others" />
                                      <label for="coat_color_others">Others</label>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Color Pattern</li>
                                <li class="collection-item">
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_plain" value="Plain" />
                                      <label for="color_pattern_plain">Plain</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="color_pattern" type="radio" id="color_pattern_socks" value="Socks" />
                                      <label for="color_pattern_socks">Socks</label>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Head Shape</li>
                                <li class="collection-item">
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="head_shape" type="radio" id="head_shape_concave" value="Concave" />
                                      <label for="head_shape_concave">Concave</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="head_shape" type="radio" id="head_shape_straight" value="Straight" />
                                      <label for="head_shape_straight">Straight</label>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Skin Type</li>
                                <li class="collection-item">
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="skin_type" type="radio" id="skin_type_smooth" value="Smooth" />
                                      <label for="skin_type_smooth">Smooth</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="skin_type" type="radio" id="skin_type_wrinkled" value="Wrinkled" />
                                      <label for="skin_type_wrinkled">Wrinkled</label>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Ear Type</li>
                                <li class="collection-item">
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="ear_type" type="radio" id="ear_type_drooping" value="Drooping" />
                                      <label for="ear_type_drooping">Drooping</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="ear_type" type="radio" id="ear_type_semilop" value="Semi-lop" />
                                      <label for="ear_type_semilop">Semi-lop</label>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="ear_type" type="radio" id="ear_type_erect" value="Erect" />
                                      <label for="ear_type_erect">Erect</label>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Backline</li>
                                <li class="collection-item">
                                  <div class="row">
                                    <div class="col s6">
                                      <input class="with-gap" name="backline" type="radio" id="backline_swayback" value="Swayback" />
                                      <label for="backline_swayback">Swayback</label>
                                    </div>
                                    <div class="col s6">
                                      <input class="with-gap" name="backline" type="radio" id="backline_straight" value="Straight" />
                                      <label for="backline_straight">Straight</label>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Other Marks</li>
                                <li class="collection-item">
                                  <p class="grey-text">Enter mark/s separated by comma/s (,)</p>
                                  <div class="input-field col s8 offset-s2">
                                    <input id="other_marks" type="text" name="other_marks" class="validate">
                                    <label for="other_marks">Other marks</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </li>
                          <!--MORPHOMETRIC CHARACTERISTICS-->
                          <li>
                            <div class="collapsible-header">MORPHOMETRIC CHARACTERISTICS</div>
                            <div class="collapsible-body grey lighten-2">
                              <ul class="collection with-header">
                                <li class="collection-header">Age at First Mating, months</li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <input id="age_at_first_mating" type="text" name="age_at_first_mating" class="validate">
                                    <label for="age_at_first_mating">Age</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Final Weight at 8 Months, kg</li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <input id="final_weight_at_8_months" type="text" name="final_weight_at_8_months" class="validate">
                                    <label for="final_weight_at_8_months">Final weight</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Head Length, cm</li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <input id="head_length" type="text" name="head_length" class="validate">
                                    <label for="head_length">Head length</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Body Length, cm</li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <input id="body_length" type="text" name="body_length" class="validate">
                                    <label for="body_length">Body length</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Pelvic Width, cm</li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <input id="pelvic_width" type="text" name="pelvic_width" class="validate">
                                     <label for="pelvic_width">Pelvic width</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Heart Girth, cm</li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <input id="heart_girth" type="text" name="heart_girth" class="validate">
                                    <label for="heart_girth">Heart girth</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Ponderal Index, kg/m<sup>3</sup></li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <input disabled id="ponderal_index" type="text" name="ponderal_index" class="validate">
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Number of Normal Teats</li>
                                <li class="collection-item">
                                  <div class="input-field col s8 offset-s2">
                                    <p class="range-field">
                                    <input type="range" id="number_of_normal_teats" name="number_of_normal_teats" min="8" max="16" />
                                  </p>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </li>
                          <!-- BODY WEIGHTS -->
                          <li>
                            <div class="collapsible-header">BODY WEIGHTS</div>
                            <div class="collapsible-body grey lighten-2">
                              <ul class="collection with-header">
                                <li class="collection-header">Body Weight at 45 Days</li>
                                <li class="collection-item">
                                  <div class="input-field col s4 offset-s1">
                                    <input id="body_weight_at_45_days" type="text" name="body_weight_at_45_days" class="validate">
                                    <label for="body_weight_at_45_days">Body Weight at 45 days</label>
                                  </div>
                                  <div class="input-field col s4 offset-s1">
                                    <input id="date_collected_45_days" type="text" name="date_collected_45_days" class="datepicker">
                                    <label for="date_collected_45_days">Date Collected</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Body Weight at 60 days</li>
                                <li class="collection-item">
                                  <div class="input-field col s4 offset-s1">
                                    <input id="body_weight_at_60_days" type="text" name="body_weight_at_60_days" class="validate">
                                    <label for="b6body_weight_at_60_days0d">Body Weight at 60 Days</label>
                                  </div>
                                  <div class="input-field col s4 offset-s1">
                                    <input id="date_collected_60_days" type="text" name="date_collected_60_days" class="datepicker">
                                    <label for="date_collected_60_days">Date Collected</label>
                                  </div>
                                </li>
                              </ul>
                              <ul class="collection with-header">
                                <li class="collection-header">Body Weight at 180 Days</li>
                                <li class="collection-item">
                                  <div class="input-field col s4 offset-s1">
                                    <input id="body_weight_at_180_days" type="text" name="body_weight_at_180_days" class="validate">
                                    <label for="body_weight_at_180_days">Body Weight at 180 Days</label>
                                  </div>
                                  <div class="input-field col s4 offset-s1">
                                    <input id="date_collected_180_days" type="text" name="date_collected_180_days" class="datepicker">
                                    <label for="date_collected_180_days">Date Collected</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer red darken-4">
                  <button class="btn waves-effect waves-light red lighten-2" type="submit">Save
                    <i class="material-icons right">save</i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection