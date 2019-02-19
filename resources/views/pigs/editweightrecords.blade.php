@extends('layouts.swinedefault')

@section('title')
  Edit Weight Records
@endsection

@section('content')
  <h5 class="headline"><a href="{{$_SERVER['HTTP_REFERER']}}"><img src="{{asset('images/back.png')}}" width="2.5%"></a> Edit Weight Records: <strong>{{ $animal->registryid }}</strong></h5>
  <div class="container">
    <div class="row">
      {!! Form::open(['route' => 'farm.pig.update_weight_records', 'method' => 'post']) !!}
      <div class="col s12">
        <input type="hidden" name="animal_id" value="{{ $animal->id }}">
        <div class="row card-panel">
          <div class="row">
            <div class="col s4">
              @if($age_weaned != "")
                Weaning Weight <i class="material-icons tooltipped" data-position="top" data-tooltip="Age weaned: {{ $age_weaned }} days" style="vertical-align: middle;">info_outline</i>
              @else
                Weaning Weight
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 7)->first()))
                <input id="weaning_weight" type="text" placeholder="Weight" name="weaning_weight" value="{{ $properties->where("property_id", 7)->first()->value }}" class="validate">
              @else
                <input id="weaning_weight" type="text" placeholder="Weight" name="weaning_weight" class="validate">
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 6)->first()))
                <input id="date_weaned" type="text" placeholder="Date Collected" name="date_weaned" value="{{ $properties->where("property_id", 6)->first()->value }}" class="datepicker">
              @else
                <input id="date_weaned" type="text" placeholder="Date Collected" name="date_weaned" class="datepicker">
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              @if($actual45d != "")
                @if($actual45d != 45)
                  Body Weight at 45 Days <i class="material-icons tooltipped" data-position="top" data-tooltip="Actual: {{ $actual45d }} days" style="vertical-align: middle;">info_outline</i>
                @elseif($actual45d == 45)
                  Body Weight at 45 Days
                @endif
              @else
                Body Weight at 45 Days
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 32)->first()))
                <input id="body_weight_at_45_days" type="text" placeholder="Weight" name="body_weight_at_45_days" value="{{ $properties->where("property_id", 32)->first()->value }}" class="validate">
              @else
                <input id="body_weight_at_45_days" type="text" placeholder="Weight" name="body_weight_at_45_days" class="validate">
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 37)->first()))
                <input id="date_collected_45_days" type="text" placeholder="Date Collected" name="date_collected_45_days" value="{{ $properties->where("property_id", 37)->first()->value }}" class="datepicker">
              @else
                <input id="date_collected_45_days" type="text" placeholder="Date Collected" name="date_collected_45_days" class="datepicker">
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              @if($actual60d != "")
                @if($actual60d != 60)
                  Body Weight at 60 Days <i class="material-icons tooltipped" data-position="top" data-tooltip="Actual: {{ $actual60d }} days" style="vertical-align: middle;">info_outline</i>
                @elseif($actual60d == 60)
                  Body Weight at 60 Days
                @endif
              @else
                Body Weight at 60 Days
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 33)->first()))
                <input id="body_weight_at_60_days" type="text" placeholder="Weight" name="body_weight_at_60_days" value="{{ $properties->where("property_id", 33)->first()->value }}" class="validate">
              @else
                <input id="body_weight_at_60_days" type="text" placeholder="Weight" name="body_weight_at_60_days" class="validate">
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 38)->first()))
                <input id="date_collected_60_days" type="text" placeholder="Date Collected" name="date_collected_60_days" value="{{ $properties->where("property_id", 38)->first()->value }}" class="datepicker">
              @else
                <input id="date_collected_60_days" type="text" placeholder="Date Collected" name="date_collected_60_days" class="datepicker">
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              @if($actual90d != "")
                @if($actual90d != 90)
                  Body Weight at 90 Days <i class="material-icons tooltipped" data-position="top" data-tooltip="Actual: {{ $actual90d }} days" style="vertical-align: middle;">info_outline</i>
                @elseif($actual90d == 90)
                  Body Weight at 90 Days
                @endif
              @else
                Body Weight at 90 Days
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 34)->first()))
                <input id="body_weight_at_90_days" type="text" placeholder="Weight" name="body_weight_at_90_days" value="{{ $properties->where("property_id", 34)->first()->value }}" class="validate">
              @else
                <input id="body_weight_at_90_days" type="text" placeholder="Weight" name="body_weight_at_90_days" class="validate">
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 39)->first()))
                <input id="date_collected_90_days" type="text" placeholder="Date Collected" name="date_collected_90_days" value="{{ $properties->where("property_id", 39)->first()->value }}" class="datepicker">
              @else
                <input id="date_collected_90_days" type="text" placeholder="Date Collected" name="date_collected_90_days" class="datepicker">
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              @if($actual150d != "")
                @if($actual150d != 150)
                  Body Weight at 150 Days <i class="material-icons tooltipped" data-position="top" data-tooltip="Actual: {{ $actual150d }} days" style="vertical-align: middle;">info_outline</i>
                @elseif($actual150d == 150)
                  Body Weight at 150 Days
                @endif
              @else
                Body Weight at 150 Days
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 35)->first()))
                <input id="body_weight_at_150_days" type="text" placeholder="Weight" name="body_weight_at_150_days" value="{{ $properties->where("property_id", 35)->first()->value }}" class="validate">
              @else
                <input id="body_weight_at_150_days" type="text" placeholder="Weight" name="body_weight_at_150_days" class="validate">
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 40)->first()))
                <input id="date_collected_150_days" type="text" placeholder="Date Collected" name="date_collected_150_days" value="{{ $properties->where("property_id", 40)->first()->value }}" class="datepicker">
              @else
                <input id="date_collected_150_days" type="text" placeholder="Date Collected" name="date_collected_150_days" class="datepicker">
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col s4">
              @if($actual180d != "")
                @if($actual180d != 180)
                  Body Weight at 180 Days <i class="material-icons tooltipped" data-position="top" data-tooltip="Actual: {{ $actual180d }} days" style="vertical-align: middle;">info_outline</i>
                @elseif($actual180d == 180)
                  Body Weight at 180 Days
                @endif
              @else
                Body Weight at 180 Days
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 36)->first()))
                <input id="body_weight_at_180_days" type="text" placeholder="Weight" name="body_weight_at_180_days" value="{{ $properties->where("property_id", 36)->first()->value }}" class="validate">
              @else
                <input id="body_weight_at_180_days" type="text" placeholder="Weight" name="body_weight_at_180_days" class="validate">
              @endif
            </div>
            <div class="col s4">
              @if(!is_null($properties->where("property_id", 41)->first()))
                <input id="date_collected_180_days" type="text" placeholder="Date Collected" name="date_collected_180_days" value="{{ $properties->where("property_id", 41)->first()->value }}" class="datepicker">
              @else
                <input id="date_collected_180_days" type="text" placeholder="Date Collected" name="date_collected_180_days" class="datepicker">
              @endif
            </div>
          </div>
        </div>
        <div class="row center">
          <button class="btn waves-effect waves-light green darken-3" type="submit" onclick="Materialize.toast('Successfully updated!', 4000)">Update
            <i class="material-icons right">done</i>
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
        // min: new Date(<?php echo Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(1)->format('Y') ?>, <?php echo Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(1)->format('m')-1 ?>, <?php echo Carbon\Carbon::parse($properties->where("property_id", 3)->first()->value)->addDays(1)->format('d') ?>),
        max: new Date()
      });
  </script>
@endsection