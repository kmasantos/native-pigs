@extends('layouts.swinedefault')

@section('title')
  Add Boar
@endsection

@section('initScripts')
  <link type="text/css" rel="stylesheet" href="{{asset('css/pigs.css')}}"  media="screen,projection"/>
@endsection

@section('content')
  <main>
    <div class="container">
      <div class="row">
        <h4>Add Boar</h4>
        <div class="divider"></div>
        {!! Form::open(['route' => 'farm.pig.submit_boar_record', 'method' => 'post']) !!}
        <div class="col s12">
          <div class="row center">
            <div class="col s11 offset-s1 card-panel red darken-4 white-text">
              <div class="input-field col s3 push-s2">
                Year of Birth
                <input placeholder="2016" id="yearofbirth" type="text"  name="yearofbirth">
                {{-- <label for="yearofbirth"></label> --}}
              </div>
              <div class="input-field col s3 push-s4">
                Earnotch Number
                <input placeholder="5678" id="animalid" type="text" class="validate" name="earnotchnumber">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col s12">
              <div class="row">
                <div class="col s11 offset-s1 red darken-4">
                  <ul class="tabs tabs-fixed-width red darken-4">
                    <li class="tab col s6"><a href="#tab1">Gross Morphology</a></li>
                    <li class="tab col s6"><a href="#tab2">Morphometric Characteristics</a></li>
                  </ul>
                </div>
                <!--GROSS MORPHOLOGY-->
                <div id="tab1" class="col s11 offset-s1 grey lighten-2">
                  <ul class="collection with-header">
                    <li class="collection-header">Hair type</li>
                    <li class="collection-item">
                      <input type="hidden" name="hairtypelabel" value="Hair Type">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="hairtype1" type="radio" id="curlyhair" value="Curly" />
                          <label for="curlyhair">Curly</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="hairtype1" type="radio" id="straighthair" value="Straight"/>
                          <label for="straighthair">Straight</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="hairtype2" type="radio" id="short"  value="Short"/>
                          <label for="short">Short</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="hairtype2" type="radio" id="long"  value="Long"/>
                          <label for="long">Long</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="hairtype3" type="radio" id="dense"  value="Dense"/>
                          <label for="dense">Dense</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="hairtype3" type="radio" id="sparse" value="Sparse" />
                          <label for="sparse">Sparse</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Tusks</li>
                    <input type="hidden" name="tusklabel" value="Tusks">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="tusks" type="radio" id="present" value="Present" />
                          <label for="present">Present</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="tusks" type="radio" id="absent" value="Absent" />
                          <label for="absent">Absent</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Snout shape</li>
                    <input type="hidden" name="snoutshapelabel" value="Snout Shape">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="snout" type="radio" id="curve" value="Curve" />
                          <label for="curve">Curve</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="snout" type="radio" id="straightsnout" value="Straight" />
                          <label for="straightsnout">Straight</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="snout" type="radio" id="shortcyl" value="Short and Cylindrical" />
                          <label for="shortcyl">Short and cylindrical</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="snout" type="radio" id="longthin" value="Long and Thin" />
                          <label for="longthin">Long and thin</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Coat color</li>
                    <input type="hidden" name="coatcolorlabel" value="Coat Color">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="coat" type="radio" id="whitecoat" value="White" />
                          <label for="whitecoat">White</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="coat" type="radio" id="blackcoat" value="Black" />
                          <label for="blackcoat">Black</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="coat" type="radio" id="redcoat" value="Red" />
                          <label for="redcoat">Red</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="coat" type="radio" id="fawncoat" value="Fawn" />
                          <label for="fawncoat">Fawn</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="coat" type="radio" id="graycoat" value="Gray" />
                          <label for="graycoat">Gray</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="coat" type="radio" id="othercoat" value="Others" />
                          <label for="othercoat">Others</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Color pattern</li>
                    <input type="hidden" name="colorpatternlabel" value="Color Pattern">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="pattern" type="radio" id="plain" value="Plain" />
                          <label for="plain">Plain</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="pattern" type="radio" id="socksbelt" value="Socks and Belt" />
                          <label for="socksbelt">Socks and belt</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="pattern" type="radio" id="spotted" value="Spotted" />
                          <label for="spotted">Spotted</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="pattern" type="radio" id="patchy" value="Patchy" />
                          <label for="patchy">Patchy</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Head shape</li>
                    <input type="hidden" name="headshapelabel" value="Head Shape">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="headshape" type="radio" id="concave" value="Concave" />
                          <label for="concave">Concave</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="headshape" type="radio" id="convex" value="Convex" />
                          <label for="convex">Convex</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="headshape" type="radio" id="straighthead" value="Straight" />
                          <label for="straighthead">Straight</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="headshape" type="radio" id="otherhead" value="Others" />
                          <label for="otherhead">Others</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Skin type</li>
                    <input type="hidden" name="skintypelabel" value="Skin Type">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="skin" type="radio" id="smooth" value="Smooth" />
                          <label for="smooth">Smooth</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="skin" type="radio" id="wrinkled" value="Wrinkled" />
                          <label for="wrinkled">Wrinkled</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Ear type</li>
                    <input type="hidden" name="eartypelabel" value="Ear Type">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="eartype" type="radio" id="droopy" value="Droopy" />
                          <label for="droopy">Droopy</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="eartype" type="radio" id="semilop" value="Semi-lop" />
                          <label for="semilop">Semi-lop</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="eartype" type="radio" id="erect" value="Erect" />
                          <label for="erect">Erect</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="eartype" type="radio" id="lop" value="Lop" />
                          <label for="lop">Lop</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Ear orientation</li>
                    <input type="hidden" name="earorientationlabel" value="Ear Orientation">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="earorientation" type="radio" id="forwards" value="Projects Forward" />
                          <label for="forwards">Project forwards</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="earorientation" type="radio" id="backwards" value="Backwards" />
                          <label for="backwards">Backwards</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Tail type</li>
                    <input type="hidden" name="tailtypelabel" value="Tail Type">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="tailtype" type="radio" id="straighttail" value="Straight" />
                          <label for="straighttail">Straight</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="tailtype" type="radio" id="curlytail" value="Curly" />
                          <label for="curlytail">Curly</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Backline</li>
                    <input type="hidden" name="backlinelabel" value="Backline">
                    <li class="collection-item">
                      <div class="row">
                        <div class="col s6">
                          <input class="with-gap" name="backline" type="radio" id="swayback" value="Swayback" />
                          <label for="swayback">Swayback</label>
                        </div>
                        <div class="col s6">
                          <input class="with-gap" name="backline" type="radio" id="straightback" value="Straight" />
                          <label for="straightback">Straight</label>
                        </div>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Other marks</li>
                    <input type="hidden" name="othermarkslabel" value="Other Marks">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input id="othermarks" type="text" name="othermarks" class="validate">
                        <label for="othermarks">Other marks</label>
                      </div>
                    </li>
                  </ul>
                  <div class="center" style="padding-bottom: 20px;">
                    <button class="btn waves-effect waves-light green darken-4">Save <i class="material-icons right">save</i></button>
                  </div>
                </div>
                <!--MORPHOMETRIC CHARACTERISTICS-->
                <div id="tab2" class="col s11 offset-s1 grey lighten-2">
                  <ul class="collection with-header">
                    <li class="collection-header">Body length, cm</li>
                    <input type="hidden" name="blengthlabel" value="Body lenght (cm)">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input id="bodylength" type="text" name="bodylength" class="validate">
                        <label for="bodylength">Body length</label>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Pelvic width, cm</li>
                    <input type="hidden" name="pwidthlabel" value="Pelvic width (cm)">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input id="pelvic" type="text" name="pelvic" class="validate">
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Head length, cm</li>
                    <input type="hidden" name="hlengthlabel" value="Head lenght (cm)">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input id="headlength" type="text" name="headlength" class="validate">
                        <label for="headlength">Head length</label>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Heart girth, cm</li>
                    <input type="hidden" name="hgirthlabel" value="Hearth girth (cm)">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input id="hearthgirth" type="text" name="hearthgirth" class="validate">
                        <label for="hearthgirth">Hearth girth</label>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Ponderal index, kg/m<sup>3</sup></li>
                    <input type="hidden" name="pindexlabel" value="Ponderal index (kg)">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input disabled id="ponderalindex" type="text" name="ponderalindex" class="validate">
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Age at first mating, months</li>
                    <input type="hidden" name="ageatmatelabel" value="Age at First Mating (months)">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input id="agefirstmating" type="text" name="agefirstmating" class="validate">
                        <label for="agefirstmating">Age</label>
                      </div>
                    </li>
                  </ul>
                  <ul class="collection with-header">
                    <li class="collection-header">Final weight at 8 months, kg</li>
                    <input type="hidden" name="bweightfinallabel" value="Final weight at 8 months (kg)">
                    <li class="collection-item">
                      <div class="input-field col s8 offset-s2">
                        <input id="weighteight" type="text" name="weighteight" class="validate">
                        <label for="weighteight">Final weight</label>
                      </div>
                    </li>
                  </ul>
                  <div class="center" style="padding-bottom: 20px;">
                    <button class="btn waves-effect waves-light green darken-4">Save <i class="material-icons right">save</i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </main>

@endsection

@section('scripts')
  {{-- <script type="text/javascript" src="{{asset('js/global.js')}}"></script> --}}
@endsection
