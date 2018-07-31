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
                  @if(is_null($properties->where("property_id", 25)->first()))
                    <p><strong>Birth date:</strong> No data available</p>
                  @else
                    @if($properties->where("property_id", 25)->first()->value == "Not specified")
                      <p><strong>Birth date:</strong> No data available</p>
                    @else
                      <p><strong>Birth date:</strong> {{ Carbon\Carbon::parse($properties->where("property_id", 25)->first()->value)->format('j F, Y') }}</p>
                    @endif
                  @endif
                  @if(is_null($properties->where("property_id", 53)->first()))
                    <p><strong>Birth weight:</strong> No data available</p>
                  @else
                    @if($properties->where("property_id", 53)->first()->value == "")
                      <p><strong>Birth weight:</strong> No data available</p>
                    @else
                      <p><strong>Birth weight:</strong> {{ $properties->where("property_id", 53)->first()->value }} kg</p>
                    @endif
                  @endif
                  @if(is_null($sow->getGrouping()))
                    <p><strong>Litter-size Born Alive:</strong> No data available</p>
                  @else
                    <p><strong>Littersize Born Alive:</strong> {{ count($sow->getGrouping()->getGroupingMembers()) }}</p>
                  @endif
                  @if($ageAtFirstMating != "")
                    <p><strong>Age at First Mating:</strong> {{ $ageAtFirstMating }} months</p>
                  @else
                    <p><strong>Age at First Mating:</strong> No data available</p>
                  @endif
                </div>
                <div class="col s6">
                  @if(is_null($sow->getGrouping()))
                    <p><strong>Sex ratio (M:F):</strong> No data available</p>
                  @else
                    <p><strong>Sex ratio (M:F):</strong> {{ count($males) }}:{{ count($females) }}
                  @endif
                  @if(is_null($properties->where("property_id", 54)->first()))
                    <p><strong>Weaning weight:</strong> No data available</p>
                  @else
                    @if($properties->where("property_id", 54)->first()->value == "")
                      <p><strong>Weaning weight:</strong> No data available</p>
                    @else
                      <p><strong>Weaning weight:</strong> {{ $properties->where("property_id", 54)->first()->value }} kg</p>
                    @endif
                  @endif
                  @if(is_null($properties->where("property_id", 54)->first()))
                    <p><strong>Age at weaning:</strong> No data available</p>
                  @else
                    @if($ageAtWeaning == "")
                      <p><strong>Age at weaning:</strong> No data available</p>
                    @else
                      <p><strong>Age at weaning:</strong> {{ $ageAtWeaning }} months</p>
                    @endif
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
                        @if(is_null($properties->where("property_id", 87)->first()))
                          No data of father found
                        @else
                          {{ $properties->where("property_id", 87)->first()->value }}
                        @endif
                      @endif
                    @else
                      @if(is_null($properties->where("property_id", 87)->first()))
                        No data of father found
                      @else
                        {{ $properties->where("property_id", 87)->first()->value }}
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
                        @if(is_null($properties->where("property_id", 86)->first()))
                          No data of mother found
                        @else
                          {{ $properties->where("property_id", 86)->first()->value }}
                        @endif
                      @endif
                    @else
                      @if(is_null($properties->where("property_id", 86)->first()))
                        No data of mother found
                      @else
                        {{ $properties->where("property_id", 86)->first()->value }}
                      @endif
                    @endif
                  {{-- </div> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @if($sow->phenotypic == 1)
            <div class="col s6 card-panel">
              <h6>GROSS MORPHOLOGY</h6>
              <table>
                <tbody>
                  <tr>
                    <td>Hair Type</td>
                    <td>{{ $properties->where("property_id", 28)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Hair Length</td>
                    <td>{{ $properties->where("property_id", 29)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Coat Color</td>
                    <td>{{ $properties->where("property_id", 30)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Color Pattern</td>
                    <td>{{ $properties->where("property_id", 31)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Head Shape</td>
                    <td>{{ $properties->where("property_id", 32)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Skin Type</td>
                    <td>{{ $properties->where("property_id", 33)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Ear Type</td>
                    <td>{{ $properties->where("property_id", 34)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Tail Type</td>
                    <td>{{ $properties->where("property_id", 62)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Backline</td>
                    <td>{{ $properties->where("property_id", 35)->first()->value }}</td>
                  </tr>
                  <tr>
                    <td>Other Marks</td>
                    <td>{{ $properties->where("property_id", 36)->first()->value }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          @endif
          @if($sow->morphometric == 1)
            <div class="col s6 card-panel">
              <h6>MORPHOMETRIC CHARACTERISTICS</h6>
              <table>
                <tbody>
                  <tr>
                    <td>Ear Length</td>
                    @if($properties->where("property_id", 64)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 64)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Head Length</td>
                    @if($properties->where("property_id", 39)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 39)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Snout Length</td>
                    @if($properties->where("property_id", 63)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 63)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Length</td>
                    @if($properties->where("property_id", 40)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 40)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Heart Girth</td>
                    @if($properties->where("property_id", 42)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 42)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Pelvic Width</td>
                    @if($properties->where("property_id", 41)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 41)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Tail Length</td>
                    @if($properties->where("property_id", 65)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 65)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Height at Withers</td>
                    @if($properties->where("property_id", 66)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 66)->first()->value }} cm</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Ponderal Index</td>
                    @if($properties->where("property_id", 43)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ round($properties->where("property_id", 43)->first()->value, 2) }} kg/m<sup>3</sup></td>
                    @endif
                  </tr>
                  <tr>
                    <td>Number of Normal Teats</td>
                    @if($properties->where("property_id", 44)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 44)->first()->value }}</td>
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
                    @if($properties->where("property_id", 45)->first()->value == "" || is_null($properties->where("property_id", 45)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 45)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 60 Days</td>
                    @if($properties->where("property_id", 46)->first()->value == "" || is_null($properties->where("property_id", 46)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 46)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 90 Days</td>
                    @if($properties->where("property_id", 69)->first()->value == "" || is_null($properties->where("property_id", 69)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 69)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 150 Days</td>
                    @if(is_null($properties->where("property_id", 90)->first()) || $properties->where("property_id", 90)->first()->value == "")
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 90)->first()->value }} kg</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Body Weight at 180 Days</td>
                    @if($properties->where("property_id", 47)->first()->value == "" || is_null($properties->where("property_id", 47)->first()))
                      <td>Not specified</td>
                    @else
                      <td>{{ $properties->where("property_id", 47)->first()->value }} kg</td>
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