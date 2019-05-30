@extends('layouts.swinedefault')

@section('title')
  Weight Records
@endsection

@section('content')
  <h4 class="headline"><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="3%"></a> Weight Records: <strong>{{ $animal->registryid }}</strong></h4>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.fetch_weight_records', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s4">
              Body Weight at 45 Days
            </div>
            @if($age_weaned == 45)
              <div class="col s4">
                <input id="body_weight_at_45_days" type="number" placeholder="Weight" name="body_weight_at_45_days" value="{{ $properties->where("property_id", 7)->first()->value }}" class="validate" min="0" step="0.001">
                <input type="hidden" name="body_weight_at_45_days" value="{{ $properties->where("property_id", 7)->first()->value }}">
              </div>
              <div class="col s4">
                <input id="date_collected_45_days" type="text" placeholder="Date Collected" name="date_collected_45_days" value="{{ Carbon\Carbon::parse($properties->where("property_id", 6)->first()->value)->format('Y-m-d') }}" class="datepicker">
              </div>
            @else
              <div class="col s4">
                <input id="body_weight_at_45_days" type="number" placeholder="Weight" name="body_weight_at_45_days" class="validate" min="0" step="0.001">
              </div>
              <div class="col s4">
                <input id="date_collected_45_days" type="text" placeholder="Date Collected" name="date_collected_45_days" class="datepicker">
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 60 Days
            </div>
            @if($age_weaned == 60)
              <div class="col s4">
                <input id="body_weight_at_60_days" type="number" placeholder="Weight" name="body_weight_at_60_days" value="{{ $properties->where("property_id", 7)->first()->value }}" class="validate" min="0" step="0.001">
                <input type="hidden" name="body_weight_at_60_days" value="{{ $properties->where("property_id", 7)->first()->value }}">
              </div>
              <div class="col s4">
                <input id="date_collected_60_days" type="text" placeholder="Date Collected" name="date_collected_60_days" value="{{ Carbon\Carbon::parse($properties->where("property_id", 6)->first()->value)->format('Y-m-d') }}" class="datepicker">
              </div>
            @else
              <div class="col s4">
                <input id="body_weight_at_60_days" type="number" placeholder="Weight" name="body_weight_at_60_days" class="validate" min="0" step="0.001">
              </div>
              <div class="col s4">
                <input id="date_collected_60_days" type="text" placeholder="Date Collected" name="date_collected_60_days" class="datepicker">
              </div>
            @endif
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 90 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_90_days" type="number" placeholder="Weight" name="body_weight_at_90_days" class="validate" min="0" step="0.001">
            </div>
            <div class="col s4">
              <input id="date_collected_90_days" type="text" placeholder="Date Collected" name="date_collected_90_days" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 150 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_150_days" type="number" placeholder="Weight" name="body_weight_at_150_days" class="validate" min="0" max="50.999" step="0.001">
            </div>
            <div class="col s4">
              <input id="date_collected_150_days" type="text" placeholder="Date Collected" name="date_collected_150_days" class="datepicker">
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              Body Weight at 180 Days
            </div>
            <div class="col s4">
              <input id="body_weight_at_180_days" type="number" placeholder="Weight" name="body_weight_at_180_days" class="validate" min="0" max="50.999" step="0.001">
            </div>
            <div class="col s4">
              <input id="date_collected_180_days" type="text" placeholder="Date Collected" name="date_collected_180_days" class="datepicker">
            </div>
          </div>
        </div>
        <div class="row center">
          <button class="btn waves-effect waves-light green darken-3" type="submit">Save
            <i class="material-icons right">save</i>
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
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
  </script>
@endsection