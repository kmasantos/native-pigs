@extends('layouts.swinedefault')

@section('title')
  View Sow
@endsection

@section('content')
  <h4 class="headline"><a href="{{route('farm.pig.morphology')}}"><img src="{{asset('images/back.png')}}" width="3%"></a> View Sow</h4>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <div class="row">
          <div class="col s4">
            <img src="{{asset('images/sow.jpg')}}" width="90%">
          </div>
          <div class="col s8">
            <div class="white black-text">
              <h5>{{ $sow->registryid }}</h5>
            </div>
            <div style="margin-top:10px;">
              <div class="col s5 card-panel white black-text center">
                <h5>{{ $age }} months</h5>
                <p>Age</p>
              </div>
              <div class="col s5 push-s2 card-panel white black-text center">
                <h5>{{ $properties->where("property_id", 47)->first()->value }} kg</h5>
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
          <div class="col s6">
            <table>
              <tbody>
                <tr>
                  <td>Age at First Mating</td>
                  <td> months</td>
                </tr>
                 <tr>
                  <td>Ear Length</td>
                  <td>{{ $properties->where("property_id", 64)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Head Length</td>
                  <td>{{ $properties->where("property_id", 39)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Snout Length</td>
                  <td>{{ $properties->where("property_id", 63)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Body Length</td>
                  <td>{{ $properties->where("property_id", 40)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Heart Girth</td>
                  <td>{{ $properties->where("property_id", 42)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Pelvic Width</td>
                  <td>{{ $properties->where("property_id", 41)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Tail Length</td>
                  <td>{{ $properties->where("property_id", 65)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Height at Withers</td>
                  <td>{{ $properties->where("property_id", 66)->first()->value }} cm</td>
                </tr>
                <tr>
                  <td>Ponderal Index</td>
                  <td>{{ $properties->where("property_id", 43)->first()->value }} kg/m<sup>3</sup></td>
                </tr>
                <tr>
                  <td>Number of Normal Teats</td>
                  <td>{{ $properties->where("property_id", 44)->first()->value }}</td>
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
                  <td>{{ $properties->where("property_id", 45)->first()->value }} kg</td>
                </tr>
                <tr>
                  <td>Body Weight at 60 Days</td>
                  <td>{{ $properties->where("property_id", 46)->first()->value }} kg</td>
                </tr>
                <tr>
                  <td>Body Weight at 90 Days</td>
                  <td>{{ $properties->where("property_id", 69)->first()->value }} kg</td>
                </tr>
                <tr>
                  <td>Body Weight at 180 Days</td>
                  <td>{{ $properties->where("property_id", 47)->first()->value }} kg</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection