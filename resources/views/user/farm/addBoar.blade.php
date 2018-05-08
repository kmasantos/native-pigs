@extends('layouts.farm')

@section('title')
	Native Animals PH | Add Boar
@endsection

@section('content')
	<div class="row">
        <div class="col s12">
          <h4>Individual Records</h4>
          <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s4"><a class="black-text" href="#gm">Morphology</a></li>
                <li class="tab col s4"><a class="black-text" href="#mc">Morphometric</a></li>
                <li class="tab col s4"><a class="black-text" href="#pv">Pedigree</a></li>
              </ul>
            </div>
            <div id="gm" class="col s12">
              <form class="row">
                <div class="col s6 offset-s2">
                  <ul class="collapsible" data-collapsible="expandable">
                    <li>
                      <div class="collapsible-header">Hair type</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="hairtype" type="radio" id="curly"  />
                            <label for="curly">Curly</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="hairtype" type="radio" id="straighthair"  />
                            <label for="straighthair">Straight</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="hairtype" type="radio" id="short"  />
                            <label for="short">Short</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="hairtype" type="radio" id="long"  />
                            <label for="long">Long</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="hairtype" type="radio" id="dense"  />
                            <label for="dense">Dense</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="hairtype" type="radio" id="sparse"  />
                            <label for="sparse">Sparse</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Tusks</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="tusks" type="radio" id="present"  />
                            <label for="present">Present</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="tusks" type="radio" id="absent"  />
                            <label for="absent">Absent</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Snout shape</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="snout" type="radio" id="longthin"  />
                            <label for="longhtin">Long thin</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="snout" type="radio" id="shortcyl"  />
                            <label for="shortcyl">Short cylindrical</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Color pattern</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="colorpattern" type="radio" id="plain"  />
                            <label for="plain">Plain</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="colorpattern" type="radio" id="socksandbelt"  />
                            <label for="socksandbelt">Socks and belt</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="colorpattern" type="radio" id="spotted"  />
                            <label for="spotted">Spotted</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="colorpattern" type="radio" id="otherpattern"  />
                            <label for="otherpattern">Other marks</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Coat color</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="coat" type="radio" id="white"  />
                            <label for="white">White</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="coat" type="radio" id="black"  />
                            <label for="black">Black</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="coat" type="radio" id="brown"  />
                            <label for="brown">Brown</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="coat" type="radio" id="othercolor"  />
                            <label for="othercolor">Others</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Head shape</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="head" type="radio" id="concave"  />
                            <label for="concave">Concave</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="head" type="radio" id="straighthead"  />
                            <label for="straighthead">Straight</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="head" type="radio" id="otherhead"  />
                            <label for="otherhead">Others</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Skin type</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="skin" type="radio" id="smooth"  />
                            <label for="smooth">Smooth</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="skin" type="radio" id="wrinkled"  />
                            <label for="wrinkled">Wrinkled</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Ear type</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="ear" type="radio" id="drooping"  />
                            <label for="drooping">Drooping</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="ear" type="radio" id="semilop"  />
                            <label for="semilop">Semi-lop</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="ear" type="radio" id="erect"  />
                            <label for="erect">Erect</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Backline</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s6">
                            <input class="with-gap" name="backline" type="radio" id="swayback"  />
                            <label for="swayback">Swayback</label>
                          </div>
                          <div class="col s6">
                            <input class="with-gap" name="backline" type="radio" id="straightback"  />
                            <label for="straightback">Straight</label>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header">Other marks</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s10 offset-s1">
                            <input type="text" id="othermarks" class="validate" />
                            <label for="othermarks">Other marks</label>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="col s3 offset-s1 center">
                  <img src="{{asset('images/boar.jpg')}}" height="150" width="150" style="border:2px solid black" />
                </div>
                <div class="col s3 offset-s1 center">
                  Boar ID<br>
                  <input disabled value="QUEBAI" id="segment1" type="text" name="boarid" class="validate col s5" /> <input placeholder="BP20161M" id="segment2" type="text" name="boarid" class="validate col s5 offset-s2"> <input placeholder="2049" id="segment3" type="text" name="boarid" class="validate col s12">
                </div>
                <div class="row">
                  <div class="col s3 offset-s4">
                    <a href="#!" class="btn waves-effect waves-light teal"><i class="material-icons left">save</i>Save</a>
                  </div>
                </div>
              </form>
            </div>
            <div id="mc" class="col s12">
              <form class="row">
                <div class="col s7 offset-s1">
                  <div class="col s6">
                    <ul class="collapsible" data-collapsible="expandable">
                      <li>
                        <div class="collapsible-header">Body weight prior to first breeding</div>
                        <div class="collapsible-body">
                          <input id="bodyweight" placeholder="kg" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Body length</div>
                        <div class="collapsible-body">
                        <input id="bodylength" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Pelvic width</div>
                        <div class="collapsible-body">
                        <input id="pelvic" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Number of normal teats</div>
                        <div class="collapsible-body">
                        <input id="normalteats" placeholder="0" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Head length</div>
                        <div class="collapsible-body">
                          <input id="headlength" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Hearth girth</div>
                        <div class="collapsible-body">
                          <input id="hearthgirth" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Ponderal index</div>
                        <div class="collapsible-body">
                          <input id="pindex" placeholder="kg/m^3" type="text" class="validate" />
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="col s6">
                    <ul class="collapsible" data-collapsible="expandable">
                      <li>
                        <div class="collapsible-header">Birth weight</div>
                        <div class="collapsible-body">
                        <input id="birthweight" placeholder="kg" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Littersize born alive</div>
                        <div class="collapsible-body">
                        <input id="littersize" placeholder="0" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Sex ratio</div>
                        <div class="collapsible-body">
                          <input id="sexratio" placeholder="M:F" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Weaning weight</div>
                        <div class="collapsible-body">
                        <input id="weaningweight" placeholder="kg" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Age at weaning</div>
                        <div class="collapsible-body">
                        <input id="weaningage" placeholder="days" type="text" class="validate" />
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col s3 offset-s1 center">
                  <img src="{{asset('images/boar.jpg')}}" height="150" width="150" style="border:2px solid black" />
                </div>
                <div class="col s3 offset-s1 center">
                  Boar ID<br>
                  <input disabled value="QUEBAI" id="segment1" type="text" name="boarid" class="validate col s5" /> <input placeholder="BP20161M" id="segment2" type="text" name="boarid" class="validate col s5 offset-s2"> <input placeholder="2049" id="segment3" type="text" name="boarid" class="validate col s12">
                </div>
                <div class="row">
                  <div class="col s3 offset-s4">
                    <a href="#!" class="btn waves-effect waves-light teal"><i class="material-icons left">save</i>Save</a>
                  </div>
                </div>
              </form>
            </div>
            <div id="pv" class="col s12 center">
              <img src="{{asset('images/placeholder.jpg')}}" width="80%" height="80%" />
            </div>
          </div>
        </div>
      </div>
@endsection