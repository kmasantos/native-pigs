@extends('layouts.swinedefault')

@section('title')
  View Sow
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.breeder_records')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> View Sow</h4>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <div class="row">
          <div class="col s4">
            <img src="{{asset('images/sow.jpg')}}" width="95%">
          </div>
          <div class="col s8">
            <div class="white black-text">
              <h5><strong>{{ $sow->registryid }}</strong></h5>
            </div>
            <div style="margin-top:10px;">
              <div class="col s12 card-panel white black-text">
                <div class="col s6">
                  @if(is_null($properties->where("property_id", 3)->first()))
                    <p><strong>Birth date:</strong> No data available</p>
                  @else
                    @if($properties->where("property_id", 3)->first()->value == "Not specified")
                      <p><strong>Birth date:</strong> No data available</p>
                    @else
                      <p><strong>Birth date:</strong> {{ Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->format('j F, Y') }}</p>
                    @endif
                  @endif
                  @if($parity_born == "")
                    <p><strong>Parity born:</strong> No data available</p>
                  @else
                    <p><strong>Parity born:</strong> {{ $parity_born }}</p>
                  @endif
                  @if(is_null($properties->where("property_id", 5)->first()))
                    <p><strong>Birth weight:</strong> No data available</p>
                  @else
                    @if($properties->where("property_id", 5)->first()->value == "")
                      <p><strong>Birth weight:</strong> No data available</p>
                    @else
                      <p><strong>Birth weight:</strong> {{ $properties->where("property_id", 5)->first()->value }} kg</p>
                    @endif
                  @endif
                  @if(is_null($sow->getGrouping()))
                    <p><strong>Litter-size Born Alive:</strong> No data available</p>
                  @else
                    <p><strong>Littersize Born Alive:</strong> {{ count($sow->getGrouping()->getGroupingMembers()) }}</p>
                  @endif
                </div>
                <div class="col s6">
                  @if(is_null($sow->getGrouping()))
                    <p><strong>Sex ratio (M:F):</strong> No data available</p>
                  @else
                    <p><strong>Sex ratio (M:F):</strong> {{ count($males) }}:{{ count($females) }}
                  @endif
                  @if(is_null($properties->where("property_id", 7)->first()))
                    <p><strong>Weaning weight:</strong> No data available</p>
                  @else
                    @if($properties->where("property_id", 7)->first()->value == "")
                      <p><strong>Weaning weight:</strong> No data available</p>
                    @else
                      <p><strong>Weaning weight:</strong> {{ $properties->where("property_id", 7)->first()->value }} kg</p>
                    @endif
                  @endif
                  @if(is_null($properties->where("property_id", 7)->first()))
                    <p><strong>Age at weaning:</strong> No data available</p>
                  @else
                    @if($ageAtWeaning == "")
                      <p><strong>Age at weaning:</strong> No data available</p>
                    @else
                      <p><strong>Age at weaning:</strong> {{ $ageAtWeaning }} months</p>
                    @endif
                  @endif
                  @if($ageAtFirstMating != "")
                    <p><strong>Age at First Mating:</strong> {{ $ageAtFirstMating }} months</p>
                  @else
                    <p><strong>Age at First Mating:</strong> No data available</p>
                  @endif
                </div>
              </div>        
            </div>
          </div>
        </div>
        <div class="row">      
          <div class="col s12 card-panel white black-text center">
            <h5>Pedigree</h5>
            <div class="row">
              <div class="col s6">
                <div class="row">
                  
                </div>
                <div class="row">
                  
                </div>
                <div class="row">
                  {{-- <div class="col s10 offset-s1 green lighten-1"> --}}
                    {{ $sow->registryid }}
                  {{-- </div> --}}
                </div>
              </div>
              <div class="col s6">
                <div class="row">
                  {{-- <div class="col s10 offset-s1 blue lighten-2"> --}}
                    @if(!is_null($sow->getGrouping()))
                      @if(!is_null($sow->getGrouping()->getFather()))
                        {{ $sow->getGrouping()->getFather()->registryid }}
                      @else
                        @if(is_null($properties->where("property_id", 9)->first()))
                          No data of sire found
                        @else
                          {{ $properties->where("property_id", 9)->first()->value }}
                        @endif
                      @endif
                    @else
                      @if(is_null($properties->where("property_id", 9)->first()))
                        No data of sire found
                      @else
                        {{ $properties->where("property_id", 9)->first()->value }}
                      @endif
                    @endif
                  {{-- </div> --}}
                </div>
                <div class="row">

                </div>
                <div class="row">

                </div>
                <div class="row"> 
                  {{-- <div class="col s10 offset-s1 red lighten-4"> --}}
                    @if(!is_null($sow->getGrouping()))
                      @if(!is_null($sow->getGrouping()->getMother()))
                        {{ $sow->getGrouping()->getMother()->registryid }}
                      @else
                        @if(is_null($properties->where("property_id", 8)->first()))
                          No data of dam found
                        @else
                          {{ $properties->where("property_id", 8)->first()->value }}
                        @endif
                      @endif
                    @else
                      @if(is_null($properties->where("property_id", 8)->first()))
                        No data of dam found
                      @else
                        {{ $properties->where("property_id", 8)->first()->value }}
                      @endif
                    @endif
                  {{-- </div> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @if($sow->grossmorpho == 1)
            <div class="col s6 card-panel">
              <h6>GROSS MORPHOLOGY AT 180 DAYS</h6>
              <table>
                <tbody>
                  <tr>
                    <td>Hair Type</td>
                    <td>{{ $properties->where("property_id", 11)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Hair Length</td>
                    <td>{{ $properties->where("property_id", 12)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Coat Color</td>
                    <td>{{ $properties->where("property_id", 13)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Color Pattern</td>
                    <td>{{ $properties->where("property_id", 14)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Head Shape</td>
                    <td>{{ $properties->where("property_id", 15)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Skin Type</td>
                    <td>{{ $properties->where("property_id", 16)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Ear Type</td>
                    <td>{{ $properties->where("property_id", 17)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Tail Type</td>
                    <td>{{ $properties->where("property_id", 18)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Backline</td>
                    <td>{{ $properties->where("property_id", 19)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Other Marks</td>
                    <td>{{ $properties->where("property_id", 20)->first()->value }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          @endif
          @if($sow->morphochars == 1)
            <div class="col s6 card-panel">
              <h6>MORPHOMETRIC CHARACTERISTICS AT 180 DAYS</h6>
              <table>
                <tbody>
                  <tr>
                    <td>Ear Length</td>
                    @if($properties->where("property_id", 22)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 22)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Head Length</td>
                    @if($properties->where("property_id", 23)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 23)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Snout Length</td>
                    @if($properties->where("property_id", 24)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 24)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Length</td>
                    @if($properties->where("property_id", 25)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 25)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Heart Girth</td>
                    @if($properties->where("property_id", 26)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 26)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Pelvic Width</td>
                    @if($properties->where("property_id", 27)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 27)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Tail Length</td>
                    @if($properties->where("property_id", 28)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 28)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Height at Withers</td>
                    @if($properties->where("property_id", 29)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 29)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Number of Normal Teats</td>
                    @if($properties->where("property_id", 30)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 30)->first()->value }}</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Ponderal Index</td>
                    @if($properties->where("property_id", 31)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ round($properties->where("property_id", 31)->first()->value, 2) }} kg/m<sup>3</sup></td>
                    @endif
                  </tr>
                </tbody>
              </table>
            </div>
          @endif
        </div>
        <div class="row center">
          @if($sow->weightrecord == 1)
            <div class="col s6 push-s3 card-panel">
              <h6>WEIGHT RECORDS</h6>
              <table>
                <tbody>
                  <tr>
                    <td>Body Weight at 45 Days</td>
                    @if($properties->where("property_id", 32)->first()->value == "" || is_null($properties->where("property_id", 32)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 32)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 60 Days</td>
                    @if($properties->where("property_id", 33)->first()->value == "" || is_null($properties->where("property_id", 33)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 33)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 90 Days</td>
                    @if($properties->where("property_id", 34)->first()->value == "" || is_null($properties->where("property_id", 34)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 34)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 150 Days</td>
                    @if(is_null($properties->where("property_id", 35)->first()) || $properties->where("property_id", 35)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 35)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 180 Days</td>
                    @if($properties->where("property_id", 36)->first()->value == "" || is_null($properties->where("property_id", 36)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 36)->first()->value }} kg</td>
                    @endif
                  </tr>
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function(){
      $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false, // Close upon selecting a date,
        format: 'yyyy-mm-dd', 
        max: new Date()
      });
    });
  </script>
@endsection