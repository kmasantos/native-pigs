@extends('layouts.farm')

@section('title')
	Native Animals PH | Duck Individual Records
@endsection

@section('initScript')
	<link type="text/css" rel="stylesheet" href="{{asset('css/record.css')}}"  media="screen,projection"/>
@endsection

@section('content')
<div class="row">
	<div class="col s10">
		<div class="col s12">
          <h4>Individual Records</h4>
          <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s6"><a class="black-text" href="#gm">Phenotypic</a></li>
                <li class="tab col s6"><a class="black-text" href="#mc">Morphometric</a></li>	
              </ul>
            </div>

            <div id="gm" class="col s12">
              <form class="row">
                <div class="col s6 offset-s2">
                  <ul class="collapsible" data-collapsible="expandable">
	                    <li>
	                      <div class="collapsible-header">Plumage Pattern</div>
	                      <div class="collapsible-body">
	                      	<div class="row">
	                      		<div class="col s12 m6 l6">
	                      			<input name="plummagepattern" type="radio" id="ppdusky" />
	      							<label for="ppdusky">Dusky</label>
	                      		</div>
	                      		<div class="col s12 m6 l6">
	                      			<input name="plummagepattern" type="radio" id="ppplainbrown" />
	      							<label for="ppplainbrown">Plain Brown</label>
	                      		</div>
	                      	</div>
	                        
	                      	<div class="row">
	                      		<div class="col s12 m6 l6">
	                      			<input name="plummagepattern" type="radio" id="ppmagpie" />
	      							<label for="ppmagpie">Magpie</label>
	                      		</div>
	                      		<div class="col s12 m6 l6">
	                      			<input name="plummagepattern" type="radio" id="ppmallard" />
	      							<label for="ppmallard">Mallard</label>
	                      		</div>
	                      	</div>

	                      	<div class="row">
	                      		<div class="col s12 m12 l12">
	                      			<input name="plummagepattern" type="radio" id="pprestricted" />
	      							<label for="pprestricted">Restricted</label>
	                      		</div>
	                      	</div>
	                      </div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Plumage Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="plummagecolor" type="radio" id="pcwhite"  />
										<label for="pcwhite">White</label>
									</div>
									<div class="col s6">
										<input  name="plummagecolor" type="radio" id="pcbrown"  />
										<label for="pcbrown">Brown</label>
									</div>
								</div>

								<div class="row">
									<div class="col s6">
										<input  name="plummagecolor" type="radio" id="pcblack"/>
										<label for="pcblack">Black</label>
									</div>
									<div class="col s6">
										<input  name="plummagecolor" type="radio" id="pcblackbrown"/>
										<label for="pcblackbrown">Black with brown</label>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<input  name="plummagecolor" type="radio" id="pcbrownblack"/>
										<label for="pcbrownblack">Brown with black</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Neck Feather Markings</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
									<input  name="neckfeathermark" type="radio" id="nfplain"  />
									<label for="nfplain">Plain</label>
									</div>
									<div class="col s6">
									<input  name="neckfeathermark" type="radio" id="nfbib"  />
									<label for="nfbib">With bib</label>
								</div>
								
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="neckfeathermark" type="radio" id="nfsmall"  />
										<label for="nfsmall">Small</label>
									</div>
									<div class="col s6">
										<input  name="neckfeathermark" type="radio" id="nfmedium"  />
										<label for="nfmedium">Medium</label>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<input  name="neckfeathermark" type="radio" id="nflarge"  />
										<label for="nflarge">Large</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Wing Feather Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="wingfeathercolor" type="radio" id="wfwhite"  />
										<label for="wfwhite">White</label>
									</div>
									<div class="col s6">
										<input  name="wingfeathercolor" type="radio" id="wfbrown"  />
										<label for="wfbrown">Brown</label>
									</div>
								</div>

								<div class="row">
									<div class="col s6">
										<input  name="wingfeathercolor" type="radio" id="wfblack"  />
										<label for="wfblack">Black</label>
									</div>
									<div class="col s6">
										<input  name="wingfeathercolor" type="radio" id="wfbrownwhite"  />
										<label for="wfbrownwhite">Brown with White</label>
									</div>
									
								</div>
								<div class="row">
									<div class="col s12">
										<input  name="wingfeathercolor" type="radio" id="wfblackwhite"  />
										<label for="wfblackwhite">Black with White</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Tail Feather Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="tailfeathercolor" type="radio" id="fcwhite"  />
										<label for="fcwhite">White</label>
									</div>
									<div class="col s6">
										<input  name="tailfeathercolor" type="radio" id="fcblack"  />
										<label for="fcblack">Black</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="tailfeathercolor" type="radio" id="fcbrown"  />
										<label for="fcbrown">Brown</label>
									</div>
									<div class="col s6">
										<input  name="tailfeathercolor" type="radio" id="fcbrownwhite"  />
										<label for="fcbrownwhite">Brown with White</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Bill Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcpink-white"  />
										<label for="bcpink-white">Pink-white</label>
									</div>
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcyellow"  />
										<label for="bcyellow">Yellow</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcorange"  />
										<label for="bcorange">Orange</label>
									</div>
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcslate-grey"  />
										<label for="bcslate-grey">Slate-grey</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcgreen"  />
										<label for="bcgreen">Green</label>
									</div>
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcblack"  />
										<label for="bcblack">Black</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcblacktip"  />
										<label for="bcblacktip">Black-tip</label>
									</div>
									<div class="col s6">
										<input  name="billcolor" type="radio" id="bcothers"  />
										<label for="bcothers">Others</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Bill Shape</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="billshape" type="radio" id="bsuniform"  />
										<label for="bsuniform">Uniform</label>
									</div>
									<div class="col s6">
										<input  name="billshape" type="radio" id="bssaddle"  />
										<label for="bssaddle">Saddle</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Bean Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="beancolor" type="radio" id="bncwhite"  />
										<label for="bncwhite">White</label>
									</div>
									<div class="col s6">
										<input  name="beancolor" type="radio" id="bncdarkbrown"  />
										<label for="bncdarkbrown">Dark Brown</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="beancolor" type="radio" id="bncblack"  />
										<label for="bncblack">Black</label>
									</div>
									<div class="col s6">
										<input  name="beancolor" type="radio" id="bncothers"  />
										<label for="bncothers">Others</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Crested</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="crested" type="radio" id="crestedyes"  />
										<label for="crestedyes">Yes</label>
									</div>
									<div class="col s6">
										<input  name="crested" type="radio" id="crestedno"  />
										<label for="crestedno">No</label>
									</div>
								</div>
							</div>
	                    </li>

	                    <li>
							<div class="collapsible-header">Eye Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="eyecolor" type="radio" id="ecyellow"  />
										<label for="ecyellow">Yellow</label>
									</div>
									<div class="col s6">
										<input  name="eyecolor" type="radio" id="ecorange"  />
										<label for="ecorange">Orange</label>
									</div>
									
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="eyecolor" type="radio" id="ecbrown"  />
										<label for="ecbrown">Brown</label>
									</div>
									<div class="col s6">
										<input  name="eyecolor" type="radio" id="ecgreybrown"  />
										<label for="ecgreybrown">Grey-brown</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="eyecolor" type="radio" id="ecblue"  />
										<label for="ecblue">Blue</label>
									</div>
									<div class="col s6">
										<input  name="eyecolor" type="radio" id="ecblack"  />
										<label for="ecblack">Black</label>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<input  name="eyecolor" type="radio" id="ecothers"  />
										<label for="ecothers">Others</label>
									</div>
								</div>
							</div>
	                    </li>

						<li>
							<div class="collapsible-header">Skin Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="skincolor" type="radio" id="skincolwhite"  />
										<label for="skincolwhite">White</label>
									</div>
									<div class="col s6">
										<input  name="skincolor" type="radio" id="skincolyellow"  />
										<label for="skincolyellow">Yellow</label>
									</div>
									
								</div>
								<div class="row">
									<div class="col s12">
										<input  name="skincolor" type="radio" id="skincolblack"  />
										<label for="skincolblack">Black</label>
									</div>
								</div>
							</div>
						</li>

						<li>
							<div class="collapsible-header">Shank Color</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="shankcolor" type="radio" id="shankyellow"  />
										<label for="shankyellow">Yellow</label>
									</div>
									<div class="col s6">
										<input  name="shankcolor" type="radio" id="shankwhite"  />
										<label for="shankwhite">White</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="shankcolor" type="radio" id="shankblack"  />
										<label for="shankblack">Black</label>
									</div>
									<div class="col s6">
										<input  name="shankcolor" type="radio" id="shankgreen"  />
										<label for="shankgreen">Green</label>
									</div></div>
								<div class="row">
									<div class="col s6">
										<input  name="shankcolor" type="radio" id="shankslategrey"  />
										<label for="shankslategrey">Slate-grey</label>
									</div>
									<div class="col s6">
										<input  name="shankcolor" type="radio" id="shankorange"  />
										<label for="shankorange">Orange</label>
									</div>
								</div>
							</div>
	                    </li>

						<li>
							<div class="collapsible-header">Body Carriage</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="col s6">
										<input  name="bodycarriage" type="radio" id="bcarriagehorizontal"  />
										<label for="bcarriagehorizontal">Horizontal</label>
									</div>
									<div class="col s6">
										<input  name="bodycarriage" type="radio" id="bcarriageslightlyupright"  />
										<label for="bcarriageslightlyupright">Slightly Upright</label>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<input  name="bodycarriage" type="radio" id="bcarriageupright"  />
										<label for="bcarriageupright">Upright</label>
									</div>	
								</div>
							</div> 
						</li>
                 	</ul>
                 </div>
					<div class="col s3 offset-s1 center">
						<img src="images/sow.jpg" height="150" width="150" style="border:2px solid black" />
					</div>
					<div class="col s3 offset-s1 center">
						Duck ID<br>
						<input disabled value="QUEBAI" id="segment1" type="text" name="sowid" class="validate col s5" /> <input placeholder="BP20161F" id="segment2" type="text" name="sowid" class="validate col s5 offset-s2"> <input placeholder="2050" id="segment3" type="text" name="sowid" class="validate col s12">
					</div>
					<div class="row">
						<div class="col s3 offset-s4">
							<a href="#!" class="btn waves-effect waves-light green darken-4"><i class="material-icons left">save</i>Save</a>
						</div>
					</div>
				</form>
            </div>

            <div id="mc" class="col s12">
              <form class="row">
                <div class="col s7 offset-s1">
                  <div class="col s8">
                    <ul class="collapsible" data-collapsible="expandable">
                      <li>
                        <div class="collapsible-header">Body weight</div>
                        <div class="collapsible-body">
                          <input id="bodyweight" placeholder="kg" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Wing Span</div>
                        <div class="collapsible-body">
                        <input id="wingspan" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Bill Length</div>
                        <div class="collapsible-body">
                        <input id="billlength" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Circumference of the Chest</div>
                        <div class="collapsible-body">
                        <input id="chestcircumference" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Body Length</div>
                        <div class="collapsible-body">
                          <input id="bodylength" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Neck Length</div>
                        <div class="collapsible-body">
                          <input id="necklength" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                      <li>
                        <div class="collapsible-header">Shank Length</div>
                        <div class="collapsible-body">
                          <input id="shanklength" placeholder="cm" type="text" class="validate" />
                        </div>
                      </li>
                    </ul>
                  </div>
                  
                <div class="col s3 offset-s1 center">
                  <img src="images/sow.jpg" height="150" width="150" style="border:2px solid black" />
                </div>
                <div class="col s3 offset-s1 center">
                  Duck ID<br>
                  <input disabled value="QUEBAI" id="segment1" type="text" name="sowid" class="validate col s5" /> <input placeholder="BP20161F" id="segment2" type="text" name="sowid" class="validate col s5 offset-s2"> <input placeholder="2050" id="segment3" type="text" name="sowid" class="validate col s12">
                </div>
                <div class="row">
                  <div class="col s3 offset-s4">
                    <a href="#!" class="btn waves-effect waves-light green darken-4"><i class="material-icons left">save</i>Save</a>
                  </div>
                </div>
              </form>
            </div>

           
          </div>
        </div>

	</div>
</div>
@endsection
@section('script')
	<script type="text/javascript" src="{{asset('js/record.js')}}"></script>
@endsection